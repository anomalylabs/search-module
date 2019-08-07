<?php namespace Anomaly\SearchModule;

use Anomaly\SearchModule\Item\Contract\ItemRepositoryInterface;
use Anomaly\SearchModule\Search\SearchCriteria;
use Anomaly\Streams\Platform\Addon\Plugin\Plugin;
use Anomaly\Streams\Platform\Entry\Contract\EntryInterface;

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
            new \Twig_SimpleFunction(
                'search',
                function ($search) {

                    /* @var ItemRepositoryInterface $repository */
                    $repository = app(ItemRepositoryInterface::class);

                    /* @var EntryInterface $model */
                    $query = $repository->newQuery();
                    $model = $repository->getModel();

                    $query->where(
                        function (\Illuminate\Database\Eloquent\Builder $query) use ($search) {

                            // removing symbols used by MySQL
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

                            $match = app('db')->raw(
                                'MATCH (title,description) AGAINST ("' . implode(' ', $words) . '")'
                            );

                            //$query->addSelect($match . ' AS _score');
                            $query->where($match, '>=', 6);
                            $query->orderBy($match, 'ASC');

                            if (count($words) > 1) {
                                foreach ($words as $k => $word) {

                                    $match = app('db')->raw('MATCH (title,description) AGAINST ("' . $word . '")');

                                    //$query->addSelect($match . ' AS _score' . ($k + 1));
                                    $query->orWhere($match, '>=', 6);
                                    $query->orderBy($match, 'ASC');
                                }
                            }
                        }
                    );

                    return new SearchCriteria($query, $model->getStream(), 'get');
                }
            ),
        ];
    }
}
