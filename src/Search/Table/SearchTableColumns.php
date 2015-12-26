<?php namespace Anomaly\SearchModule\Search\Table;

/**
 * Class SearchTableColumns
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\SearchModule\Search\Table
 */
class SearchTableColumns
{

    /**
     * Handle the table columns.
     *
     * @param SearchTableBuilder $builder
     */
    public function handle(SearchTableBuilder $builder)
    {
        $builder->setColumns(
            [
                [
                    'heading' => 'module::field.title.name',
                    'value'   => 'entry.edit_link'
                ],
                [
                    'heading' => 'module::field.description.name',
                    'value'   => 'entry.description'
                ],
                [
                    'heading' => 'module::field.keywords.name',
                    'value'   => function ($item) {

                        return implode(
                            ' ',
                            array_map(
                                function ($keyword) {
                                    return '<span class="label label-default">' . $keyword . '</span>';
                                },
                                $item['keywords']
                            )
                        );
                    }
                ],
                [
                    'heading' => 'module::field.stream.name',
                    'value'   => 'entry.stream'
                ]
            ]
        );
    }
}
