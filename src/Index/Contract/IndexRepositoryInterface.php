<?php namespace Anomaly\SearchModule\Index\Contract;

/**
 * Interface IndexRepositoryInterface
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\SearchModule\Index\Contract
 */
interface IndexRepositoryInterface
{

    /**
     * Create a new index entry.
     *
     * @param array $attributes
     * @return IndexInterface
     */
    public function save(array $attributes);
}
