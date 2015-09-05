<?php namespace Anomaly\SearchModule\Index\Table;

/**
 * Class IndexTableColumns
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\SearchModule\Index\Table
 */
class IndexTableColumns
{

    /**
     * Handle the table columns.
     *
     * @param IndexTableBuilder $builder
     */
    public function handle(IndexTableBuilder $builder)
    {
        $builder->setColumns(
            [
                [
                    'heading' => 'module::field.title.name',
                    'value'   => 'entry.reference.title'
                ],
                [
                    'heading' => 'module::field.object.name',
                    'value'   => function ($item) {
                        return str_singular(trans($item['reference']->getStreamName()));
                    }
                ]
            ]
        );
    }
}
