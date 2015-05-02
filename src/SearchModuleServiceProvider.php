<?php namespace Anomaly\SearchModule;

use Anomaly\Streams\Platform\Addon\AddonServiceProvider;

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
     * The addon routes.
     *
     * @var array
     */
    protected $routes = [
        'admin/search' => 'Anomaly\SearchModule\Http\Controller\Admin\SearchController@index'
    ];

    /**
     * The addon bindings.
     *
     * @var array
     */
    protected $bindings = [
        'Anomaly\SearchModule\Index\IndexModel'                       => 'Anomaly\SearchModule\Index\IndexModel',
        'Anomaly\Streams\Platform\Model\Search\SearchIndexEntryModel' => 'Anomaly\SearchModule\Index\IndexModel'
    ];

    /**
     * The addon singletons.
     *
     * @var array
     */
    protected $singletons = [
        'Anomaly\SearchModule\Index\Contract\IndexRepositoryInterface' => 'Anomaly\SearchModule\Index\IndexRepository'
    ];

    /**
     * The addon listeners.
     *
     * @var array
     */
    protected $listeners = [
        'Anomaly\Streams\Platform\Entry\Event\EntryWasSaved' => [
            'Anomaly\SearchModule\Index\Listener\IndexEntry'
        ]
    ];

}
