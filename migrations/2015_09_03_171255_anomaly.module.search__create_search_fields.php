<?php

use Anomaly\Streams\Platform\Database\Migration\Migration;

/**
 * Class AnomalyModuleSearchCreateSearchFields
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 */
class AnomalyModuleSearchCreateSearchFields extends Migration
{

    /**
     * The addon fields.
     *
     * @var array
     */
    protected $fields = [
        'title'       => 'anomaly.field_type.text',
        'locale'      => 'anomaly.field_type.text',
        'keywords'    => 'anomaly.field_type.tags',
        'description' => 'anomaly.field_type.textarea',
        'resource'    => 'anomaly.field_type.polymorphic',
        'stream'      => [
            'type'   => 'anomaly.field_type.relationship',
            'config' => [
                'related' => 'Anomaly\Streams\Platform\Stream\StreamModel'
            ]
        ]
    ];

}
