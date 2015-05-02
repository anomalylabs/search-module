<?php namespace Anomaly\SearchModule\Index;

use Anomaly\SearchModule\Index\Contract\IndexRepositoryInterface;
use Anomaly\Streams\Platform\Entry\Contract\EntryInterface;

/**
 * Class IndexHandler
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\SearchModule\Index
 */
class IndexHandler
{

    /**
     * The index repository.
     *
     * @var IndexRepositoryInterface
     */
    protected $repository;

    /**
     * Create a new IndexHandler instance.
     *
     * @param IndexRepositoryInterface $repository
     */
    function __construct(IndexRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Handle the entry indexing.
     *
     * @param EntryInterface $entry
     */
    public function handle(EntryInterface $entry)
    {
    }
}
