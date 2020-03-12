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
  <?php include_once './inc/edit.php' ?>
  <script src="../assets/vendors/jquery/jquery.js"></script>
  <script src="../assets/vendors/bootstrap/js/bootstrap.js"></script>
  <!-- 引入template模版文件 -->
  <script src="../assets/vendors/template/template-web.js"></script>
  <!-- 引入分页插件的js文件 -->
  <script src="../assets/vendors/pagination/jquery.pagination.js"></script>
  <script>NProgress.done()</script>
  <script src="../assets/vendors/moment/moment.js"></script>
  <script src="../assets/vendors/wangEditor/wangEditor.js"></script>
  <!-- 渲染文章的模版 -->
  <script type='text/html' id='tmp'>
    {{each list v i}}
          <tr>
            <td class="text-center"><input type="checkbox"></td>
            <td>{{v.title}}</td>
            <td>{{v.nickname}}</td>
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
   <!-- 分类模版引擎 -->
   <script type="text/html" id="tmp-cate">
    {{ each $data.list v i }}
      <option value="{{ v.id }}">{{ v.name }}</option>
    {{ /each }}
  </script>
  <!-- 状态模版 -->

  <script type="text/html" id="tmp-state">
    {{ each $data v k }}
      <option value="{{ k }}">{{ v  }}</option>
    {{ /each }}
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
          // console.log(info);
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
    //6-准备模态框的数据
    // 填充分类下拉列表
    $.ajax({
      url: './category/cateGet.php',
      dataType: 'json',
      success:function (info) {
        console.log(info);    //数组
        //动态渲染
        $('#category').html( template('tmp-cate', {list: info}) ); 
      }
    });
    // 填充状态列表的
    // 用模版进行渲染
    $('#status').html(template('tmp-state', state));

    // 别名同步
    $('#slug').on('input', function () {
      $('#strong').text($(this).val() || 'slug');
    });

    // 本地预览
    $('#feature').on('change', function () {
      //获取被选中文件
      var file = this.files[0];
      //通过文件的对应地址
      var url = URL.createObjectURL(file);
      //显示
      $('#img').attr('src', url).show();
    })
   
    // 时间格式化
    $('#created').val( moment().format('YYYY-MM-DDTHH:mm')  );

    // 准备富文本编辑器    
    var E = window.wangEditor;
    var editor = new E('#content-box');
    //和textarea同步
    editor.customConfig.onchange = function (html) {
        // 监控变化，同步更新到 textarea
       $('#content').val(html);
    }
    editor.create();
    // 根据id返回文章
    // 7-点击编辑按钮，去后台获取对应的文章数据，填充在模态框中
    $('tbody').on('click', '.btn-edit', function () {
      //获取id 
      var id = $(this).parent().attr('data-id');
      //获取数据
      $.ajax({
        url: './posts/postGetById.php',
        data:{
          id: id
        },
        dataType: 'json',
        success: function (info) {
          console.log(info);
          //显示模态框
          $('.edit-box').show();     
          //向模态框中填充数据
          // 标题
          $('#title').val(info.title);
          // 别名(strong标签也要修改)
          $('#slug').val(info.slug);
          $('#strong').text(info.slug);
          // 图像（用img标签显示）
          $('#img').attr('src', '../' + info.feature).show();
          // 时间设置(注意格式)
          $('#created').val(moment(info.created).format('YYYY-MM-DDTHH:mm'));
          
          // 文章内容设置(同时设置textarea  和 富文本编辑器 )
          editor.txt.html(info.content)
          $('#content').val(info.content);

          // 分类选中(selected)
          $('#category option[value='+ info.category_id+']').prop('selected', true);
          // 状态选中(selected)
          $('#status option[value='+ info.status +']').prop('selected', true);
          // 设置id          
          $('#id').val(info.id);     
        }
      })
    });
    // 8-放弃功能
    $('#btn-cancel').click(function(){
      $('.edit-box').hide();
    })
    // 9-提交编辑数据
    $('#btn-update').click(function () {
       //获取表单数据
       var fd = new FormData( $('#editForm')[0] );
       //FormData 
      //  1-必须用post请方式
      //  2-不能手动设置请求头
       //上传
       $.ajax({
         url:'./posts/postUpdate.php',
         type: 'post', 
         data: fd,
         contentType: false, //让$.ajax不设置content-Type属性
         processData: false, //告诉$.ajax内部不需要去转换数据，因为数据已经有FormData进行处理
         success: function (info) {
          console.log(info);       
          //隐藏模态框
          $('.edit-box').hide();
          //重新渲染当前页  
          render(currentPage);
         }
       })
    });

  </script>
</body>
</html>
