<?php namespace Anomaly\SearchModule\Search;

use Anomaly\SearchModule\Search\Contract\SearchItemInterface;
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
}
