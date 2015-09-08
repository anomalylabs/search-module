<?php namespace Anomaly\SearchModule\Console;

use Anomaly\Streams\Platform\Addon\AddonCollection;
use Anomaly\Streams\Platform\Addon\Module\Module;
use Illuminate\Console\Command;
use Illuminate\Contracts\Config\Repository;
use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Mmanos\Search\Search;

/**
 * Class Rebuild
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\SearchModule\Page\Console
 */
class Rebuild extends Command
{

    use DispatchesJobs;

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'search:rebuild';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Rebuild the search index.';

    /**
     * Execute the console command.
     *
     * @param AddonCollection $addons
     * @param Repository      $config
     * @param Search          $search
     */
    public function fire(AddonCollection $addons, Repository $config, Search $search)
    {
        $search->deleteIndex();

        $this->info('Index cleared.');

        /* @var Module $module */
        foreach ($addons->modules() as $module) {

            if ($module->getSlug() === 'search') {
                continue;
            }

            foreach ($config->get($module->getNamespace('search'), []) as $model => $indexes) {

                $this->info('Indexing ' . $model);

                $model = new $model;

                foreach ($model->all() as $entry) {
                    $entry->save();
                }
            }
        }
    }
}
