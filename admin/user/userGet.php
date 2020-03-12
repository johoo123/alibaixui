<?php 
    // 返回所有的用户数据
    include_once '../../fn.php';
    //sql
    $sql = "select * from users";
    //执行
    $data = my_query($sql);
    //返回
    echo json_encode($data);
?>