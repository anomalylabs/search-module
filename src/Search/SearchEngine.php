<?php namespace Anomaly\SearchModule\Search;

use Anomaly\SearchModule\Item\Contract\ItemInterface;
use Anomaly\SearchModule\Item\Contract\ItemRepositoryInterface;
use Anomaly\SearchModule\Item\ItemModel;
use Anomaly\Streams\Platform\Entry\EntryCollection;
use Anomaly\Streams\Platform\Entry\EntryModel;
use Anomaly\Streams\Platform\Model\EloquentModel;
use Laravel\Scout\Builder;
use Laravel\Scout\Engines\Engine;

/**
 * Class SearchEngine
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class SearchEngine extends Engine
{

    /**
     * The item repository.
     *
     * @var ItemRepositoryInterface
     */
    protected $items;

    /**
     * Create a new SearchEngine instance.
     *
     * @param ItemRepositoryInterface $items
     */
    public function __construct(ItemRepositoryInterface $items)
    {
        $this->items = $items;
    }

    /**
     * Update the given model in the index.
     *
     * @param  \Illuminate\Database\Eloquent\Collection $models
     * @return void
     */
    public function update($models)
    {
        foreach ($models as $model) {

            /* @var EntryModel $model */
            $array = $model->toSearchableArray();

            if (!$item = $this->items->findByEntry($model)) {
                $item = new ItemModel(
                    [
                        'entry'  => $model,
                        'stream' => $model->getStream(),
                    ]
                );
            }

            $item->fill(
                [
                    'title'       => array_get($array, 'title'),
                    'keywords'    => array_get($array, 'description'),
                    'description' => array_get($array, 'description'),
                    'searchable'  => $array,
                ]
            );

            $this->items->withoutEvents(
                function () use ($item) {
                    $this->items->save($item);
                }
            );
        }
    }

    /**
     * Remove the given model from the index.
     *
     * @param  \Illuminate\Database\Eloquent\Collection $models
     * @return void
     */
    public function delete($models)
    {
        foreach ($models as $model) {

            /* @var ItemInterface|EloquentModel $item */
            if ($item = $this->items->findByEntry($model)) {
                $this->items->withoutEvents(
                    function () use ($item) {
                        $this->items->delete($item);
                    }
                );
            }
        }
    }

    /**
     * Perform the given search on the engine.
     *
     * @param  \Laravel\Scout\Builder $builder
     * @return mixed
     */
    public function search(Builder $builder)
    {
        return $this->items->search($builder);
    }

    /**
     * Perform the given search on the engine.
     *
     * @param  \Laravel\Scout\Builder $builder
     * @param  int $perPage
     * @param  int $page
     * @return mixed
     */
    public function paginate(Builder $builder, $perPage, $page)
    {
        return $this->items->search(
            $builder,
            [
                'per_page' => $perPage,
                'page'     => $page,
            ]
        );
    }

    /**
     * Pluck and return the primary keys of the given results.
     *
     * @param  mixed $results
     * @return \Illuminate\Support\Collection
     */
    public function mapIds($results)
    {
        return $results->pluck('id');
    }

    /**
     * Map the given results to instances of the given model.
     *
     * @param  \Laravel\Scout\Builder $builder
     * @param  EntryCollection $results
     * @param  \Illuminate\Database\Eloquent\Model $model
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function map(Builder $builder, $results, $model)
    {
        return $results->map(
            function (ItemInterface $item) {
                return $item->getEntry();
            }
        );
    }

    /**
     * Get the total count from a raw result returned by the engine.
     *
     * @param  mixed $results
     * @return int
     */
    public function getTotalCount($results)
    {
        return $results->count();
    }

    /**
     * Flush all of the model's records from the engine.
     *
     * @param  \Illuminate\Database\Eloquent\Model|EntryModel $model
     * @return void
     */
    public function flush($model)
    {
        foreach ($this->items->findBy('stream_id', $model->getStreamId()) as $item) {
            $this->items->withoutEvents($item);
        }
    }

}