<?php

return array(
    
    'models' => array(
        'image'   => 'Yaro\Jarboe\Image',
        'gallery' => 'Yaro\Jarboe\Gallery',
        'tag'     => 'Yaro\Jarboe\Tag',
        'storage' => 'Yaro\Jarboe\ImageCatalog',
    ),
    
    'image' => array(
        'fields' => array(
            'title' => array(
                'caption' => 'Caption',
            ),
        )
    ),
);
