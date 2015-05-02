<?php namespace Anomaly\SearchModule\Index\Listener;

use Anomaly\Streams\Platform\Entry\Event\EntryWasSaved;
use Illuminate\Foundation\Bus\DispatchesCommands;

/**
 * Class IndexEntry
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\SearchModule\Index\Listener
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
        $entry = $event->getEntry();

        if (class_exists($indexer = substr(get_class($entry), 0, -5) . 'Indexer')) {
            app()->call($indexer . '@handle', compact('entry'));
        }
    }
}
