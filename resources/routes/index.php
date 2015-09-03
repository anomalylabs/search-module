<?php

return [
    'admin/search'           => 'Anomaly\SearchModule\Http\Controller\Admin\IndexController@index',
    'admin/search/create'    => 'Anomaly\SearchModule\Http\Controller\Admin\IndexController@create',
    'admin/search/edit/{id}' => 'Anomaly\SearchModule\Http\Controller\Admin\IndexController@edit'
];
