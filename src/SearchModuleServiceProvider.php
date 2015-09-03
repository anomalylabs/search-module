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
     * Additional addon providers.
     *
     * @var array
     */
    protected $providers = [
        'Mmanos\Search\SearchServiceProvider'
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
