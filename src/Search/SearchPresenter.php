<?php namespace Anomaly\SearchModule\Search;

use Anomaly\SearchModule\Search\Contract\SearchItemInterface;
use Anomaly\Streams\Platform\Support\Presenter;
use Illuminate\Contracts\Support\Arrayable;

/**
 * Class SearchPresenter
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\SearchModule\Search
 */
class SearchPresenter extends Presenter implements Arrayable
{

    /**
     * The search entry.
     *
     * @var SearchItemInterface|Arrayable
     */
    protected $object;

    /**
     * Return the edit link.
     *
     * @return string
     */
    public function editLink()
    {
        return app('html')->link($this->object->getEditPath(), $this->object->getTitle());
    }

    /**
     * Return the edit link.
     *
     * @return string
     */
    public function viewLink()
    {
        return app('html')->link($this->object->getViewPath(), $this->object->getTitle());
    }

    /**
     * Get the instance as an array.
     *
     * @return array
     */
    public function toArray()
    {
        return $this->object->toArray();
    }
}
