<?php
include_once '../../fn.php';
$page = $_GET['page'];
$pageSize = $_GET['pageSize'];
$start = ($page - 1) * $pageSize;
$sql = "select comments.* , posts.title from comments
        join posts on comments.post_id = posts.id  -- 连接文章表一起查
        limit $start, $pageSize;  -- 截取 limt 起始索引 截取长度";
$data=my_query($sql);
echo json_encode($data);

?>