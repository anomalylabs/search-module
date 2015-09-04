<?php namespace Anomaly\SearchModule\Index\Table;

use Anomaly\SearchModule\Index\Table\Action\Delete;
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

    protected $filters = [
        'term' => [
            'filter'      => 'input',
            'placeholder' => 'Search...'
        ]
    ];

    protected $columns = [
        'entry.id',
        'entry.title',
        'entry.description'
    ];

    protected $actions = [
        'delete' => [
            'handler' => Delete::class
        ]
    ];

    protected $options = [
        'table_view' => 'module::admin/search/table',
        'filters'    => [
            'filter_icon' => 'search',
            'filter_text' => 'module::button.search'
        ]
    ];

}
