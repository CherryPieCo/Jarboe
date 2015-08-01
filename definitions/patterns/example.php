<?php

return array(

    'install' => function() {
        
    }, // end install
    
    'view' => function(array $row) { // empty if create form
        // make all inputs with names - pattern[this_pattern_name][my_input_name]
        $val = $row ? $row['id'] : '';
        return '<input name="pattern[example][text]" value="'. $val .'">';
    }, // end view
    
    'handle' => array(
        'insert' => function($idRow, $patternValues, $values) {
            
        }, // end insert
        
        'update' => function($idRow, $patternValues, $values) {
            //dr($values);
        }, // end update
        
        'delete' => function($idRow) {
            
        }, // end delete
    ),
    
);