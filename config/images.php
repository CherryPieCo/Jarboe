<?php

return array(
    
    'models' => array(
        'image'   => 'Yaro\Jarboe\Image',
        'gallery' => 'Yaro\Jarboe\Gallery',
        'tag'     => 'Yaro\Jarboe\Tag',
        'storage' => 'Yaro\Jarboe\ImageCatalog',
    ),
    
    'per_page' => 32,
    
    'wysiwyg_image_type' => 'source',
    
    'image' => array(
        'fields' => array(
            'title' => array(
                'caption' => 'Caption',
            ),
        ),
        /*
        'sizes' => array(
            // $image->source_large
            'large' => array(
                'caption' => 'Large',
                'modify' => array(
                    'resize' => array(690, 460),
                ),
            ),
            'medium' => array(
                'caption' => 'Med',
                'modify' => array(
                    'resize' => array(360, 240),
                ),
            ),
            'small' => array(
                'caption' => 'Small',
                'modify' => array(
                    'resize' => array(300, 175),
                ),
            ),
            'extra_small' => array(
                'caption' => 'XS',
                'modify' => array(
                    'resize' => array(160, 80),
                ),
            ),
        ),
        */
    ),
);
