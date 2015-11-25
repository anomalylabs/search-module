<?php namespace Anomaly\SearchModule\Search\Console;

use Anomaly\Streams\Platform\Addon\Module\Module;
use Anomaly\Streams\Platform\Addon\Module\ModuleCollection;
use Anomaly\Streams\Platform\Entry\EntryModel;
use App\Console\Kernel;
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
    protected $description = 'Rebuild a searchable stream(s).';

    /**
     * Execute the console command.
     *
     * @param ModuleCollection $modules
     * @param Repository       $config
     * @param Kernel           $console
     */
    public function fire(ModuleCollection $modules, Repository $config, Kernel $console)
    {
        $rebuild = $this->argument('stream');

        $console->call('search:destroy');

        /* @var Module $module */
        foreach ($modules->withConfig('search') as $module) {
            foreach ($config->get($module->getNamespace('search')) as $model => $search) {

                /* @var EntryModel $model */
                $model = new $model;

                $stream = $model->getStreamNamespace() . '.' . $model->getStreamSlug();

                if (!$rebuild || $stream == $rebuild) {

                    $this->info('Rebuilding ' . $stream);

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
            ['stream', InputArgument::OPTIONAL, 'The stream to rebuild.']
        ];
    }
}
