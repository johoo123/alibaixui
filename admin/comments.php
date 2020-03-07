<?php

include_once '../fn.php';
isLogin();
?>

<!DOCTYPE html>
<html lang="zh-CN">
<head>
  <meta charset="utf-8">
  <title>Comments &laquo; Admin</title>
  <link rel="stylesheet" href="../assets/vendors/bootstrap/css/bootstrap.css">
  <link rel="stylesheet" href="../assets/vendors/font-awesome/css/font-awesome.css">
  <link rel="stylesheet" href="../assets/vendors/nprogress/nprogress.css">
  <link rel="stylesheet" href="../assets/css/admin.css">
  <!-- 引入分页插件的css -->
  <link rel='stylesheet' href='../assets/vendors/pagination/pagination.css'>
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
        <h1>所有评论</h1>
      </div>
      <!-- 有错误信息时展示 -->
      <!-- <div class="alert alert-danger">
        <strong>错误！</strong>发生XXX错误
      </div> -->
      <div class="page-action">
        <!-- show when multiple checked -->
        <div class="btn-batch pull-left" style="display">
          <button class="btn btn-info btn-sm btn-approveds">批量批准</button>
          <button class="btn btn-danger btn-sm btn-dels">批量删除</button>
        </div>
        <!-- 分页标签插件需要一个父容器 -->
        <div class="page-box pull-right"></div>
      </div>
      <table class="table table-striped table-bordered table-hover">
        <thead>
          <tr>
            <th class="text-center" width="40"><input type="checkbox" class="th-chk"></th>
            <th>作者</th>
            <th>评论</th>
            <th>评论在</th>
            <th>提交于</th>
            <th>状态</th>
            <th class="text-center" width="100">操作</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td class="text-center"><input type="checkbox"></td>
            <td>大大</td>
            <td>楼主好人，顶一个</td>
            <td>《Hello world》</td>
            <td>2016/10/07</td>
            <td>未批准</td>
            <td class="text-center">
              <a href="post-add.html" class="btn btn-info btn-xs">批准</a>
              <a href="javascript:;" class="btn btn-danger btn-xs">删除</a>
            </td>
          </tr>
          <tr>
            <td class="text-center"><input type="checkbox"></td>
            <td>大大</td>
            <td>楼主好人，顶一个</td>
            <td>《Hello world》</td>
            <td>2016/10/07</td>
            <td>已批准</td>
            <td class="text-center">
              <a href="post-add.html" class="btn btn-warning btn-xs">驳回</a>
              <a href="javascript:;" class="btn btn-danger btn-xs">删除</a>
            </td>
          </tr>
          <tr>
            <td class="text-center"><input type="checkbox"></td>
            <td>大大</td>
            <td>楼主好人，顶一个</td>
            <td>《Hello world》</td>
            <td>2016/10/07</td>
            <td>已批准</td>
            <td class="text-center">
              <a href="post-add.html" class="btn btn-warning btn-xs">驳回</a>
              <a href="javascript:;" class="btn btn-danger btn-xs">删除</a>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>

  <div class="aside">
    <div class="profile">
      <img class="avatar" src="../uploads/avatar.jpg">
      <h3 class="name">布头儿</h3>
    </div>
    <ul class="nav">
      <li>
        <a href="index.html"><i class="fa fa-dashboard"></i>仪表盘</a>
      </li>
      <li>
        <a href="#menu-posts" class="collapsed" data-toggle="collapse">
          <i class="fa fa-thumb-tack"></i>文章<i class="fa fa-angle-right"></i>
        </a>
        <ul id="menu-posts" class="collapse">
          <li><a href="posts.html">所有文章</a></li>
          <li><a href="post-add.html">写文章</a></li>
          <li><a href="categories.html">分类目录</a></li>
        </ul>
      </li>
      <li class="active">
        <a href="comments.html"><i class="fa fa-comments"></i>评论</a>
      </li>
      <li>
        <a href="users.html"><i class="fa fa-users"></i>用户</a>
      </li>
      <li>
        <a href="#menu-settings" class="collapsed" data-toggle="collapse">
          <i class="fa fa-cogs"></i>设置<i class="fa fa-angle-right"></i>
        </a>
        <ul id="menu-settings" class="collapse">
          <li><a href="nav-menus.html">导航菜单</a></li>
          <li><a href="slides.html">图片轮播</a></li>
          <li><a href="settings.html">网站设置</a></li>
        </ul>
      </li>
    </ul>
  </div>
  <!-- 页面标识 -->
  <?php $page = 'comments'?>
  <!-- 引入侧边栏 -->
  <?php include_once './inc/aside.php';?>
  <script src="../assets/vendors/jquery/jquery.js"></script>
  <script src="../assets/vendors/bootstrap/js/bootstrap.js"></script>
  <!-- 引入template模版文件 -->
  <script src="../assets/vendors/template/template-web.js"></script>
  <!-- 引入分页插件的js文件 -->
  <script src="../assets/vendors/pagination/jquery.pagination.js"></script>
  <script>NProgress.done()</script>

  <!-- 书写模版 -->
  <script type='text/html' id='tmp'>
    {{each list v i}}
        <tr>
            <td class="text-center" data-id={{v.id}}><input class='tb-chk' type="checkbox"></td>
            <td>{{v.author}}</td>
            <td>{{v.content}}</td>
            <td>{{v.title}}</td>
            <td>{{v.created}}</td>
            <td>{{state[v.status]}}</td>
            <td class="text-right" data-id={{v.id}}>
            {{if v.status=='held'}}
              <a href="javascript:;" class="btn btn-info btn-xs btn-approved">批准</a>
            {{/if}}
              <a href="javascript:;" class="btn btn-danger btn-xs btn-del">删除</a>
            </td>
        </tr>
    {{/each}}
  </script>
  <!-- 请求数据 -->
  <script>

    // 待审核（held）/ 准许（approved）/ 拒绝（rejected）/ 回收站（trashed）
    var state={
      'rejected':'拒绝',
      'held':'待审核',
      'approved':'准许',
      'trashed':'回收站',
    }
    // 初始化当前页
    var currentPage=1;
    // 页面打开时，获取第一屏并渲染
    render();
    function render(page) {
      $.ajax({
        url: './comments/comGet.php',
        data: {
          page: page || 1,
          pageSize: 10
        },
        dataType: 'json',
        success: function(info) {
          // console.log(info);
          var obj = {
              list: info,
              state: state
            };
          //渲染
          $('tbody').html( template('tmp', obj) );
          //重置 全选按钮 和批量按钮
          $('.th-chk').prop('checked', false);
          $('.btn-batch').hide();
        }
      })
    }
    // 3-生成分页标签
    function setPage(page){
      // 1-获取有效的评论总数
      $.ajax({
        url:'./comments/comTotal.php',
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
    // 4- 生成分页
    setPage();
    // 5- 批准--使用事件委托，为“批准”按钮绑定点击事件
    // 批准思路：
      // 1- 点击批准按钮，获取当前数据id
      //2- 后台根据前端传入的id，修改对应的数据库中status的值
      //3- 重新渲染，保留在当前页
    $('tbody').on('click','.btn-approved',function(){
      // 获取当前数据的id,因为id在tr中存储，所以找parent，attr是jquery中获取自定义属性的方法
      var id=$(this).parent().attr('data-id');
      console.log(id);
      $.ajax({
        url:'./comments/comApproved.php',
        data:{
          id:id
        },
        success:function(info){
          console.log(info);
          // 重新渲染,传入当前页
          render(currentPage);
        }
      })
    })
    // 6- 删除评论(遗留问题---渲染未解决)
      //1- 点击删除按钮，获取当前数据id
      //2- 后台根据传递过来的id删除数据库数据
      //3- 重新渲染
    $('tbody').on('click','.btn-del',function(){
      // 获取当前id
      var id=$(this).parent().attr('data-id');
      // 将id传递给后台
      console.log(id);
      $.ajax({
        url:'./comments/comDel.php',
        data: {id: id},
        dataType: 'json',
        success:function (info) {
          console.log(123456);
          var maxPage = Math.ceil(info.total / 10);
          //对currentPage进行判断，
          // 判断currentPage值是否大于 服务器的最大页码 39
          //如果currentPage值 大于服务器最大页码，将最大页码赋值给currentPage
          if (currentPage > maxPage ) {
            currentPage = maxPage;
          }
          //重新渲染当前页
          render(currentPage);  //40
          //重新调用分页 页面比索引值大1
          setPage(currentPage); //40
        }
      })
    })
    // 7- 全选和复选框
    $('.th-chk').on('change',function(){
      // 获取表单的值
      var value=$(this).prop('checked');//表单布尔值使用prop
      // console.log(value);
      // 1- 小复选框和全选按钮一样
      $('.tb-chk').prop('checked',value);//将所有的小复选框选中/不选中
      //2- 出现批量按钮
      if(value){
        $('.btn-batch').show();
      }else{
        $('.btn-batch').hide();
      }
    })
    // 8- 多选功能
    // 如果小复选框选中的个数==小复选框总数，那么全选也勾选
    $('tbody').on('change','.tb-chk',function(){
      // 注意这里选择已勾选的选择器
      if($('.tb-chk:checked').length==$('.tb-chk').length){
        $('.th-chk').prop('checked',true);
      }else{
        $('.th-chk').prop('checked',false);
      }
      if($('.tb-chk:checked').length>0){
        $('.btn-batch').show();//批量按钮显示
      }else{//批量按钮隐藏
        $('.btn-batch').hide();
      }
    })
    // 9-获取id
    function getId() {
      var ids = []; //存储被选中id
      //获取被选中的小复选框    
      // console.log($('.tb-chk:checked'));     
      $('.tb-chk:checked').each(function (index, ele) {
        var id =  $(ele).parent().attr('data-id');
        ids.push(id);
      })
      ids = ids.join();
      // console.log(ids);     
      return ids; //返回获取的id 
    }  

    // 10-批量批准
    $('.btn-approveds').click(function(){
      var ids=getId();
      console.log(ids);
      $.ajax({
        url:'./comments/comApproved.php',
        data:{
          id:ids
        },
        success:function(){
          render(currentPage);
        }
      })
    })
    $('.btn-dels').click(function(){
      // 获取id
      var ids=getId();
      // 传递给后台
      $.ajax({
        url:'./comments/comDel.php',
        data:{id:ids},
        success:function(info){
          if(currentPage>maxPage){
            currentPage=maxPage;
          }
          render(currentPage);
          setPage(currentPage);
          var maxPage=Math.ceil(info.total/10);
          
        }
      })
    })

  </script>

</body>
</html>
