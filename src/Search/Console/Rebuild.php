<?php namespace Anomaly\SearchModule\Search\Console;

use Anomaly\Streams\Platform\Addon\Module\Module;
use Anomaly\Streams\Platform\Addon\Module\ModuleCollection;
use Anomaly\Streams\Platform\Entry\EntryModel;
use Illuminate\Console\Command;
use Illuminate\Contracts\Config\Repository;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Symfony\Component\Console\Input\InputArgument;

/**
 * Class Rebuild
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\SearchModule\Search\Console
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
    protected $description = 'Rebuild a search collection(s).';

    /**
     * Execute the console command.
     *
     * @param ModuleCollection $modules
     * @param Repository       $config
     */
    public function fire(ModuleCollection $modules, Repository $config)
    {
        $rebuild = $this->argument('collection');

        /* @var Module $module */
        foreach ($modules->withConfig('search') as $module) {
            foreach ($config->get($module->getNamespace('search')) as $model => $search) {

                /* @var EntryModel $model */
                $model = new $model;

                $collection = array_get($search, 'collection', $model->getStreamSlug());

                if (!$rebuild || $collection == $rebuild) {

                    $this->info('Rebuilding ' . $collection);

                    $this->output->progressStart($model->count());

                    foreach ($model->all() as $entry) {

                        $entry->save();

                        $this->output->progressAdvance();
                    }

                    $this->output->progressFinish();
                }
            }
        }
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return [
            ['collection', InputArgument::OPTIONAL, 'The collection to rebuild.']
        ];
    }
}
