<?php namespace Anomaly\SearchModule\Search\Plugin\Command;

use Anomaly\SearchModule\Search\Command\GetAllConfig;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Mmanos\Search\Search;

/**
 * Class GetResults
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\SearchModule\Search\Plugin\Command
 */
class GetResults implements SelfHandling
{

    use DispatchesJobs;

    /**
     * The search term.
     *
     * @var string
     */
    protected $term;

    /**
     * The search parameters.
     *
     * @var array
     */
    protected $parameters;

    /**
     * Create a new GetResults instance.
     *
     * @param array $parameters
     */
    public function __construct($term, array $parameters = [])
    {
        $this->term       = $term;
        $this->parameters = $parameters;
    }

    /**
     * Handle the command.
     *
     * @param Search $search
     */
    public function handle(Search $search)
    {
        $query = $search
            ->search(
                array_get($this->parameters, 'fields', ['title', 'description', 'keywords']),
                $this->term,
                array_get($this->parameters, 'fuzzy', ['fuzzy' => 0.3])
            );

        $config      = $this->dispatch(new GetAllConfig());
        $collections = array_get($this->parameters, 'collections', []);

        if ($collections) {
            foreach ($config as $configuration) {
                if (!in_array($collection = array_get($configuration, 'collection'), $collections)) {
                    $query->search('collection', $collection, ['prohibited' => true]);
                }
            }
        }

        return $query->get();
    }
}
