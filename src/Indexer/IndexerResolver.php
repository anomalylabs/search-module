<?php namespace Anomaly\SearchModule\Indexer;

use Illuminate\Container\Container;
use Illuminate\Database\Eloquent\Model;

/**
 * Class IndexerResolver
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\SearchModule\Indexer
 */
class IndexerResolver
{

    /**
     * The service container.
     *
     * @var Container
     */
    protected $container;

    /**
     * Create a new IndexerResolver instance.
     *
     * @param Container $container
     */
    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    /**
     * Resolve the indexer for the provided model.
     *
     * @param Model $model
     * @return null|IndexerInterface
     */
    public function resolve(Model $model)
    {
        $class = get_class($model);

        if (ends_with($class, 'Model') && class_exists($indexer = substr($class, 0, -5) . 'Indexer')) {
            return $this->container->make($indexer, compact('model'));
        }

        if (class_exists($indexer = $class . 'Indexer')) {
            return $this->container->make($indexer, compact('model'));
        }

        return null;
    }
}
