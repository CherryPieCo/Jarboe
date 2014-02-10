<?php namespace Yaro\TableBuilder\Handlers;

use Illuminate\Support\Facades\DB;


class QueryHandler {

    protected $def;
    protected $db;

    public function __construct($definition)
    {
        $this->def = $definition;
        $this->db = DB::table($definition['db']['table']);
    } // end __construct

    public function getRows($filters = array())
    {
        foreach ($filters as $name => $value) {
            $this->db->where($name, 'LIKE', '%'.$value.'%');
        }
        $rows = $this->db->get();

        return $rows;
    } // end getRows

    public function updateRow($values)
    {
        $this->_checkFastSaveValues($values);

        $updateData = array(
            $values['name'] => $values['value']
        );
        $updateResult = $this->db->where('id', $values['id'])->update($updateData);

        $res = array(
            'status' => $updateResult,
            'id'     => $values['id'],
            'value'  => $values['value']
        );
        
        return $res;
    } // end updateRow

    private function _checkFastSaveValues($values)
    {
        $required = array(
            'id', 'name', 'value'
        );

        foreach ($required as $ident) {
            if (!isset($values[$ident])) {
                throw new \RuntimeException("FastSave ident [{$ident}] does not pass.");
            }
        }
    } // end _checkFastSaveValues

        
}
