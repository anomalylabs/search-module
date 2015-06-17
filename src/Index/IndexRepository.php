<?php namespace Anomaly\SearchModule\Index;

use Anomaly\SearchModule\Index\Contract\IndexInterface;
use Anomaly\SearchModule\Index\Contract\IndexRepositoryInterface;

/**
 * Class IndexRepository
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\SearchModule\Index
 */
class IndexRepository implements IndexRepositoryInterface
{

    /**
     * The index model.
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

    /**
     * Create a new index entry.
     *
     * @param array $attributes
     * @return IndexInterface
     */
    public function save(array $attributes)
    {
        $this->model->create(
            [
            ]
        );
    }
}
