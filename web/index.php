<?php 
require 'inc/ojsettings.php';
function encode_user_id($user)
{
  if(!extension_loaded('openssl'))
    return false;
  $iv='7284565820000000';
  $key=hash('sha256','my)(password_xx0',true);
  return openssl_encrypt($user,'aes-256-cbc',$key,false,$iv);
}
require('inc/checklogin.php');
require('inc/database.php');
$res=mysqli_query($con,"select content from news where news_id=0");
$index_text=($row=mysqli_fetch_row($res)) ? $row[0] : '';
$res=mysqli_query($con,"select news_id,title from news where news_id>0 order by news_id desc");
$hasnews=0;
$newsrow=mysqli_fetch_row(mysqli_query($con,"select max(news_id) from news"));
if($newsrow[0]>0) $hasnews=1;
$categoryrow=mysqli_fetch_row(mysqli_query($con,"select content from user_notes where id=0"));
$category=$categoryrow[0];
$inTitle='主页';
$Title=$inTitle .' - '. $oj_name;
$num=0;
?>
<!DOCTYPE html>
<html>
<?php require('head.php');?>
  <body>
    <?php require('page_header.php');?>  
    <div class="container-fluid">
      <div class="row-fluid">
        <div class="span10 offset1">
          <div id="newspad" class="well-index" style="font-size:16px;padding:19px 40px;background-color:none">
            <div id="title" class="center" style="text-align:center; cursor: pointer;">
				<h1>公告栏</h1>
            </div> 
            <div id="mainarea" style="display:">
                <?php echo $index_text?>
            </div>
			<div id="title" class="center" style="text-align:center; font-size:24px;cursor:pointer;">
				<h2><b><i class="icon-double-angle-up"></i></b></h2>
            </div>
          </div>
        </div>
      </div>
	  <div class="row-fluid">
		<div class="span5 offset1">
	    <h1>新闻<?php if($hasnews==1){?><a href="news.php" class="pull-right"><font size=2>更多历史新闻...</font></a></h1><br>
		  <ul class="nav">
                <?php 
                while($row=mysqli_fetch_row($res)){
					$num++;
					echo '<li><p><font size=3><a href="javascript:void(0);" onclick="click_news(',$row[0],')">',htmlspecialchars($row[1]),'</a></font></p></li>';
					if($num==$news_num) break;
                }
                ?>
		  </ul><?php }else{?></h1>
		  <br><p><font color='grey' size=5>:( 暂时没有发布过新闻~</font></p>
		  <?php }?>
	  </div>
      <div class="span6">
        <h1>分类</h1><br>
		<?php if($category!='') echo "$category";
		      else echo'<p><font color="grey" size=5>:( 暂时没有发布题目分类目录~</font></p>';?>
	  </div>
	  </div>
	  <div class="row-fluid">
        <p></p>
      </div>
      <hr>
      <footer>
        <p>&copy; <?php echo"{$year} {$oj_copy}";?></p>
      </footer>
    </div>
	
	<div class="modal fade hide" id="NewsModal" style="margin-top:100px">
      <div class="modal-header">
        <a class="close" data-dismiss="modal">&times;</a>
        <h4><span class="hide" id="ajax_newstitle"></span></h4>
      </div>
      <form class="margin-0" action="#" method="post" id="news_content">
        <div class="modal-body">
	        <span class="hide" id="ajax_newscontent"></span>
        </div>
        <div class="modal-footer form-inline">
          <div class="pull-left">
          </div>
		  <span class="pull-left hide" id="ajax_newstime"></span>
		  <?php if($_SESSION['administrator']) echo '<a class="pull-left" href="admin.php?page=news">编辑</a>'?>
          <a href="#" class="btn" data-dismiss="modal">关闭</a>
        </div>
      </form>
    </div>
	<canvas id="canvas" style="position:fixed;top:0;z-index:-999"></canvas>
    <script type="text/javascript">
      <?php
        echo 'var ws_url="ws://',$_SERVER["SERVER_ADDR"],':6844/";';
        if(isset($_SESSION['user']))
          echo 'var userid="',encode_user_id('id-'.$_SESSION['user']),'";';
      ?>
    </script>
    <script src="../assets/js/jquery.js"></script>
    <script src="../assets/js/bootstrap.min.js"></script>
    <script src="../assets/js/common.js"></script>
    <script src="../assets/js/chat.js"></script>
    <script type="text/javascript"> 
	  function click_news(newsid){
		  if(newsid){
            $.ajax({
              type:"POST",
              url:"ajax_getnews.php",
              data:{"newsid":newsid},
              success:function(msg){
				  var arr=msg.split("FuckZK1");
				  var title=arr[0];
				  var content=arr[1];
				  var arr=content.split("fUCKzk2");
				  var content=arr[0];
				  var time=arr[1];
				  if(!content) content='本条新闻内容为空...';
				  $('#ajax_newstitle').html(title).show();
				  $('#ajax_newscontent').html(content).show();
				  $('#ajax_newstime').html('发布时间：'+time+'&nbsp;&nbsp;').show();
                  $('#NewsModal').modal('show');
                }
              });
            };
        };
      $(document).ready(function(){
        $('#ret_url').val("index.php");
        var originColor = '#E3E3E3';
        $('#newspad #title').click(function(){
            $('#newspad #mainarea').slideToggle();
            $('#title i').toggleClass('icon-double-angle-down');
            $('#title i').toggleClass('icon-double-angle-up');
            /* change color, unnecessary in this theme
            var tmp = $('#newspad').css('background-color');
            $('#newspad').css('background-color', originColor);
            originColor = tmp;
             */
        });
      });
</script>
</body>
</html>
