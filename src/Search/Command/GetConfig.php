<?php namespace Anomaly\SearchModule\Search\Command;

use Anomaly\Streams\Platform\Addon\Module\Module;
use Anomaly\Streams\Platform\Addon\Module\ModuleCollection;
use Anomaly\Streams\Platform\Entry\Contract\EntryInterface;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Contracts\Config\Repository;

/**
 * Class GetConfig
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\SearchModule\Search\Command
 */
class GetConfig implements SelfHandling
{

    /**
     * The entry instance.
     *
     * @var EntryInterface
     */
    protected $entry;

    /**
     * Create a new GetConfig instance.
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
     * @param ModuleCollection $modules
     * @param Repository       $config
     * @return mixed|null
     */
    public function handle(ModuleCollection $modules, Repository $config)
    {
        /* @var Module $module */
        foreach ($modules->withConfig('search.' . get_class($this->entry)) as $module) {
            return $config->get(
                $module->getNamespace(
                    'search.' . get_class($this->entry)
                )
            );
        }

        return null;
    }
}
