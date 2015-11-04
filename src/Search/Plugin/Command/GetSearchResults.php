<?php namespace Anomaly\SearchModule\Search\Plugin\Command;

use Illuminate\Contracts\Bus\SelfHandling;
use Mmanos\Search\Search;

/**
 * Class GetSearchResults
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\SearchModule\Search\Plugin\Command
 */
class GetSearchResults implements SelfHandling
{

    /**
     * The search term.
     *
     * @var string
     */
    protected $term;

    /**
     * The search options.
     *
     * @var array
     */
    protected $options;

    /**
     * Create a new GetSearchResults instance.
     *
     * @param string $term
     * @param array  $options
     */
    public function __construct($term, array $options)
    {
        $this->term    = $term;
        $this->options = $options;
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
                array_get($this->options, 'fields', ['title', 'description', 'keywords']),
                $this->term,
                array_get($this->options, 'options', ['fuzzy' => 0.3])
            );

        foreach (array_get($this->options, 'collections', []) as $collection) {
            $query->search('collection', $collection, ['required' => false]);
        }

        return $query->paginate(15);
    }
}
