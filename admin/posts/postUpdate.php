<?php 
    // echo '<pre>';
    // print_r($_POST);
    // echo '</pre>';

    // echo '<pre>';
    // print_r($_FILES);
    // echo '</pre>';
    include_once '../../fn.php';

    // 1-后台获取前端传递数据和图片
    // 2-根据id修改对应的数据
    $id = $_POST['id'];
    $title = $_POST['title'];
    $content = $_POST['content'];
    $slug = $_POST['slug'];
    $category = $_POST['category'];
    $created = $_POST['created'];
    $status = $_POST['status'];
    $feature = '';

    //2-保存图片
    $file = $_FILES['feature'];
    if ($file['error'] === 0) {
        $ext = explode('.', $file['name'])[1]; //后缀名
        $newName = rand(999, 10000) . time() . '.' . $ext; // 新文件名
        move_uploaded_file($file['tmp_name'], '../../uploads/'.$newName);
        $feature = 'uploads/'.$newName;
    }


    //如果用户没有上传新图片，继续保留原图片， 如果上了图片，用新图片替换旧图片
    //3-准备sql语句 
    if (empty($feature)) {
        $sql = "update posts set title = '$title', content='$content', slug='$slug', category_id = $category,
        created = '$created', status = '$status' where id = $id";
    } else {
        $sql = "update posts set title = '$title', content='$content', slug='$slug', category_id = $category,
        created = '$created', status = '$status', feature = '$feature' where id = $id";
    }

    echo $sql;

    //执行 
    my_exec($sql);

?>