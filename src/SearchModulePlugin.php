<?php namespace Anomaly\SearchModule;

use Anomaly\Streams\Platform\Addon\Plugin\Plugin;
use Anomaly\Streams\Platform\Support\Decorator;
use Illuminate\Pagination\LengthAwarePaginator;
use Mmanos\Search\Index;
use Mmanos\Search\Query;
use Mmanos\Search\Search;

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
            new \Twig_SimpleFunction('search_results', [$this, 'results'])
        ];
    }

    /**
     * Return search results.
     *
     * @param array $parameters
     */
    public function results(array $parameters = [])
    {
        $decorator = new Decorator();

        /* @var Search|Query $search */
        $search = app('search')->index(array_pull($parameters, 'index', 'default'));

        foreach ($parameters as $method => $arguments) {

            if (!in_array($method, ['search', 'where'])) {
                continue;
            }

            if (is_array($arguments)) {
                $search = call_user_func_array([$search, $method], $arguments);
            } else {
                $search = call_user_func([$search, $method], $arguments);
            }
        }

        if ($search instanceof Search) {
            return [];
        }

        $page = (int)\Input::get('page', 1);
        $perPage = array_pull($parameters, 'per_page', 15);

        $search = $search->limit(
            $perPage,
            ($page - 1) * $perPage
        );

        $paginator = (new LengthAwarePaginator($search->get(), $search->count(), $perPage, $page))->appends(
            \Request::all()
        );

        foreach ($paginator->items() as &$result) {
            $result['reference'] = $decorator->decorate((new $result['reference_type'])->find($result['reference_id']));
        }

        return $paginator;
    }
}
