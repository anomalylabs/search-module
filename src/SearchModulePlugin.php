<?php namespace Anomaly\SearchModule;

use Anomaly\SearchModule\Search\Command\GetSearchResults;
use Anomaly\SearchModule\Search\SearchCriteria;
use Anomaly\Streams\Platform\Addon\Plugin\Plugin;
use Mmanos\Search\Index;

/**
 * Class SearchModulePlugin
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\SearchModule
 */
class SearchModulePlugin extends Plugin
{

    /**
     * Get the plugin functions.
     *
     * @return array
     */
    public function getFunctions()
    {
        return [
            new \Twig_SimpleFunction(
                'search',
                function ($term = null, $options = []) {
                    return new SearchCriteria(
                        'results',
                        function (SearchCriteria $criteria) use ($term, $options) {

                            if ($term) {
                                $criteria->search(null, $term, $options);
                            }

                            return $this->dispatch(new GetSearchResults($criteria));
                        }
                    );
                }
            )
        ];
    }
}
