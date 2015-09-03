<?php namespace Anomaly\SearchModule\Index;

use Anomaly\SearchModule\Index\Contract\IndexInterface;
use Anomaly\Streams\Platform\Model\Search\SearchIndexEntryModel;

class IndexModel extends SearchIndexEntryModel implements IndexInterface
{

    /**
     * Boot the model.
     */
    protected static function boot()
    {
        self::observe(app(substr(__CLASS__, 0, -5) . 'Observer'));

        parent::boot();
    }

}
