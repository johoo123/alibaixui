<?php
//封装执行 非查询语句 和执行 查询语句的方法
//定义一下公共常量
define('HOST', 'alibaixiu:3310');
define('UNAME', 'root');
define('PWD', 'root');
define('DB', 'z_baixiu');

//封装执行非查询语句方法
// 参数：sql
// 返回值： 成功true  失败false
function my_exec($sql)
{
    //1-连接数据库
    $link = mysqli_connect(HOST, UNAME, PWD, DB);
    //2-执行
    $result = mysqli_query($link, $sql);
    //3-判断
    if ($result) {
        echo '执行成功';
    } else {
        echo '执行失败';
    }
    //4-关闭数据
    mysqli_close($link);
    return $result;
}

//封装执行查询语句方法
function my_query($sql)
{
    //1-连接数据库
    $link = mysqli_connect(HOST, UNAME, PWD, DB);
    //2-执行sql
    $result = mysqli_query($link, $sql);
    $num = mysqli_num_rows($result); //获取结果集条数
    //3-判断是否查询到结果
    if (!$result || $num == 0) {
        echo '未获取到数据';
        return false;
    }
    //4-保存获取到数据
    $data = [];
    for ($i = 0; $i < $num; $i++) {
        $data[] = mysqli_fetch_assoc($result);
    }
    //5-关闭数据库
    mysqli_close($link);
    //返回查询的数据
    return $data;
}
// $sql="select * from users";
// echo '<pre>';
// print_r(my_query($sql));
// echo '</pre>';
function isLogin(){
    if(empty($_COOKIE['PHPSESSID'])){
        // 去登陆
        header('location:./login.php');
        die();
    }else{
        session_start();//先开启session
        if(empty($_SESSION['user_id'])){
            header('location:./login.php');
            die();
        }
    }
}
?>