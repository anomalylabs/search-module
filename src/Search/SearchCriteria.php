<?php namespace Anomaly\SearchModule\Search;

use Anomaly\Streams\Platform\Addon\Plugin\PluginCriteria;

/**
 * Class SearchCriteria
 *
 * @link          http://pyrocms.com/
 * @author        PyroCMS, Inc. <support@pyrocms.com>
 * @author        Ryan Thompson <ryan@pyrocms.com>
 * @package       Anomaly\SearchModule\Search
 */
class SearchCriteria extends PluginCriteria
{

    /**
     * The search operations.
     *
     * @var array
     */
    protected $operations = [];

    /**
     * Get the operations.
     *
     * @return array
     */
    public function getOperations()
    {
        return $this->operations;
    }

    /**
     * Catch operation methods.
     *
     * @param $name
     * @param $arguments
     * @return $this|mixed
     */
    function __call($name, $arguments)
    {
        if (in_array($name, ['search', 'where'])) {

            $this->operations[] = compact('name', 'arguments');

            return $this;
        }

        return parent::__call($name, $arguments);
    }
}
