<?php namespace Anomaly\SearchModule\Index\Table;

use Anomaly\Streams\Platform\Support\Collection;
use Mmanos\Search\Search;

/**
 * Class IndexTableEntries
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\SearchModule\Index\Table
 */
class IndexTableEntries
{

    /**
     * Handle the table entries.
     *
     * @param IndexTableBuilder $builder
     * @param Search            $search
     */
    public function handle(IndexTableBuilder $builder, Search $search)
    {
        $results = [];

        if ($term = $builder->getTableFilterValue('term')) {

            $search = $search->search(null, $term, ['fuzzy' => 0.2]);

            $results = $search->get();
        }

        foreach ($results as &$result) {
            $result['reference'] = (new $result['reference_type'])->find($result['reference_id']);
        }

        $builder->setTableEntries(new Collection($results));
    }
}
