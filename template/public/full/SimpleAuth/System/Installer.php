<?php declare(strict_types=1);
/**
 * DuckPHP
 * From this time, you never be alone~
 */
namespace SimpleAuth\System;

use DuckPhp\Component\DbManager;
use DuckPhp\Core\App;
use DuckPhp\Core\Configer;
use DuckPhp\Core\ComponentBase;
use DuckPhp\Ext\SqlDumper;
use DuckPhp\Ext\ThrowOnableTrait;

class Installer extends ComponentBase
{
    use ThrowOnableTrait;
    
    public $options = [
        'install_lock_file' => 'SimpleAuth.lock',
        'path' =>'',
        //'path_config' =>'',
    ];
    public function isInstalled()
    {
        $path = $this->getComponenetPath(Configer::G()->options['path_config'],Configer::G()->options['path']);
        $file = $path.$this->options['install_lock_file'];
        return is_file($file);
    }
    protected function writeLock()
    {
        $path = $this->getComponenetPath(Configer::G()->options['path_config'],Configer::G()->options['path']);
        $file = $path.$this->options['install_lock_file'];
        $data = DATE(DATE_ATOM);
        return @file_put_contents($file,$data);
    }

    protected function getComponenetPath($path, $basepath = ''): string
    {
        // 考虑放到
        if (DIRECTORY_SEPARATOR === '/') {
            if (substr($path, 0, 1) === '/') {
                return rtrim($path, '/').'/';
            } else {
                return $basepath.rtrim($path, '/').'/';
            }
        } else { // @codeCoverageIgnoreStart
            if (substr($path, 1, 1) === ':') {
                return rtrim($path, '\\').'\\';
            } else {
                return $basepath.rtrim($path, '\\').'\\';
            } // @codeCoverageIgnoreEnd
        }
    }

    public function run()
    {
        $ret = false;
        $path = $this->getComponenetPath(Configer::G()->options['path_config'],Configer::G()->options['path']);
        $sqldumper_options = $this->options;
        
        SqlDumper::G()->init($sqldumper_options, ($this->context_class)::G());
        
        try{
            $ret = SqlDumper::G()->install($this->options['force']??false);
            $flag = $this->writeLock();
            static::ThrowOn(!$flag,'写入文件失败',-2);        
        }catch(\Exception $ex){
            static::ThrowOn(true, "写入数据库失败" . $ex->getMessage(),-1);
        }
        
        
        
        return $ret;
    }
    public function dumpSql($path)
    {
        $sqldumper_options = [
            'sql_dump_inlucde_tables' =>['Users'],
        ];
        SqlDumper::G()->init($sqldumper_options,($this->context_class)::G());
        return SqlDumper::G()->run();
    }
}