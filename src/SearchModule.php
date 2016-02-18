<?php namespace Anomaly\SearchModule;

use Anomaly\Streams\Platform\Addon\Module\Module;
use Anomaly\Streams\Platform\Application\Application;
use Illuminate\Contracts\Config\Repository;
use Illuminate\Contracts\Filesystem\Filesystem;

/**
 * Class SearchModule
 *
 * @link          http://pyrocms.com/
 * @author        PyroCMS, Inc. <support@pyrocms.com>
 * @author        Ryan Thompson <ryan@pyrocms.com>
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
     * @param Application $application
     */
    public function onInstalled(Application $application)
    {
        if (!is_dir($path = $application->getStoragePath('search/zend'))) {
            mkdir($application->getStoragePath('search/zend'), 0777, true);
        }
    }

    /**
     * Fired after module is uninstalled.
     *
     * @param Application $application
     */
    public function onUninstalled(Application $application)
    {
        rmdir($application->getStoragePath('search/zend'));
    }
}
