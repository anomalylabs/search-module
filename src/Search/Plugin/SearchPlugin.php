<?php namespace Anomaly\SearchModule\Search\Plugin;

use Anomaly\SearchModule\Search\Plugin\Command\GetSearchResults;
use Anomaly\Streams\Platform\Addon\Plugin\Plugin;

/**
 * Class SearchPlugin
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\SearchModule\Search\Plugin
 */
class SearchPlugin extends Plugin
{

    /**
     * Get the functions.
     *
     * @return array
     */
    public function getFunctions()
    {
        return [
            new \Twig_SimpleFunction(
                'search_results',
                function ($term, array $options = []) {
                    return $this->dispatch(new GetSearchResults($term, $options));
                }
            )
        ];
    }


}
