<?php

View::composer('admin::tb.storage.tags', function($view) {
    $model = Config::get('jarboe::images.models.tag');
    $tags = $model::orderBy('id', 'desc')->get();
    $view->with('tags', $tags);
});

View::composer('admin::tb.storage.images', function($view) {
    // FIXME:
    $fields = Config::get('jarboe::images.image.fields');
    
    $model = Config::get('jarboe::images.models.image');
    $images = $model::orderBy('id', 'desc')->get();
    
    $view->with('images', $images)->with('fields', $fields);
});