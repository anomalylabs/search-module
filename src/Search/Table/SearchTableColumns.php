<?php namespace Anomaly\SearchModule\Search\Table;

use Anomaly\SearchModule\Search\SearchItem;
use Anomaly\SearchModule\Search\SearchPresenter;

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
                    'value'   => function (SearchPresenter $entry) {

                        /* @var SearchItem $item */
                        $item = $entry->getObject();

                        return implode(
                            ' ',
                            array_map(
                                function ($keyword) {
                                    return '<span class="label label-default">' . $keyword . '</span>';
                                },
                                $item->getKeywords()
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
