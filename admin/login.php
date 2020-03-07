<?php
include_once '../fn.php';
// 如果是POST方式，获取$POST中的数据，进行验证
if(!empty($_POST)){
  //  echo '<pre>';
  //   print_r($_POST);
  //   echo '</pre>';
  //1. 获取用户名和密码
  $email=$_POST['email'];
  $pwd=$_POST['password'];
  //2. 如果用户名和密码为空，则结束，输出$msg='用户名或密码为空'
  if(empty($email)||empty($pwd)){
    $msg='邮箱或密码为空';
  }else{
  //3. 如果两者不为空，则使用用户名去查询密码(重要)
    $sql="select * from users where email='$email'";
    $data=my_query($sql);
    if(empty($data)){
       //4. 如果查询结果为空，则返回$msg='用户名不存在'--(重要)
      $msg='邮箱不存在';
    }else{
      //5. 如果查询结果不为空，则验证密码是否正确
      $data=$data[0];
      if($pwd==$data['password']){
        // 为登陆成功的用户添加标记
        session_start();
        // 向session中存储数据
        $_SESSION['user_id']=$data['id'];
        //6. 如果密码相同，则跳转到首页；
        header('location:./index.php');
      }else{
        // 不同，则$msg='密码错误，请重新输入'
        $msg='密码错误，请重新输入';
      }
    }
  }
}
?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
  <meta charset="utf-8">
  <title>Sign in &laquo; Admin</title>
  <link rel="stylesheet" href="../assets/vendors/bootstrap/css/bootstrap.css">
  <link rel="stylesheet" href="../assets/css/admin.css">
</head>
<body>
  <div class="login">
    <form class="login-wrap" action="" method="POST" >
      <img class="avatar" src="../assets/img/default.png">
     <?php if(!empty($msg)){?>
    <div class="alert alert-danger">
    <strong>错误！</strong> <?php echo $msg ?>
    </div>
     <?php }?>
      <div class="form-group">
        <label for="email" class="sr-only">邮箱</label>
        <input id="email" type="email" class="form-control" placeholder="邮箱" autofocus name="email" value="<?php echo !empty($msg)?$email:'' ?>">
      </div>
      <div class="form-group">
        <label for="password" class="sr-only">密码</label>
        <input id="password" type="password" class="form-control" placeholder="密码" name="password">
      </div>     
      <input  class="btn btn-primary btn-block" type="submit" value="登录">
    </form>
  </div>
</body>
</html>
