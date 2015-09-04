<?php namespace Anomaly\SearchModule\Index\Table;

use Anomaly\Streams\Platform\Support\Collection;
use Mmanos\Search\Search;

class IndexTableEntries
{

    public function handle(IndexTableBuilder $builder, Search $search)
    {
        $results = [];

        if ($term = $builder->getTableFilter('term')->getValue()) {

            $search = $search->search(null, $term);

            $results = $search->get();
        }

        $builder->setTableEntries(new Collection($results));
    }
}
