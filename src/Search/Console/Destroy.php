<?php namespace Anomaly\SearchModule\Search\Console;

use Anomaly\SearchModule\Search\Index\IndexManager;
use Illuminate\Console\Command;
use Illuminate\Contracts\Config\Repository;
use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Foundation\Bus\DispatchesJobs;

/**
 * Class Destroy
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\SearchModule\Page\Console
 */
class Destroy extends Command
{

    use DispatchesJobs;

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'search:destroy';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Destroy the search index.';

    /**
     * Execute the console command.
     */
    public function fire(IndexManager $manager)
    {
        $manager->destroy();
    }
}
