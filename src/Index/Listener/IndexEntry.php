<?php namespace Anomaly\SearchModule\Index\Listener;

use Anomaly\Streams\Platform\Entry\Event\EntryWasSaved;
use Illuminate\Contracts\Container\Container;
use Mmanos\Search\Index;

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

    /**
     * The search index.
     *
     * @var Index
     */
    protected $index;

    /**
     * Create a new IndexEntry instance.
     *
     * @param Container $container
     */
    public function __construct(Container $container)
    {
        config()->set('search', config('anomaly.module.search::search'));

        $this->index = $container->make('search');
    }

    /**
     * Handle the event.
     *
     * @param EntryWasSaved $event
     */
    public function handle(EntryWasSaved $event)
    {
        $entry = $event->getEntry();

        if ($entry->getStreamNamespace() !== 'staff') {
            return;
        }

        $this->index->delete("{$entry->getStreamNamespace()}.{$entry->getStreamSlug()}::{$entry->getId()}");
        $this->index->insert(
            "{$entry->getStreamNamespace()}.{$entry->getStreamSlug()}::{$entry->getId()}",
            [
                'title' => $entry->title
            ],
            [
                'title' => $entry->title,
                'resource_type' => get_class($entry),
                'resource_id'   => $entry->getId()
            ]
        );
    }
}
