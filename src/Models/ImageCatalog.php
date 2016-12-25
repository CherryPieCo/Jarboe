<?php

namespace Yaro\Jarboe\Models;


class ImageCatalog extends \Baum\Node 
{
    
    protected $table = 'j_images_catalog';
    protected $parentColumn = 'parent_id';

}