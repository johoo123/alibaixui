<?php
// echo '<pre>';
// print_r($_POST);
// echo '</pre>';
// print_r($_FILES);
include_once '../../fn.php';

// 接收返回的数据
$title = $_POST['title'];
$content = $_POST['content'];
$slug = $_POST['slug'];
$category = $_POST['category'];
$created = $_POST['created'];
$status = $_POST['status'];
// 文章作者----重要
session_start();
$userid = $_SESSION['user_id'];
$feature = '';

// 如果图片上传成功，则保存图片
$file = $_FILES['feature'];
if ($file['error'] === 0) {
    $ext = explode('.', $file['name'])[1]; //后缀名
    $newName = time() . rand(999, 10000) . '.' . $ext; //新文件名
    move_uploaded_file($file['tmp_name'], '../../uploads/' . $newName);
    //图片是多个页面共享的，尽量存储相对路径，我们确定图片一定放在uploads, 目录层级不能确定
    $feature = 'uploads/' . $newName;
}

// 3把文字的数据和 图片地址存储到数据库
$sql = "insert into posts (title, content, slug, category_id, created, status, user_id, feature)
                    values('$title', '$content', '$slug', $category, '$created', '$status', $userid, '$feature')";

echo $sql;

// 执行
my_exec($sql);

//跳转到文章列表页
header('location:../posts.php');
