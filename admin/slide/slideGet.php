<?php 
    include_once '../../fn.php';
    //获取全部轮播图数据的接口
    $sql = "select value from options where id = 10";
    //执行
    $data = my_query($sql)[0]['value'];  
    //返回
    // echo '<pre>';
    // print_r($data);
    // echo '</pre>';

    echo $data;
?>