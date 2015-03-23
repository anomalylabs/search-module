<?php

use Anomaly\Streams\Platform\Database\Migration\Migration;

/**
 * Class AnomalyModuleSearch_1_0_0_CreateSearchFields
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 */
class AnomalyModuleSearch_1_0_0_CreateSearchFields extends Migration
{

    /**
     * The addon fields.
     *
     * @var array
     */
    protected $fields = [
        'title'       => 'anomaly.field_type.text',
        'category'    => 'anomaly.field_type.text',
        'description' => 'anomaly.field_type.textarea',
        'keywords'    => 'anomaly.field_type.tags'
    ];

}
