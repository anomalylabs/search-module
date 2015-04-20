<?php namespace Anomaly\SearchModule;

use Anomaly\Streams\Platform\Addon\Module\Module;

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
     * The module icon.
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
        'search'
    ];

}
