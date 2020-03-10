<?php
include_once '../../fn.php';
$id = $_GET['id'];
$sql = "delete from posts where id in ($id)";
// 删除
my_exec($sql);
// 重新渲染有效总数，因为越删除数据越少
$sql1 = "select count(*) as 'total' from posts  -- 查询基本数据
join users on posts.user_id = users.id -- 连接用户表
join categories on posts.category_id = categories.id -- 连接分类表
";
$data = my_query($sql1)[0];
echo json_encode($data);
