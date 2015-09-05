<?php namespace Anomaly\SearchModule\Index;

use Anomaly\Streams\Platform\Entry\Contract\EntryInterface;
use Anomaly\Streams\Platform\Support\Value;
use Illuminate\Contracts\Container\Container;
use Illuminate\Contracts\Support\Arrayable;
use Mmanos\Search\Index;
use Mmanos\Search\Search;

/**
 * Class IndexManager
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\SearchModule\Index
 */
class IndexManager
{

    /**
     * The search index.
     *
     * @var string
     */
    protected $index = null;

    /**
     * The enabled flag.
     *
     * @var null
     */
    protected $enabled = null;

    /**
     * The extra, non-indexed parameters.
     *
     * @var array
     */
    protected $extra = [];

    /**
     * The indexed fields.
     *
     * @var array
     */
    protected $fields = [];

    /**
     * The reference item.
     *
     * @var null|EntryInterface
     */
    protected $reference = null;

    /**
     * The value resolver.
     *
     * @var Value
     */
    protected $value;

    /**
     * The search utility.
     *
     * @var Search
     */
    protected $search;

    /**
     * The service container.
     *
     * @var Container
     */
    protected $container;

    /**
     * Create a new IndexManager instance.
     *
     * @param Value        $value
     * @param Search|Index $search
     * @param Container    $container
     */
    public function __construct(Value $value, Search $search, Container $container)
    {
        $this->value     = $value;
        $this->search    = $search;
        $this->container = $container;
    }

    /**
     * Insert a search index item.
     */
    public function insert()
    {
        if (!$this->indexEnabled()) {

            $this->delete();

            return;
        }

        $this->search->insert(
            $this->indexId(),
            $this->indexFields(),
            $this->indexExtra()
        );
    }

    /**
     * Delete the item from the search index.
     */
    public function delete()
    {
        $this->search->delete($this->indexId());
    }

    /**
     * Return the index ID.
     *
     * @return string
     */
    protected function indexId()
    {
        return implode(
            '-',
            [
                $this->reference->getStreamNamespace(),
                $this->reference->getStreamSlug(),
                $this->reference->getEntryId()
            ]
        );
    }

    /**
     * Return whether the item
     * can be indexed or not.
     *
     * @return mixed|string
     * @throws \Exception
     */
    protected function indexEnabled()
    {
        $enabled = $this->getEnabled();

        /**
         * If the enabled flag is a string then
         * interpret it with the value interpreter.
         */
        if (is_string($enabled)) {
            return $this->value->make($enabled, $this->reference, 'reference');
        }

        /**
         * If the enabled flag is a closure
         * then resolve it out of the
         * service container.
         */
        if ($enabled instanceof \Closure) {
            return $this->container->call(
                $enabled,
                [
                    'reference' => $this->reference
                ]
            );
        }

        return $enabled;
    }

    /**
     * Return the indexable fields.
     *
     * @return array
     */
    protected function indexFields()
    {
        $fields = $this->getFields();

        /**
         * If the fields are an array walk
         * them with the value interpreter.
         */
        if (is_array($fields)) {

            return array_filter(
                array_combine(
                    array_keys($fields),
                    array_map(
                        function ($field) {
                            return $this->value->make($field, $this->reference, 'reference');
                        },
                        $fields
                    )
                )
            );
        }

        /**
         * If the fields are a closure
         * then resolve it out of the
         * service container.
         */
        if ($fields instanceof \Closure) {

            return $this->container->call(
                $fields,
                [
                    'reference' => $this->reference
                ]
            );
        }

        throw new \Exception('Fields must be an array of value definitions or a closure.');
    }

    /**
     * Return the extra parameters.
     *
     * @return array
     */
    protected function indexExtra()
    {
        $mandatory = [
            'reference_type' => get_class($this->reference),
            'reference_id'   => $this->reference->getEntryId()
        ];

        $extra = $this->getExtra();

        /**
         * If the fields are an array walk
         * them with the value interpreter.
         */
        if (is_array($extra)) {

            return array_merge(
                array_filter(
                    array_combine(
                        array_keys($extra),
                        array_map(
                            function ($field) {
                                return $this->value->make($field, $this->reference, 'reference');
                            },
                            $extra
                        )
                    )
                ),
                $mandatory
            );
        }

        /**
         * If the fields are a closure
         * then resolve it out of the
         * service container.
         */
        if ($extra instanceof \Closure) {

            array_merge(
                $this->container->call(
                    $extra,
                    [
                        'reference' => $this->reference
                    ]
                ),
                $mandatory
            );
        }

        return $mandatory;
    }

    /**
     * Get the index.
     *
     * @return string
     */
    public function getIndex()
    {
        return $this->index;
    }

    /**
     * Set the index.
     *
     * @param $index
     * @return $this
     */
    public function setIndex($index)
    {
        $this->index = $index;

        return $this;
    }

    /**
     * Get the enabled flag.
     *
     * @return null
     */
    public function getEnabled()
    {
        return $this->enabled;
    }

    /**
     * Set the enabled flag.
     *
     * @param $enabled
     * @return $this
     */
    public function setEnabled($enabled)
    {
        $this->enabled = $enabled;

        return $this;
    }

    /**
     * Get the extra parameters.
     *
     * @return array
     */
    public function getExtra()
    {
        return $this->extra;
    }

    /**
     * Set the extra parameters.
     *
     * @param $extra
     * @return $this
     */
    public function setExtra(array $extra)
    {
        $this->extra = $extra;

        return $this;
    }

    /**
     * Get the fields.
     *
     * @return array
     */
    public function getFields()
    {
        return $this->fields;
    }

    /**
     * Set the fields.
     *
     * @param $fields
     * @return $this
     */
    public function setFields($fields)
    {
        $this->fields = $fields;

        return $this;
    }

    /**
     * Get the reference item.
     *
     * @return EntryInterface|null
     */
    public function getReference()
    {
        return $this->reference;
    }

    /**
     * Set the reference item.
     *
     * @param $reference
     * @return $this
     */
    public function setReference($reference)
    {
        $this->reference = $reference;

        return $this;
    }
}
