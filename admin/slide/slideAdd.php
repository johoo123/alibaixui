<?php 
    //获取前端表单提交的数据和图片 ， 添加到数据库中
    // text link image 
    // 如果没有上传图片，此数据无效，不保存
    include_once '../../fn.php';
    $file = $_FILES['image'];
    if ($file['error'] === 0) {
        //保存图片
        $ext = explode('.', $file['name'])[1]; //后缀名
        $newName = rand(99, 9999) . time() . '.' . $ext; //新文件名
        move_uploaded_file($file['tmp_name'], '../../uploads/' . $newName); //转移        
 
        $info['image'] = 'uploads/' . $newName;

        //或其他数据
        $info['text'] = $_POST['text'];
        $info['link'] = $_POST['link'];

        echo '<pre>';
        print_r($info);
        echo '</pre>';

        //将一维数组添加到二维数组中
         // 1-先获取数据库中json字符   
        // 获取全部轮播图数据的接口
        $sql = "select value from options where id = 10";
        // 执行
        $str= my_query($sql)[0]['value'];  
        // 2-转成数组
        $arr = json_decode($str, true);
        // 3-向数组中添加新数据
        $arr[] = $info;
        echo '<pre>';
        print_r($arr);
        echo '</pre>';
        // 4-再把数组转成json字符串
        //json_encode默认会将中文编程unicode编码 \uxxxx, 存储到数据中，\会丢失 
        // 解决方法， 可以通过参数设置，让encode对中文不进行编码直接原样存储， 
        // JSON_UNESCAPED_UNICODE  不讲中文进行转码
        $str = json_encode($arr, JSON_UNESCAPED_UNICODE);

        echo $str;
        // 5-把json字符串存储到数据库中  
        $sql1 = "update options set value = '$str' where id = 10";
        // 执行
        my_exec($sql1);    

    }
?>