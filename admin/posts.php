<?php

include_once '../fn.php';
isLogin();
?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
  <meta charset="utf-8">
  <title>Posts &laquo; Admin</title>
  <link rel="stylesheet" href="../assets/vendors/bootstrap/css/bootstrap.css">
  <link rel="stylesheet" href="../assets/vendors/font-awesome/css/font-awesome.css">
  <link rel="stylesheet" href="../assets/vendors/nprogress/nprogress.css">
  <link rel="stylesheet" href="../assets/css/admin.css">
  <script src="../assets/vendors/nprogress/nprogress.js"></script>
  <!-- 引入分页插件的css -->
  <link rel='stylesheet' href='../assets/vendors/pagination/pagination.css'>
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
        <h1>所有文章</h1>
        <a href="post-add.html" class="btn btn-primary btn-xs">写文章</a>
      </div>
      <!-- 有错误信息时展示 -->
      <!-- <div class="alert alert-danger">
        <strong>错误！</strong>发生XXX错误
      </div> -->
      <div class="page-action">
        <!-- show when multiple checked -->
        <a class="btn btn-danger btn-sm" href="javascript:;" style="display: none">批量删除</a>
        <!-- 分页的父容器 -->
        <div class="page-box pull-right"></div>
      </div>
      <table class="table table-striped table-bordered table-hover">
        <thead>
          <tr>
            <th class="text-center" width="40"><input type="checkbox"></th>
            <th>标题</th>
            <th>作者</th>
            <th>分类</th>
            <th class="text-center">发表时间</th>
            <th class="text-center">状态</th>
            <th class="text-center" width="100">操作</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td class="text-center"><input type="checkbox"></td>
            <td>随便一个名称</td>
            <td>小小</td>
            <td>潮科技</td>
            <td class="text-center">2016/10/07</td>
            <td class="text-center">已发布</td>
            <td class="text-center">
              <a href="javascript:;" class="btn btn-default btn-xs">编辑</a>
              <a href="javascript:;" class="btn btn-danger btn-xs">删除</a>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>

  <?php $page = 'posts'?>
  <?php include_once './inc/aside.php';?>
  <script src="../assets/vendors/jquery/jquery.js"></script>
  <script src="../assets/vendors/bootstrap/js/bootstrap.js"></script>
  <!-- 引入template模版文件 -->
  <script src="../assets/vendors/template/template-web.js"></script>
  <!-- 引入分页插件的js文件 -->
  <script src="../assets/vendors/pagination/jquery.pagination.js"></script>
  <script>NProgress.done()</script>
  <!-- 渲染文章的模版 -->
  <script type='text/html' id='tmp'>
    {{each list v i}}
          <tr>
            <td class="text-center"><input type="checkbox"></td>
            <td>{{v.title}}</td>
            <td>{{v.author}}</td>
            <td>{{v.name}}</td>
            <td class="text-center">{{v.created}}</td>
            <td class="text-center">{{state[v.status]}}</td>
            <td class="text-center" data-id="{{v.id}}">
              <a href="javascript:;" class="btn btn-default btn-xs btn-edit" >编辑</a>
              <a href="javascript:;" class="btn btn-danger btn-xs btn-del">删除</a>
            </td>
          </tr>
    {{/each}}
  </script>
  <script>
    // 初始化状态
    var state={
      drafted:'草稿',
      published:'出版',
      trashed:'已回收'
    }
    // 初始化当前页
    var currentPage=1;
    // 请求数据
    render();
    function render(page){
      $.ajax({
        url:'./posts/postGet.php',
        data:{
          page:page||1,
          pageSize:10
        },
        dataType:'json',
        success:function(info){
          //渲染
          var obj={list:info,state:state}
          $('tbody').html( template('tmp', obj) );
        }
      })
    }
    // 调用生成分页函数
    setPage();
    // 分页标签生成
    function setPage(page){
      // 1-获取有效的评论总数
      $.ajax({
        url:'./posts/postTotal.php',
        dataType:'json',
        success:function(info){
          // 2-根据总数生成分页标签
          // console.log(info);
          $('.page-box').pagination(info.total,{
            prev_text: "« 上一页",
            next_text: "下一页 »",
            num_edge_entries: 1,       //两侧首尾分页条目数
            num_display_entries: 5,    //连续分页主体部分分页条目数
            current_page: page-1||0,   //当前页索引
            load_first_page:false,//初始化不执行回调函数
            callback:function(index){
              // alert(index);
              // 因为$start=($page-1)*$pageSize,所以这里使用index+1
              render(index+1);
              // 更改当前页，修改完数据库重新渲染的时候传入当前页
              currentPage=index+1;
            }
          })
        }
      })
    }
    // 删除文章
    $('tbody').on('click','.btn-del',function(){
      var id=$(this).parent().attr('data-id');
      $.ajax({
        url:'./posts/postDel.php',
        data:{id:id},
        success:function(info){
          var maxPage=Math.ceil(info.total/10);
          if(currentPage>maxPage){
            currentPage=maxPage;
          }
          render(currentPage);
          setPage(currentPage);
        }
      })
    })
    
  </script>
</body>
</html>
