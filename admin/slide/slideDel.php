<?php 
     include_once '../../fn.php';
    //根据前端传递id，删除对应下标的数据
    $id = $_GET['id'];
    //根据id进行删除
    // 1-先获取数据库中json字符   
    // 获取全部轮播图数据的接口
    $sql = "select value from options where id = 10";
    // 执行
    $str= my_query($sql)[0]['value'];  
    // 2-转成数组
    $arr = json_decode($str, true);
    // echo '<pre>';
    // print_r($arr);
    // echo '</pre>';
    // 3-从数组中删除指定索引元素
    // js -->arr.splice(起始索引， 删几个， 添加项)
    //  array_splice(数组， 起始索引，删几个，替换项);
    array_splice($arr, $id, 1);  
    // 4-在把数组转成json字符串
    //如果是中文，直接原样存储，不进行编码
    $str = json_encode($arr,  JSON_UNESCAPED_UNICODE);
    // 5-把json字符串更新回到数据库中
    $sql1 = "update options set value = '$str' where id = 10";
    // 执行
    my_exec($sql1);    
    // 'abc' + 'bcd' = 0;
?>