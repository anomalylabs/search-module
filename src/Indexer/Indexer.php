<?php namespace Anomaly\SearchModule\Indexer;

use Anomaly\SearchModule\Index\Contract\IndexRepositoryInterface;
use Anomaly\Streams\Platform\Entry\Contract\EntryInterface;
use Anomaly\Streams\Platform\Model\EloquentModel;
use Illuminate\Config\Repository;

/**
 * Class Indexer
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\SearchModule\Indexer
 */
class Indexer implements IndexerInterface
{

    protected $title = null;

    protected $description = 'description';

    /**
     * The model instance.
     *
     * @var EntryInterface|EloquentModel
     */
    protected $model;

    /**
     * The index repository.
     *
     * @var IndexRepositoryInterface
     */
    protected $index;

    /**
     * The config repository.
     *
     * @var Repository
     */
    protected $config;

    function __construct(Repository $config, IndexRepositoryInterface $index, $model)
    {
        $this->config = $config;
        $this->index  = $index;
        $this->model  = $model;
    }


    /**
     * Index the model.
     */
    public function index()
    {
        if ($this->model->isTranslatable()) {

            foreach ($this->config->get('streams::locales.enabled') as $locale) {
                if ($translation = $this->model->translate($locale)) {
                    //$this->index->create()
                }
            }
        }
    }
}
