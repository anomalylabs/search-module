<?php namespace Anomaly\SearchModule\Index\Listener;

use Anomaly\SearchModule\Index\EntryIndex;
use Anomaly\Streams\Platform\Entry\Contract\EntryInterface;
use Anomaly\Streams\Platform\Entry\Event\EntryWasDeleted;
use Illuminate\Contracts\Container\Container;
use Mmanos\Search\Search;

/**
 * Class DeleteReference
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\SearchModule\Index\Listener
 */
class DeleteReference
{

    /**
     * The search utility.
     *
     * @var Search
     */
    protected $search;

    /**
     * The service container.
     *
     * @var Container
     */
    protected $container;

    /**
     * Create a new DeleteReference instance.
     *
     * @param Search    $search
     * @param Container $container
     */
    public function __construct(Search $search, Container $container)
    {
        $this->search    = $search;
        $this->container = $container;
    }

    /**
     * Handle the event.
     *
     * @param EntryWasDeleted $event
     */
    public function handle(EntryWasDeleted $event)
    {
        $entry = $event->getEntry();

        if (!$index = $this->resolveEntryIndex($entry)) {
            return;
        }

        $index->delete();
    }

    /**
     * Return a new instance of the entry index.
     *
     * @param EntryInterface $entry
     * @return EntryIndex|null
     */
    protected function resolveEntryIndex(EntryInterface $entry)
    {
        $index = get_class($entry) . 'SearchIndex';

        if (class_exists($index) || $this->container->bound($index)) {
            return $this->container->make($index, ['reference' => $entry, 'search' => $this->search]);
        }

        return null;
    }
}
