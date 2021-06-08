<?php declare(strict_types=1);
/**
 * DuckPhp
 * From this time, you never be alone~
 */
namespace DuckPhp\Ext;

use DuckPhp\Core\ComponentBase;

class SqlDumper extends ComponentBase
{
    public $options = [
        'path' =>'',
        'path_sql_dumper' => 'config',
        'sql_dumper_ignore_tables' => [],
        'sql_dumper_inlucde_tables' => '*',
        'sql_dumper_data_tables' => [],
        //
        'sql_dumper_prefix' => '',
        'sql_dumper_struct_file' => 'sql_struct',
        'sql_dumper_data_file' => 'sql_data',
    ];
    protected $context_class = null;
    //@override
    protected function initContext(object $context)
    {
        $this->context_class = get_class($context);
    }
    public function run()
    {
        $data = $this->getData();
        $this->save($data);
        return true;
    }
    public function install($force = false)
    {
        $ret ='';
        $data = $this->load();
        foreach($data as $table =>$sql){
            try{
                ($this->context_class)::Db()->execute($sql);
            }catch(\PDOException $ex){
                $ret.= $ex->getMessage() . "\n"; 
            }
        }
        return $ret;
    }
    protected function load()
    {
        $path = parent::getComponenetPathByKey('path_sql_dumper_data');
        $file = $path.$this->options['sql_dumper_data_file'].'.php';
        $t = include $file;
        return $t;
    }
    protected function getData()
    {
        $ret =[];
        $tables = $this->getTables();
        foreach ($tables as $table) {
            $ret[$table] = $this->getCreateTableSql($table);
        }
        return $ret;
    }
    protected function getTables()
    {
        $a = [];
        $data = ($this->context_class)::Db()->fetchAll('show tables');
        foreach ($data as $v) {
            $t = array_values($v);
            $a[] = $t[0];
        }
        return $a;
    }
    protected function getCreateTableSql($table)
    {
        $record = ($this->context_class)::Db()->fetch('show create table '.$table);
        $sql = $record['Create Table']??null;
        $sql = preg_replace('/AUTO_INCREMENT=\d+/', 'AUTO_INCREMENT=1', $sql);
        return $sql;
    }
    protected function save($data)
    {
        $path = parent::getComponenetPathByKey('path_sql_dumper_data');
        $file = $path.$this->options['sql_dumper_struct_file'].'.php';
        $data = '<'.'?php return ';
        $data .= var_export($setting, true);
        return @file_put_contents($file, $data);
    }
}
