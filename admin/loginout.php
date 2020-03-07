<!-- 退出登陆 -->
<?php
session_start();//开启session
echo '我已经被执行了';
unset($_SESSION['user_id']);
// 自动跳转到login.php
header('location:./login.php');
?>