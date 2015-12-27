<?php namespace Anomaly\SearchModule\Search;

use Anomaly\SearchModule\Search\Contract\SearchItemInterface;
use Anomaly\Streams\Platform\Entry\Contract\EntryInterface;
use Anomaly\Streams\Platform\Support\Presenter;

/**
 * Class SearchPresenter
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\SearchModule\Search
 */
class SearchPresenter extends Presenter
{

    /**
     * The search entry.
     *
     * @var SearchItemInterface
     */
    protected $object;

    /**
     * Catch calls to fields on
     * the page's related entry.
     *
     * @param string $key
     * @return mixed
     */
    public function __get($key)
    {
        $entry = $this->object->getEntry();

        if ($entry instanceof EntryInterface && $entry->hasField($key)) {
            return $this->__getDecorator()->decorate($entry)->{$key};
        }

        return parent::__get($key);
    }
}
