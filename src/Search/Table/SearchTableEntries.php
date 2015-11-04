<?php namespace Anomaly\SearchModule\Search\Table;

use Anomaly\Streams\Platform\Support\Collection;
use Mmanos\Search\Search;

/**
 * Class SearchTableEntries
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\SearchModule\Search\Table
 */
class SearchTableEntries
{

    /**
     * Handle the table entries.
     *
     * @param SearchTableBuilder $builder
     * @param Search             $search
     */
    public function handle(SearchTableBuilder $builder, Search $search)
    {
        $results = [];

        if ($term = $builder->getTableFilterValue('term')) {

            $query = $search
                ->search(['title', 'description', 'keywords'], $term, ['fuzzy' => 0.3]);

            $query->search('collection', 'pages', ['required' => false]);

            $results = $query->get();
        }

        foreach ($results as &$result) {
            $result['keywords'] = explode(',', array_get($result, 'keywords', ''));
        }

        $builder->setTableEntries(new Collection($results));
    }
}
