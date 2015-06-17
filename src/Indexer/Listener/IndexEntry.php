<?php namespace Anomaly\SearchModule\Indexer\Listener;

use Anomaly\Streams\Platform\Entry\Event\EntryWasSaved;
use Illuminate\Foundation\Bus\DispatchesCommands;

/**
 * Class IndexEntry
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\SearchModule\Indexer\Listener
 */
class IndexEntry
{

    use DispatchesCommands;

    /**
     * Handle the event.
     *
     * @param EntryWasSaved $event
     */
    public function handle(EntryWasSaved $event)
    {
        $this->dispatch(new \Anomaly\SearchModule\Indexer\Command\IndexEntry($event->getEntry()));
    }
}
