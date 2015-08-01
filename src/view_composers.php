<?php

// image storage
View::composer('admin::tb.storage.image.tags', function($view) {
    $model = config('jarboe.images.models.tag');
    $tags = $model::orderBy('id', 'desc')->get();
    $view->with('tags', $tags);
});

View::composer('admin::tb.storage.image.galleries', function($view) {
    $model = config('jarboe.images.models.gallery');
    $galleries = $model::orderBy('id', 'desc')->get();
    $view->with('galleries', $galleries);
});

View::composer('admin::tb.storage.image.images', function($view) {
    // FIXME:
    $fields  = config('jarboe.images.image.fields');
    $perPage = config('jarboe.images.per_page');
    
    $model  = config('jarboe.images.models.image');
    $images = $model::search()
                    ->orderBy('created_at', 'desc')
                    ->skip(0)->limit($perPage)
                    ->get();
    
    $view->with('images', $images)->with('fields', $fields);
});

// file storage
View::composer('admin::tb.storage.file.files', function($view) {
    $model = config('jarboe.files.models.file');
    $files = $model::orderBy('id', 'desc')->get();
    $view->with('files', $files);
});