<?php namespace Anomaly\SearchModule\Http\Controller\Admin;

use Anomaly\SearchModule\Index\Table\IndexTableBuilder;
use Anomaly\Streams\Platform\Http\Controller\AdminController;

/**
 * Class SearchController
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\SearchModule\Http\Controller\Admin
 */
class SearchController extends AdminController
{

    /**
     * Return an index of existing indexed entries.
     *
     * @param IndexTableBuilder $table
     * @return \Illuminate\View\View|\Symfony\Component\HttpFoundation\Response
     */
    public function index(IndexTableBuilder $table)
    {
        return $table->render();
    }
}
