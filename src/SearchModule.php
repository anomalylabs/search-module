<?php namespace Anomaly\SearchModule;

use Anomaly\Streams\Platform\Addon\Module\Module;
use Anomaly\Streams\Platform\Application\Application;
use Illuminate\Contracts\Config\Repository;
use Illuminate\Contracts\Filesystem\Filesystem;

/**
 * Class SearchModule
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\SearchModule
 */
class SearchModule extends Module
{

    /**
     * The navigation icon.
     *
     * @var string
     */
    protected $icon = 'search';

    /**
     * The module sections.
     *
     * @var array
     */
    protected $sections = [
        'index' => [
            /*'buttons' => [
                [
                    'icon' => 'refresh',
                    'href' => 'admin/search/rebuild',
                    'text' => 'module::button.rebuild'
                ]
            ]*/
        ]
    ];

    /**
     * Fired after module is installed.
     *
     * @param Filesystem  $filesystem
     * @param Application $application
     */
    public function onInstalled(Filesystem $filesystem, Application $application)
    {
        $filesystem->makeDirectory($application->getStoragePath('search/zend'), 0777, true, true);
    }

    /**
     * Fired after module is uninstalled.
     *
     * @param Filesystem  $filesystem
     * @param Application $application
     */
    public function onUninstalled(Filesystem $filesystem, Application $application)
    {
        $filesystem->deleteDirectory($application->getStoragePath('search/zend'));
    }
}
