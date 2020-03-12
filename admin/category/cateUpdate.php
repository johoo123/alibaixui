<?php 
    // echo '<pre>';
    // print_r($_GET);
    // echo '</pre>';

    include_once '../../fn.php';

    // 获取前端传递数据，根据id 把数据更新回数据库中
    $id = $_GET['id'];
    $name = $_GET['name'];
    $slug = $_GET['slug'];

    //sql
    $sql = "update categories set name = '$name', slug = '$slug' where id = $id";

    //执行
    my_exec($sql);
?>