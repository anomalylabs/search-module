<?php namespace Anomaly\SearchModule\Item;

use Anomaly\SearchModule\Item\Contract\ItemInterface;
use Anomaly\SearchModule\Item\Contract\ItemRepositoryInterface;
use Anomaly\Streams\Platform\Entry\EntryModel;
use Anomaly\Streams\Platform\Entry\EntryRepository;
use Anomaly\Streams\Platform\Stream\Contract\StreamInterface;
use Anomaly\Streams\Platform\Stream\Contract\StreamRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Laravel\Scout\Builder;

/**
 * Class ItemRepository
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class ItemRepository extends EntryRepository implements ItemRepositoryInterface
{

    /**
     * The entry model.
     *
     * @var ItemModel
     */
    protected $model;

    /**
     * Create a new ItemRepository instance.
     *
     * @param ItemModel $model
     */
    public function __construct(ItemModel $model)
    {
        $this->model = $model;
    }

    /**
     * Find all items by entry.
     *
     * @param EntryModel $entry
     * @return ItemInterface|null
     */
    public function findAllByEntry(EntryModel $entry)
    {
        return $this->model
            ->where('entry_id', $entry->getId())
            ->where('entry_type', get_class($entry))
            ->get();
    }
    
    /**
     * Find an item by entry and locale.
     *
     * @param EntryModel $entry
     * @return ItemInterface|null
     */
    public function findByEntryAndLocale(EntryModel $entry, $locale)
    {
        return $this->model
            ->where('locale', $locale)
            ->where('entry_id', $entry->getId())
            ->where('entry_type', get_class($entry))
            ->first();
    }

    /**
     * Return simple search results.
     *
     * @param Builder $builder
     * @param array $options
     * @return ItemCollection|Collection
     * @internal param $stream
     * @internal param $query
     */
    public function search(Builder $builder, array $options = [])
    {
        /* @var EntryModel $model */
        $model = $builder->model;

        if (!$model->isSearchable()) {
            return $this->model->newCollection();
        }

        $query = $this
            ->newQuery()
            ->where(
                'stream_id',
                $model->getStreamId()
            );

        return $query
            ->where(
                function (\Illuminate\Database\Eloquent\Builder $query) use ($builder) {
                    $query->where('title', 'LIKE', "%{$builder->query}%");
                    $query->orWhere('description', 'LIKE', "%{$builder->query}%");
                    $query->orWhere('keywords', 'LIKE', "%\"{$builder->query}\"%");
                }
            )
            ->limit($limit = array_get($options, 'per_page', config('streams::system.per_page')))
            ->skip($limit * (array_get($options, 'page', 1) - 1))
            ->get();
    }

    /**
     * Return the IDs of streams enabled for search.
     *
     * @return array
     */
    public function searchableStreamIds()
    {
        return app(StreamRepositoryInterface::class)
            ->all()
            ->filter(
                function (StreamInterface $stream) {
                    return $stream->isSearchable()
                        && app($stream->getBoundEntryModelName())->isSearchable();
                }
            )
            ->map(
                function (StreamInterface $stream) {
                    return $stream->getId();
                }
            )
            ->values()
            ->all();
    }
}
