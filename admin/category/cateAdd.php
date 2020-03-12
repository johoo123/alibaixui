<?php
include_once '../../fn.php';

// 获取表单数据
$name = $_GET['name'];
$slug = $_GET['slug'];
// 插入到数据库
$sql = "insert into categories (name, slug) values( '$name', '$slug')";
// 执行
my_exec($sql);
