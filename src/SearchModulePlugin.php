<?php

namespace Anomaly\SearchModule;

use Illuminate\Support\Facades\DB;
use Anomaly\SearchModule\Search\SearchCriteria;
use Anomaly\Streams\Platform\Addon\Plugin\Plugin;
use Anomaly\Streams\Platform\Entry\Contract\EntryInterface;
use Anomaly\SearchModule\Item\Contract\ItemRepositoryInterface;
use Twig\TwigFunction;

/**
 * Class SearchModulePlugin
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class SearchModulePlugin extends Plugin
{

    /**
     * Get the functions.
     *
     * @return array
     */
    public function getFunctions()
    {
        return [
            new TwigFunction(
                'search',
                function ($search, $options = []) {

                    /* @var ItemRepositoryInterface $repository */
                    $repository = app(ItemRepositoryInterface::class);

                    /* @var EntryInterface $model */
                    $query = $repository->newQuery();
                    $model = $repository->getModel();

                    /**
                     * Restrict the query to the active locale.
                     */
                    $query->where('locale', array_get($options, 'locale', config('app.locale')));

                    $query->where(
                        function ($query) use ($search, $options) {

                            $threshold = array_get($options, 'threshold', 3);

                            /**
                             * Remove symbols used by MySQL.
                             */
                            $reservedSymbols = ['-', '+', '<', '>', '@', '(', ')', '~'];
                            $term            = str_replace($reservedSymbols, '', $search);

                            $words = explode(' ', $term);

                            foreach ($words as $key => $word) {

                                /*
                                 * applying + operator (required word) only big words
                                 * because smaller ones are not indexed by mysql
                                 */
                                if (strlen($word) >= 3) {
                                    $words[$key] = '+' . $word . '*';
                                }
                            }

                            /**
                             * Match the primary index fields.
                             * Title and description should trump
                             * anything else that get's matched.
                             */
                            $against = implode(' ', $words);

                            $primary = 'MATCH (title,description) AGAINST (?)';

                            $query->addSelect('*');
                            $query->selectRaw($primary . ' AS _primary_score', [$against]);
                            $query->whereRaw($primary . ' >= ?', [$against, $threshold]);
                            $query->orderByRaw($primary . ' DESC', [$against]);

                            /**
                             * Match in the searchable data
                             * if possible. Expect lower scores.
                             */
                            $secondary = 'MATCH (searchable) AGAINST (?)';

                            $query->selectRaw($secondary . ' AS _secondary_score', [$against]);
                            $query->orWhereRaw($secondary . ' >= ?', [$against, $threshold]);
                            $query->orderByRaw($secondary . ' DESC', [$against]);

                            /**
                             * Match multiple words against
                             * the primary fields as well.
                             */
                            if (count($words) > 1) {
                                foreach ($words as $k => $word) {

                                    $query->selectRaw($primary . ' AS _sub_score_' . ($k + 1), [$word]);
                                    $query->orWhereRaw($primary . ' >= ?', [$word, $threshold]);
                                    $query->orderByRaw($primary . ' DESC', [$word]);
                                }
                            }

                            $query->orWhere('title', 'LIKE', '%' . $search . '%');
                            $query->orWhere('description', 'LIKE', '%' . $search . '%');
                            $query->orWhere('searchable', 'LIKE', '%' . $search . '%');
                        }
                    );

                    return new SearchCriteria($query, $model->getStream(), 'get');
                }
            ),
        ];
    }
}
