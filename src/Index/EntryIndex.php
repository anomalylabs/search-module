<?php namespace Anomaly\SearchModule\Index;

use Anomaly\Streams\Platform\Entry\Contract\EntryInterface;
use Illuminate\Contracts\Support\Arrayable;
use Mmanos\Search\Index;
use Mmanos\Search\Search;

/**
 * Class EntryIndex
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\SearchModule\Index
 */
class EntryIndex
{

    /**
     * The debug flag.
     *
     * @var bool
     */
    protected $debug = false;

    /**
     * The index to store records in. By
     * default the configured default
     * index will be used.
     *
     * @var null|string
     */
    protected $index = null;

    /**
     * The title field.
     *
     * @var null|string
     */
    protected $title = null;

    /**
     * The description field.
     *
     * @var null|string
     */
    protected $description = null;

    /**
     * The indexable fields.
     *
     * @var array
     */
    protected $fields = [];

    /**
     * Extra fields to save. These
     * are not indexed but returned
     * with results.
     *
     * @var array
     */
    protected $extra = [];

    /**
     * Protected fields that should be
     * omitted from the index store.
     *
     * @var array
     */
    protected $protected = [];

    /**
     * The search instance.
     *
     * @var Search
     */
    protected $search;

    /**
     * The index reference.
     *
     * @var EntryInterface
     */
    protected $reference;

    /**
     * Create a new Search instance.
     *
     * @param Search|Index             $search
     * @param EntryInterface|Arrayable $reference
     */
    public function __construct(Search $search, EntryInterface $reference)
    {
        $this->search    = $search;
        $this->reference = $reference;
    }

    /**
     * Insert the index.
     */
    public function insert()
    {
        $this->debug();
        $this->delete();

        $this->search->insert(
            $this->indexId(),
            $this->indexParameters(),
            $this->extraParameters()
        );
    }

    /**
     * Delete the reference index.
     */
    public function delete()
    {
        $this->search->delete($this->indexId());
    }

    /**
     * Debug if enabled.
     */
    protected function debug()
    {
        if ($this->debug) {
            dd(
                [
                    'id'         => $this->indexId(),
                    'parameters' => $this->indexParameters(),
                    'extra'      => $this->extraParameters()
                ]
            );
        }
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
                $this->reference->getId()
            ]
        );
    }

    /**
     * Return index parameters.
     *
     * @return array
     */
    protected function indexParameters()
    {
        $title       = $this->getTitle();
        $description = $this->getDescription();

        $standard = [
            'title'       => (string)$this->reference->{$title},
            'description' => $description ? (string)$this->reference->{$description} : null
        ];

        return array_filter(
            array_merge(
                array_map(
                    function ($parameter) {
                        return (string)$this->reference->{$parameter};
                    },
                    $this->getFields()
                ),
                $standard
            )
        );
    }

    /**
     * Return extra parameters.
     *
     * @return array
     */
    protected function extraParameters()
    {
        return array_merge(
            [
                '_reference_type' => get_class($this->reference),
                '_reference_id'   => $this->reference->getId()
            ],
            $this->indexParameters(),
            array_diff_key(
                $this->reference->toArray(),
                array_merge(
                    array_flip($this->getProtected()),
                    array_flip(['id', 'sort_order'])
                )
            )
        );
    }

    /**
     * Get the index.
     *
     * @return null|string
     */
    public function getIndex()
    {
        return $this->index;
    }

    /**
     * Get the title field.
     *
     * @return null|string
     */
    public function getTitle()
    {
        return $this->title ?: $this->reference->getTitleName();
    }

    /**
     * Get the description field.
     *
     * @return null|string
     */
    public function getDescription()
    {
        return $this->description ?: null;
    }

    /**
     * Get the indexable fields.
     *
     * @return array
     */
    public function getFields()
    {
        return $this->fields;
    }

    /**
     * Get the protected fields.
     *
     * @return array
     */
    public function getProtected()
    {
        return $this->protected;
    }

    /**
     * Get the extra fields.
     *
     * @return array
     */
    public function getExtra()
    {
        return $this->extra;
    }
}
