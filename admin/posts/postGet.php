<?php
include_once '../../fn.php';
//根据前传递 页码 和每页数据条数， 返回对应的数据
$page = $_GET['page'];
$pageSize = $_GET['pageSize'];

//算出起始索引
$start = ($page - 1) * $pageSize;

//查询文章数据
$sql = "select posts.*, users.nickname, categories.name from posts  -- 查询基本数据
            join users on posts.user_id = users.id -- 连接用户表
            join categories on posts.category_id = categories.id -- 连接分类表
            order by posts.id desc  -- 根据文章id进行排序
            limit $start, $pageSize -- 分页功能";

//执行
$data = my_query($sql);

//返回json数据
echo json_encode($data);
