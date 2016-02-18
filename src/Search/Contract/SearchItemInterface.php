<?php namespace Anomaly\SearchModule\Search\Contract;

use Anomaly\SearchModule\Search\SearchPresenter;
use Anomaly\Streams\Platform\Entry\Contract\EntryInterface;

/**
 * Interface SearchItemInterface
 *
 * @link          http://pyrocms.com/
 * @author        PyroCMS, Inc. <support@pyrocms.com>
 * @author        Ryan Thompson <ryan@pyrocms.com>
 * @package       Anomaly\SearchModule\Search\Contract
 */
interface SearchItemInterface
{

    /**
     * Get the title.
     *
     * @return string
     */
    public function getTitle();

    /**
     * Get the keywords.
     *
     * @return array
     */
    public function getKeywords();

    /**
     * Get the description.
     *
     * @return string
     */
    public function getDescription();

    /**
     * Get the edit path.
     *
     * @return string
     */
    public function getEditPath();

    /**
     * Get the view path.
     *
     * @return string
     */
    public function getViewPath();

    /**
     * Get the entry ID.
     *
     * @return int
     */
    public function getEntryId();

    /**
     * Get the entry type.
     *
     * @return string
     */
    public function getEntryType();

    /**
     * Get the referenced entry.
     *
     * @return EntryInterface
     */
    public function getEntry();

    /**
     * Return a created presenter.
     *
     * @return SearchPresenter
     */
    public function getPresenter();
}
