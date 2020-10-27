<?php

namespace Database\Factories\Anomaly\SearchModule\Item;

use Anomaly\SearchModule\Item\ItemModel;
use Illuminate\Database\Eloquent\Factories\Factory;

class ItemModelFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ItemModel::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [];
    }
}
