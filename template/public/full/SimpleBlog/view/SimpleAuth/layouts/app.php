<?php declare(strict_types=1);
use SimpleAuth\Base\Helper\ViewHelper as V;
// use SimpleBlog\Helper\ViewHelper as V; TODO ，让这也可行
// TODO 第三方 View 单独在一个目录？ 免得找不到？

?><!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="<?=V::H($csrf_token)?>">
    <title>简单博客系统</title>
</head>
<body>
    <div id="app">
Simple Blog 这里用于 用户注册登录 修改了父类
[<a href='<?= __url('test/x.html')?>'><?= __url('test/x.html')?></a>]
<hr>
        <main class="py-4">
            <?= V::yieldContent('content'); ?>
        </main>
<hr>
Simple Blog  用户注册登录
    </div>
</body>
</html>