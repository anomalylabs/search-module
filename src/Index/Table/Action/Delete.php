<?php namespace Anomaly\SearchModule\Index\Table\Action;

use Anomaly\Streams\Platform\Ui\Table\Component\Action\ActionHandler;
use Mmanos\Search\Index;
use Mmanos\Search\Search;

/**
 * Class Delete
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\SearchModule\Index\Table\Action
 */
class Delete extends ActionHandler
{

    /**
     * Delete the selected entries.
     *
     * @param Search|Index $search
     * @param array        $selected
     */
    public function handle(Search $search, array $selected)
    {
        foreach ($selected as $id) {
            $search->delete($id);
        }

        if ($selected) {
            $this->messages->success(trans('streams::message.delete_success', ['count' => count($selected)]));
        }
    }
}
