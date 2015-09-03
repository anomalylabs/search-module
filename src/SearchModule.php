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
     * The navigation icon.
     *
     * @var string
     */
    protected $navigation = 'search';

    /**
     * The module sections.
     *
     * @var array
     */
    protected $sections = [
        'index' => [
            'buttons' => [
                [
                    'icon' => 'refresh',
                    'text' => 'Rebuild',
                    'href' => 'admin/search/rebuild'
                ]
            ]
        ]
    ];

}
