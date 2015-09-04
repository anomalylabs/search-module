<?php namespace Anomaly\SearchModule\Http\Controller\Admin;

use Anomaly\SearchModule\Index\Table\IndexTableBuilder;
use Anomaly\Streams\Platform\Http\Controller\AdminController;

/**
 * Class IndexController
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\SearchModule\Http\Controller\Admin
 */
class IndexController extends AdminController
{

    /**
     * Return the index.
     *
     * @param IndexTableBuilder $table
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function index(IndexTableBuilder $table)
    {
        return $table->render();
    }

    public function rebuild()
    {
        die("Rebuilding...");
    }
}
