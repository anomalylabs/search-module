<?php namespace Anomaly\SearchModule\Indexer\Command;

use Anomaly\SearchModule\Indexer\IndexerResolver;
use Anomaly\Streams\Platform\Entry\Contract\EntryInterface;
use Illuminate\Contracts\Bus\SelfHandling;

/**
 * Class IndexEntry
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\SearchModule\Indexer\Command
 */
class IndexEntry implements SelfHandling
{

    /**
     * The entry interface.
     *
     * @var EntryInterface
     */
    protected $entry;

    /**
     * Create a new IndexEntry instance.
     *
     * @param EntryInterface $entry
     */
    public function __construct(EntryInterface $entry)
    {
        $this->entry = $entry;
    }

    /**
     * Handle the command.
     *
     * @param IndexerResolver $resolver
     */
    public function handle(IndexerResolver $resolver)
    {
        if (!$indexer = $resolver->resolve($this->entry)) {
            return;
        }

        $indexer->index();
    }
}
