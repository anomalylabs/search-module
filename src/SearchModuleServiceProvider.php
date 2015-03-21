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

}
