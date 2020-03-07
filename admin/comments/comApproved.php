<?php 
    include_once '../../fn.php';
    // 根据前端传递id，批准对应数据
    $id=$_GET['id'];
    // 当前held的状态修改为approved
    $sql="update comments set status='approved' where id in ($id) and status='held' ";
    if(my_exec($sql)){
        echo '执行成功';
    }else{
        echo "执行失败";
    }
?>