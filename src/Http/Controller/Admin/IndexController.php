<?php namespace Anomaly\SearchModule\Http\Controller\Admin;

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

    public function index()
    {
        dd(app('search')->search(null, 'Test')->get());
    }
}
