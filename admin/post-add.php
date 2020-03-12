<?php

include_once '../fn.php';
isLogin();
?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
  <meta charset="utf-8">
  <title>Add new post &laquo; Admin</title>
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
        <h1>写文章</h1>
      </div>
      <!-- 有错误信息时展示 -->
      <!-- <div class="alert alert-danger">
        <strong>错误！</strong>发生XXX错误
      </div> -->
      <form class="row" action='./posts/postAdd.php' enctype="multipart/form-data" method='post'>
        <div class="col-md-9">
          <div class="form-group">
            <label for="title">标题</label>
            <input id="title" class="form-control input-lg" name="title" type="text" placeholder="文章标题">
          </div>
          <div class="form-group">
            <label for="content">标题</label>
            <textarea id="content" class="form-control input-lg hide" name="content" cols="30" rows="10" placeholder="内容"></textarea>
            <!-- 添加wangEditor的父容器 -->
            <div id="content-box"></div>
          </div>
        </div>
        <div class="col-md-3">
          <div class="form-group">
            <label for="slug">别名</label>
            <input id="slug" class="form-control" name="slug" type="text" placeholder="slug">
            <p class="help-block">https://zce.me/post/<strong id='strong'>slug</strong></p>
          </div>
          <div class="form-group">
            <label for="feature">特色图像</label>
            <!-- show when image chose -->
            <img class="help-block thumbnail" style="display: none" id='img'>
            <input id="feature" class="form-control" name="feature" accept="image/*" type="file">
          </div>
          <div class="form-group">
            <label for="category">所属分类</label>
            <select id="category" class="form-control" name="category">
              <option value="1">未分类</option>
              <option value="2">潮生活</option>
            </select>
          </div>
          <div class="form-group">
            <label for="created">发布时间</label>
            <input id="created" class="form-control" name="created" type="datetime-local">
          </div>
          <div class="form-group">
            <label for="status">状态</label>
            <select id="status" class="form-control" name="status">
              <option value="drafted">草稿</option>
            </select>
          </div>
          <div class="form-group">
            <button class="btn btn-primary" type="submit">保存</button>
          </div>
        </div>
      </form>
    </div>
  </div>
  <?php $page = 'post-add'?>
  <?php include_once './inc/aside.php';?>
<!-- 分类模版 -->
<script type='text/html' id='tmp-cate'>
    {{each list v i}}
        <option value="{{v.id}}">{{v.name}}</option>
    {{/each}}
  </script>
  <!-- 状态模版 -->
  <script type="text/html" id="tmp-state">
    {{each $data v k}}
      <option value="{{k}}">{{v}}</option>
    {{/each}}
  </script>

  <script src="../assets/vendors/jquery/jquery.js"></script>
  <script src="../assets/vendors/bootstrap/js/bootstrap.js"></script>
  <!-- 引入template模版文件 -->
  <script src="../assets/vendors/template/template-web.js"></script>
  <!-- 引入moment -->
  <script src='../assets/vendors/moment/moment.js'></script>
  <script>NProgress.done()</script>
  <!-- 引入富文本编辑器 -->
  <script src='../assets/vendors/wangEditor/wangEditor.js'></script>

  <script>
    //一、准备写文章页面
    // 1. 分类下拉数据填充
    // 2. 状态下拉数据填充
    // 3. 别名同步
    // 4. 默认时间设置
    // 5. 图片本地预览
    // 6. 富文本编辑器的使用
      // 获取分类数据
      $.ajax({
        url: './category/cateGet.php',
        dataType: 'json',
        success:function (info) {
          // console.log(info);    获取数据
          //动态渲染
          $('#category').html( template('tmp-cate', {list: info}) );
        }
      });
      // 状态
      var state = {
        drafted:'草稿',
        published: '已发布',
        trashed: '回收站',
        aa: 'bb',
        cc: 'dd'
      };
    // 用模版进行渲染---注意：一定要核查是否是对应的模版id
    $('#status').html(template('tmp-state', state));
    // 别名同步完成
    $('#slug').on('input',function(){
      $('#strong').text($(this).val()||'slug');
    })
    // 本地预览
    $('#feature').on('change',function(){
      var file=this.files[0];
      var url=URL.createObjectURL(file);
      $('#img').attr('src',url).show();
    })
    // 时间格式化
    $('#created').val(moment().format('YYYY-MM-DDTHH:mm'));
    // 富文本编辑器
    // 1. 先隐藏文本域
    // 2. 引入wangEditor.js
    // 3. 添加wangEditor的父容器
    // 4. 初始化
    var E = window.wangEditor;
    var editor = new E('#content-box');    
    //让富文本和textarea同步
    editor.customConfig.onchange = function (html) {
        // 监控变化，同步更新到 textarea
       $('#content').val(html);
    };
    editor.customConfig.menus  = [
      'head',  // 标题
      'bold',  // 粗体
      'fontSize',  // 字号     
      'underline',  // 下划线
      'strikeThrough',  // 删除线
      'foreColor',  // 文字颜色
      'backColor',  // 背景颜色
      'link',  // 插入链接
      'list',  // 列表
      'justify',  // 对齐方式     
      'emoticon',  // 表情
      'image',  // 插入图片
      'code',  // 插入代码
      'undo',  // 撤销
      'redo'  // 重复
    ];
    editor.create();
  </script>
</body>
</html>
