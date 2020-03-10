<?php
include_once '../../fn.php';
//查询文章数据
$sql = "select count(*) as 'total' from posts  -- 查询基本数据
join users on posts.user_id = users.id -- 连接用户表
join categories on posts.category_id = categories.id -- 连接分类表
";
// 执行
$data=my_query($sql)[0];
echo json_encode($data);
?>
