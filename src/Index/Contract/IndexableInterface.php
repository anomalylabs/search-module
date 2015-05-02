<?php namespace Anomaly\SearchModule\Index\Contract;

/**
 * Interface IndexableInterface
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\SearchModule\Index\Contract
 */
interface IndexableInterface
{

    /**
     * Get the title.
     *
     * @return string
     */
    public function getTitle();

    /**
     * Get the keywords.
     *
     * @return array
     */
    public function getKeywords();
}
