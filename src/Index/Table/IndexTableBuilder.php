<?php namespace Anomaly\SearchModule\Index\Table;

use Anomaly\Streams\Platform\Ui\Table\TableBuilder;

/**
 * Class IndexTableBuilder
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\SearchModule\Index\Table
 */
class IndexTableBuilder extends TableBuilder
{

    /**
     * The table filters.
     *
     * @var array
     */
    protected $filters = [
        'term' => [
            'filter'      => 'input',
            'placeholder' => 'module::field.term.placeholder'
        ]
    ];

    /**
     * The table actions.
     *
     * @var array
     */
    protected $actions = [
        'delete' => [
            'handler' => 'Anomaly\SearchModule\Index\Table\Action\Delete'
        ]
    ];

    /**
     * The table options.
     *
     * @var array
     */
    protected $options = [
        'table_view' => 'module::admin/search/table',
        'filters'    => [
            'filter_icon' => 'search',
            'filter_text' => 'module::button.search'
        ]
    ];

}
