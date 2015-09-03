<?php namespace Anomaly\SearchModule\Index;

use Anomaly\Streams\Platform\Entry\Contract\EntryInterface;

/**
 * Class EntryIndexer
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\SearchModule\Index
 */
class EntryIndexer
{

    /**
     * The resource payload.
     *
     * @var EntryInterface
     */
    protected $resource;

    /**
     * Create a new EntryIndexer instance.
     *
     * @param EntryInterface $resource
     */
    public function __construct(EntryInterface $resource)
    {
        $this->resource = $resource;
    }

    /**
     * Index the resource.
     */
    public function index()
    {
        $title       = $this->resource->getFieldValue($this->getTitleField());
        $description = $this->resource->getFieldValue($this->getDescriptionField());
    }

    protected function getTitleField()
    {
        return $this->resource->getTitleName();
    }

    protected function getDescriptionField()
    {
        $assignments = $this->resource->getAssignments();

        $assignments->findAllByFieldType('anomaly.field_type.textarea');

        return $assignments->first()->getFieldSlug();
    }

}
