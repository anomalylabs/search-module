<?php namespace Anomaly\SearchModule\Index;

use Anomaly\SearchModule\Index\Contract\IndexRepositoryInterface;
use Anomaly\Streams\Platform\Entry\EntryRepository;

class IndexRepository extends EntryRepository implements IndexRepositoryInterface
{

    /**
     * The entry model.
     *
     * @var IndexModel
     */
    protected $model;

    /**
     * Create a new IndexRepository instance.
     *
     * @param IndexModel $model
     */
    public function __construct(IndexModel $model)
    {
        $this->model = $model;
    }
}
