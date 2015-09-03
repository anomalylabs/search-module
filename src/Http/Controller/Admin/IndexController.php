<?php namespace Anomaly\SearchModule\Http\Controller\Admin;

use Anomaly\SearchModule\Index\Form\IndexFormBuilder;
use Anomaly\SearchModule\Index\Table\IndexTableBuilder;
use Anomaly\Streams\Platform\Http\Controller\AdminController;

class IndexController extends AdminController
{

    /**
     * Display an index of existing entries.
     *
     * @param IndexTableBuilder $table
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function index(IndexTableBuilder $table)
    {
        return $table->render();
    }

    /**
     * Create a new entry.
     *
     * @param IndexFormBuilder $form
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function create(IndexFormBuilder $form)
    {
        return $form->render();
    }

    /**
     * Edit an existing entry.
     *
     * @param IndexFormBuilder $form
     * @param        $id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function edit(IndexFormBuilder $form, $id)
    {
        return $form->render($id);
    }
}
