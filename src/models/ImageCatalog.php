<?php

namespace Yaro\Jarboe;


class ImageCatalog extends \Baum\Node 
{
    
    protected $table = 'j_images_catalog';
    protected $parentColumn = 'parent_id';

}