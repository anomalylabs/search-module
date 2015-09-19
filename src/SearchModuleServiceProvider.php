<?php namespace Anomaly\SearchModule;

use Anomaly\Streams\Platform\Addon\AddonServiceProvider;
use Anomaly\Streams\Platform\Application\Application;
use Illuminate\Contracts\Config\Repository;

/**
 * Class SearchModuleServiceProvider
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\SearchModule
 */
class SearchModuleServiceProvider extends AddonServiceProvider
{

    /**
     * Additional addon providers.
     *
     * @var array
     */
    protected $providers = [
        'Mmanos\Search\SearchServiceProvider'
    ];

    /**
     * The addon commands.
     *
     * @var array
     */
    protected $commands = [
        'Anomaly\SearchModule\Console\Rebuild'
    ];

    /**
     * The addon plugins.
     *
     * @var array
     */
    protected $plugins = [
        'Anomaly\SearchModule\SearchModulePlugin'
    ];

    /**
     * The addon listeners.
     *
     * @var array
     */
    protected $listeners = [
        'Anomaly\Streams\Platform\Entry\Event\EntryWasSaved'   => [
            'Anomaly\SearchModule\Index\Listener\InsertItem'
        ],
        'Anomaly\Streams\Platform\Entry\Event\EntryWasDeleted' => [
            'Anomaly\SearchModule\Index\Listener\DeleteItem'
        ]
    ];

    /**
     * The addon routes.
     *
     * @var array
     */
    protected $routes = [
        'admin/search'         => 'Anomaly\SearchModule\Http\Controller\Admin\IndexController@index',
        'admin/search/rebuild' => 'Anomaly\SearchModule\Http\Controller\Admin\IndexController@rebuild'
    ];

    /**
     * Boot the service provider.
     *
     * @param Repository  $config
     * @param Application $application
     */
    public function boot(Repository $config, Application $application)
    {
        $config->set('search', $config->get('anomaly.module.search::search'));

        $config->set(
            'search.connections.zend.path',
            str_replace(
                'storage::',
                $application->getStoragePath() . '/',
                $config->get('search.connections.zend.path')
            )
        );
    }
}
