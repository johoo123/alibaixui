<?php 
    include_once '../../fn.php';
    header('content-type:text/html;charset=utf-8');
    // 根据前端传递的id, 删除对应的数据
    $id = $_GET['id'];
    //准备sql
    $sql = "delete from comments where id in ($id)";
    //执行
    if(my_exec($sql)){
        echo '删除成功';
    }else{
        echo '删除失败';
    };
    
    //删除副作用 ： 数据会越来越少，导致页面分页必须重新渲染
    // 在每次删除完成后，重新查询数据库中有效评论总数，返回给前端，方便前端判断是否要重新生成分页标签；
    $sql1 = "select count(*) as 'total' from comments join posts on comments.post_id = posts.id";
    // 执行
    $data = my_query($sql1)[0];

    //返回删除后数据库剩余评论总数
    echo json_encode($data);
    
?>