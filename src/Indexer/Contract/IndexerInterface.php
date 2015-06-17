<?php namespace Anomaly\SearchModule\Indexer;

/**
 * Interface IndexerInterface
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\SearchModule\Indexer
 */
interface IndexerInterface
{

    /**
     * Index the model.
     */
    public function index();
}
