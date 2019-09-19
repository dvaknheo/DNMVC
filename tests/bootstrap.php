<?php
require __DIR__ . '/../autoload.php';
return;
$dest=realpath(__DIR__.'/../tests/').'/';
$source=realpath(__DIR__.'/../src/').'/';
$directory = new \RecursiveDirectoryIterator($source, \FilesystemIterator::CURRENT_AS_PATHNAME | \FilesystemIterator::SKIP_DOTS);
$iterator = new \RecursiveIteratorIterator($directory);
$files = \iterator_to_array($iterator, false);
foreach ($files as $file) {
    $short_file=substr($file,strlen($source));
    
    if($short_file==='Ext/Oldbones.php' || $short_file==='Ext/Lazybones.php'){
        continue;
    }
    MakeDir($short_file,$dest);
    
    $data =MakeTest($file,$short_file);
    
    $file_name=str_replace('.php','Test.php',$short_file);
    file_put_contents($dest.$file_name,$data);
}
function MakeDir($short_file,$dest)
{
    $blocks=explode(DIRECTORY_SEPARATOR, $short_file);
    array_pop($blocks);
    $full_dir=$dest;
    foreach ($blocks as $t) {
        $full_dir.=DIRECTORY_SEPARATOR.$t;
        if (!is_dir($full_dir)) {
            mkdir($full_dir);
        }
    }
}
function MakeTest($file,$short_file)
{
    $data=file_get_contents($file);
    preg_match_all('/ function ([^\(]+)\(/',$data,$m);
    $funcs=$m[1];
    
    $namespace='tests\\'.str_replace('/','\\',dirname($short_file));
    if(dirname($short_file)=='.'){
        $namespace='tests';
    }
    $class=basename($short_file,'.php').'Test';
    $ret='<'.'?php';
    $ret.=<<<EOT

namespace $namespace;

class $class extends \PHPUnit\Framework\TestCase
{

EOT;
    foreach($funcs as $v){
        $v=ucfirst(str_replace('&','',$v));
$ret.=<<<EOT
    public function test$v()
    {
    }

EOT;
    }
$ret.=<<<EOT
}

EOT;
    
    return $ret;
}


var_dump(DATE(DATE_ATOM));

function foo()
{

}