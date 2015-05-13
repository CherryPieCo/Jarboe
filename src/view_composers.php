<?php

// image storage
View::composer('admin::tb.storage.image.tags', function($view) {
    $model = Config::get('jarboe::images.models.tag');
    $tags = $model::orderBy('id', 'desc')->get();
    $view->with('tags', $tags);
});

View::composer('admin::tb.storage.image.galleries', function($view) {
    $model = Config::get('jarboe::images.models.gallery');
    $galleries = $model::orderBy('id', 'desc')->get();
    $view->with('galleries', $galleries);
});

View::composer('admin::tb.storage.image.images', function($view) {
    // FIXME:
    $fields = Config::get('jarboe::images.image.fields');
    
    $model = Config::get('jarboe::images.models.image');
    $images = $model::orderBy('id', 'desc')->get();
    
    $view->with('images', $images)->with('fields', $fields);
});

// file storage
View::composer('admin::tb.storage.file.files', function($view) {
    $model = Config::get('jarboe::files.models.file');
    $files = $model::orderBy('id', 'desc')->get();
    $view->with('files', $files);
});