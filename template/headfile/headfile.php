<?php
if (defined('DNMVCS_HEAD_FILE_LOADED')) {
    return;
}
define('DNMVCS_HEAD_FILE_LOADED', true);
$IN_COMPOSER=false;
if ($IN_COMPOSER) {
    require(__DIR__ .'/../vendor/autoload.php');
    return;
}

$file=realpath(__DIR__.'/../../autoload.php');
if (!is_file($file)) {
    exit("Can't found DNMVCS.php -- By ".__FILE__);
}
define('DNMVCS_WARNING_IN_TEMPLATE', true);
require($file);
$file=realpath(__DIR__.'/../../SwooleHttpd/src/SwooleHttpd.php');
if (is_file($file)) {
    require($file);
}
return;
