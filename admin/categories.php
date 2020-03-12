<?php

include_once '../fn.php';
isLogin();

?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
  <meta charset="utf-8">
  <title>Categories &laquo; Admin</title>
  <link rel="stylesheet" href="../assets/vendors/bootstrap/css/bootstrap.css">
  <link rel="stylesheet" href="../assets/vendors/font-awesome/css/font-awesome.css">
  <link rel="stylesheet" href="../assets/vendors/nprogress/nprogress.css">
  <link rel="stylesheet" href="../assets/css/admin.css">
  <script src="../assets/vendors/nprogress/nprogress.js"></script>
</head>
<body>
  <script>NProgress.start()</script>

  <div class="main">
    <nav class="navbar">
      <button class="btn btn-default navbar-btn fa fa-bars"></button>
      <ul class="nav navbar-nav navbar-right">
        <li><a href="profile.html"><i class="fa fa-user"></i>个人中心</a></li>
        <li><a href="login.html"><i class="fa fa-sign-out"></i>退出</a></li>
      </ul>
    </nav>
    <div class="container-fluid">
      <div class="page-title">
        <h1>分类目录</h1>
      </div>
      <!-- 有错误信息时展示 --> 
      <div class="alert alert-danger msg" style="display: none">
        <strong>错误！</strong><span class="msg-txt">xxx</span>
      </div>
      <div class="row">
        <div class="col-md-4">
          <form id='form'>
            <h2>添加新分类目录</h2>
            <input type="hidden" name="id" id="id">
            <div class="form-group">
              <label for="name">名称</label>
              <input id="name" class="form-control" name="name" type="text" placeholder="分类名称">
            </div>
            <div class="form-group">
              <label for="slug">别名</label>
              <input id="slug" class="form-control" name="slug" type="text" placeholder="slug">
              <p class="help-block">https://zce.me/category/<strong>slug</strong></p>
            </div>
            <div class="form-group">
              <input type="button" class="btn btn-primary btn-add" value="添加">
              <input type="button" class="btn btn-primary btn-update" value="编辑" style="display:none">
            </div>
          </form>
        </div>
        <div class="col-md-8">
          <div class="page-action">
            <!-- show when multiple checked -->
            <a class="btn btn-danger btn-sm" href="javascript:;" style="display: none">批量删除</a>
          </div>
          <table class="table table-striped table-bordered table-hover">
            <thead>
              <tr>
                <th class="text-center" width="40"><input type="checkbox"></th>
                <th>名称</th>
                <th>分类</th>
                <th class="text-center" width="100">操作</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td class="text-center"><input type="checkbox"></td>
                <td>未分类</td>
                <td>uncategorized</td>
                <td class="text-center">
                  <a href="javascript:;" class="btn btn-info btn-xs">编辑</a>
                  <a href="javascript:;" class="btn btn-danger btn-xs">删除</a>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>

<!-- 渲染分类的模版 -->
<!-- 分类模版 -->
<script type='text/html' id='tmp-cate'>
    {{each list v i}}
    <tr >
      <td class="text-center" data-id={{v.id}}><input type="checkbox"></td>
      <td>{{v.name}}</td>
      <td>{{v.slug}}</td>
      <td class="text-center" data-id={{v.id}}>
        <a href="javascript:;" class="btn btn-info btn-xs btn-edit">编辑</a>
        <a href="javascript:;" class="btn btn-danger btn-xs btn-del">删除</a>
      </td>
    </tr>
    {{/each}}
  </script>
  <?php $page = 'categories'?>
  <?php include_once './inc/aside.php';?>
  <script src="../assets/vendors/jquery/jquery.js"></script>
  <script src="../assets/vendors/bootstrap/js/bootstrap.js"></script>
  <!-- 引入template模版文件 -->
  <script src="../assets/vendors/template/template-web.js"></script>
  <script>NProgress.done()</script>

  <script>
  render();
  // 1-分类渲染
  function render(){
      $.ajax({
        url:'./category/cateGet.php',
        dataType:'json',
        success:function(info){
          console.log(info);
          $('tbody').html(template('tmp-cate',{list:info}));
        }
      })
    }
  // 2-点击删除分类
  $('tbody').on('click','.btn-del',function(){
    var id=$(this).parent().attr('data-id');
    console.log(id);
    $.ajax({
      url:'./category/cateDel.php',
      data:{id:id},
      dataType:'json',
      success:function(){
        // console.log(info);
        render();
      }
    })
  })
  // 3- 点击添加分类
  $('.btn-add').click(function(){
    // 获取表单数据---表单序列化
    var str=$('#form').serialize();
    console.log(str);
    // 传递数据给后台
    $.ajax({
      url:'./category/cateAdd.php',
      data:str,
      beforeSend:function(){
        // 对数据进行判断
        if($('#name').val().trim().length==0||$('#slug').val().trim().length()==0){
          // 显示错误提示
          $('.msg').show();
          $('.msg-txt').text('数据不能为空');
          return false;
        }else{
          $('.msg').hide();
        }
      },
      success:function(info){
        render();
        // 表单的重置
        $('#form')[0].reset();
      }
    })
  })
  // 4- 编辑分类
  // 4.1-点击编辑按钮，渲染数据
  $('tbody').on('click','.btn-edit',function(){
    var id=$(this).parent().attr('data-id');
    // console.log(id);
    $.ajax({
      url:'./category/cateGetById.php',
      data:{
        id:id
      },
      dataType:'json',
      success:function(info){
        // console.log(info);
        $('#name').val(info.name);
        $('#slug').val(info.slug);
        $('#id').val(info.id);
        $('.btn-add').hide();
        $('.btn-update').show();
      }
    })
  })
  // 4.2-点击编辑（.btn-update）按钮，提交更新数据
  $('.btn-update').click(function(){
    // 表单序列化
    var str=$('#form').serialize();
    // 把数据发送给后台
    $.ajax({
      url:'./category/cateUpdate.php',
      data:str,
      success:function(info){
        console.log(info);
        render();
        $('#form')[0].reset();
        $('.btn-add').show();
        $('.btn-update').hide();
      }
    })
  })
  
  
  </script>
</body>
</html>
