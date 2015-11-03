<?php namespace Anomaly\SearchModule\Search\Listener;

use Anomaly\SearchModule\Search\SearchManager;
use Anomaly\Streams\Platform\Addon\AddonCollection;
use Anomaly\Streams\Platform\Addon\Module\Module;
use Anomaly\Streams\Platform\Entry\Event\EntryWasDeleted;
use Illuminate\Contracts\Config\Repository;
use Illuminate\Contracts\Container\Container;

/**
 * Class DeleteItem
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\SearchModule\Search\Listener
 */
class DeleteItem
{

    /**
     * The config repository.
     *
     * @var Repository
     */
    protected $config;

    /**
     * The addon collection.
     *
     * @var AddonCollection
     */
    protected $addons;

    /**
     * The index manager.
     *
     * @var SearchManager
     */
    protected $manager;

    /**
     * Create a new DeleteItem instance.
     *
     * @param Repository      $config
     * @param AddonCollection $addons
     * @param SearchManager    $manager
     */
    public function __construct(Repository $config, AddonCollection $addons, SearchManager $manager)
    {
        $this->config  = $config;
        $this->addons  = $addons;
        $this->manager = $manager;
    }

    /**
     * Handle the event.
     *
     * @param EntryWasDeleted $event
     */
    public function handle(EntryWasDeleted $event)
    {
        $entry = $event->getEntry();

        /* @var Module $module */
        foreach ($this->addons->modules() as $module) {

            $key = $module->getNamespace('search.' . get_class($entry));

            foreach ($this->config->get($key, []) as $index => $config) {
                $this->manager
                    ->setIndex($index)
                    ->setReference($entry)
                    ->delete();
            }
        }
    }
}
