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
     * The table columns.
     *
     * @var array
     */
    protected $columns = [
        'title'
    ];

}
