<?php

namespace Yaro\Jarboe\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use Illuminate\Database\Schema\Blueprint;
use Schema;
use DB;


class CreateStructureTableCommand extends Command 
{

    protected $signature = 'jarboe:sctructure-table {table}';

    protected $description = "Create table for structure model.";

    public function fire()
    {
        $tableName = $this->argument('table');
        $modelName = '\Yaro\Jarboe\Models\\'. ucfirst(camel_case($tableName));
        $model = $this->ask(
            'Model class with namespace to handle current table structure? ['. $modelName .']'
        );
        
        Schema::create($tableName, function(Blueprint $table) {
            $table->increments('id');
            $table->integer('parent_id')->nullable()->index();
            $table->integer('lft')->nullable()->index();
            $table->integer('rgt')->nullable()->index();
            $table->integer('depth')->nullable();

            $table->string('title', 255);
            $table->string('slug', 255);
            $table->string('template', 255);
            $table->tinyInteger('is_active');
            $table->string('seo_title', 255);
            $table->string('seo_description', 255);
            $table->string('seo_keywords', 255);

            $table->timestamps();
        });

        $tree = array(
            array(
                'id' => 1, 
                'title' => 'Home', 
                'slug' => '/', 
                'template' => 'default mainpage template',
                'is_active' => 1,
            )
        );
        $model::buildTree($tree);
        
        // HACK: for homepage / url
        DB::table($tableName)->where('id', 1)->update([
            'slug' => '/'
        ]);
        
        $this->info('Structure table ['. $tableName .'] successfuly created!');
    } // end fire
    
    protected function getArguments()
    {
        return array(
        );
    } // end getArguments
    
    protected function getOptions()
    {
        return array(
        );
    } // end getOptions
      
}