<?php 
    include_once '../../fn.php';
    //根据前端传递id， 返回对应文章数据接口
    $id = $_GET['id']; 
    //$sql 
    $sql = "select * from posts where id = $id";
    //执行
    $data = my_query($sql)[0];
    //返回
    echo json_encode($data);
?>