<?php 
require 'inc/ojsettings.php';
require('inc/checklogin.php');
if(!isset($_SESSION['user'],$_SESSION['administrator']))
  $info = 'You are not administrator';
require 'inc/problem_flags.php';
$level_max=(PROB_LEVEL_MASK>>PROB_LEVEL_SHIFT);
$inTitle='新建题目';
$Title=$inTitle .' - '. $oj_name;
?>
<!DOCTYPE html>
<html>
  <?php require('head.php'); ?>

  <body>
    <?php require('page_header.php'); ?>
    <div class="container-fluid edit-page">
      <?php
      if(isset($info))
        echo "<div class=\"center\">$info</div>";
      else{
      ?>
	  <div class="hide" id="showtools">
	    <p><button class="btn btn_primary" id="btn_show">显示工具栏 >></button></p>
	  </div>
      <form action="editproblem.php" method="post" id="edit_form" style="padding-top:10px">
        <input type="hidden" name="op" value="add">
        <div class="row-fluid">
          <div class="span9">
            <p><span>题目标题: </span><textarea class="span8" name="title" rows="1"></textarea></p>
          </div>
        </div>
        <div class="row-fluid">
          <div class="span5">
            <p><span>时间限制: </span><input id="input_time" name="time" class="input-mini" type="text" value="1000"><span> ms</span></p>
          </div>
        </div>
        <div class="row-fluid">
          <div class="span5">
            <p><span>内存限制: </span><input id="input_memory" name="memory" class="input-mini" type="text" value="65536"><span> KB</span></p>
          </div>
        </div>
        <div class="row-fluid">
          <div class="span12">
            <p><span>评测方式: </span>
              <select name="compare" id="input_cmp" style="width:auto">
                <option value="tra">Traditional</option>
                <option value="int">Integer</option>
                <option value="float">Real Number</option>
                <option value="spj">Special Judge</option>
              </select>
              <select name="precision" class="hide input-mini" id="input_cmp_pre"></select>
              <span id="input_cmp_help" class="help-inline"></span>
            </p>
          </div>
        </div>
        <div class="row-fluid">
          <div class="span5">
            <p><span>每点分值: </span><input id="input_score" name="score" class="input-mini" type="text" value="10"></p>
          </div>
        </div>      
        <div class="row-fluid">
          <div class="span5">
            <span>题目选项: </span>
            <ul>
              <li>
                <span>开放的源代码可以被哪些人查看: </span>
                <select name="option_open_source" id="option_open_source" style="width:auto">
                  <option value="0">所有人</option>
                  <option value="1">AC了的人</option>
                  <option value="2">没有人</option>
                </select>
              </li>
              <li>
                <span>题目等级 </span>
                <select name="option_level" id="option_level" style="width:auto">
                  <option value="0">无难度</option>
                  <script>
                  for (var i = 1; i <= <?php echo $level_max?>; i++) {
                    document.write('<option value="'+i+'">'+i+'</option>')
                  };
                  </script>
                </select>
              </li>
              <li>
                <label class="checkbox" style="font-size: 16px;">
                  <input type="checkbox" name="hide_prob">隐藏题目
                </label>
              </li>
            </ul>
          </div>
        </div>
        <div class="row-fluid">
          <div class="span9">
            <p>
              题目描述:<br>
              <textarea class="span12" name="description" rows="13"></textarea>
            </p>
          </div>
        </div>       
        <div class="row-fluid">
          <div class="span9">
            <p>
              输入格式:<br>
              <textarea class="span12" name="input" rows="8"></textarea>
            </p>
          </div>
        </div>       
        <div class="row-fluid">
          <div class="span9">
            <p>
              输出格式:<br>
              <textarea class="span12" name="output" rows="8"></textarea>
            </p>
          </div>
        </div>
        <div class="row-fluid">
          <div class="span9">
            <p>
              输入样例:<br>
              <textarea class="span12" name="sample_input" rows="8"></textarea>
            </p>
          </div>
        </div>
        <div class="row-fluid">
          <div class="span9">
            <p>
              输出样例:<br>
              <textarea class="span12" name="sample_output" rows="8"></textarea>
            </p>
          </div>
        </div>
        <div class="row-fluid">
          <div class="span9">
            <p>
              题目提示:<br>
              <textarea class="span12" name="hint" rows="8"></textarea>
            </p>
          </div>
        </div>
        <div class="row-fluid">
          <div class="span9">
            <p>
              题目标签:<br>
              <textarea class="span12" name="source" rows="1"></textarea>
            </p>
          </div>
        </div>
        <div class="row-fluid">
          <div class="span9" style="text-align:center">
            <input type="submit" class="btn btn-primary" value="提交">
          </div>
        </div>
      </form>
      <?php } ?>
      <hr>
      <footer>
        <p>&copy; <?php echo"{$year} {$copyright}";?></p>
      </footer>
    </div>
    <div class="html-tools">
      <div class="well well-small margin-0" id="tools">
        <table class="table table-bordered table-condensed table-striped" style="width:100%">
          <caption><p>HTML代码工具</p></caption>
          <thead>
            <tr>
              <th>功能</th>
              <th>代码</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td><button class="btn btn-mini" id="tool_less">小于(&lt;)</button></td>
              <td>&amp;lt;</td>
            </tr>
            <tr>
              <td><button class="btn btn-mini" id="tool_greater">大于(&gt;)</button></td>
              <td>&amp;gt;</td>
            </tr>
            <tr>
              <td><button class="btn btn-mini" id="tool_img">图片</button></td>
              <td>&lt;img src=&quot;...&quot;&gt;</td>
            </tr>
            <tr>
              <td><button class="btn btn-mini" id="tool_sup">上标</button></td>
              <td>&lt;sup&gt;...&lt;/sup&gt;</td>
            </tr>
            <tr>
              <td><button class="btn btn-mini" id="tool_sub">下标</button></td>
              <td>&lt;sub&gt;...&lt;/sub&gt;</td>
            </tr>
            <tr>
              <td><button class="btn btn-mini" id="tool_samp">单间隔</button></td>
              <td>&lt;samp&gt;...&lt;/samp&gt;</td>
            </tr>
            <tr>
              <td><button class="btn btn-mini" id="tool_inline">公式</button></td>
              <td>[inline]...[/inline]</td>
            </tr>
            <tr>
              <td><button class="btn btn-mini" id="tool_tex">居中公式</button></td>
              <td>[tex]...[/tex]</td>
            </tr>
          </tbody>
        </table>
		  <div style="text-align:center;margin-top:10px">
            <button class="btn btn-info" id="btn_upload">上传图片...</button>
			<button class="btn btn-primary" id="btn_hide">隐藏工具栏 >></button>
          </div>
      </div>
    </div>

    <script src="../assets/js/jquery.js"></script>
    <script src="../assets/js/bootstrap.min.js"></script>
    <script src="../assets/js/common.js"></script>

    <script type="text/javascript"> 
      $(document).ready(function(){
        var loffset=window.screenLeft+200;
        var toffset=window.screenTop+200;
        $('#ret_url').val("newproblem.php");
        function show_help(way){
          if(way=='float'){
            $('#input_cmp_pre').show();
            $('#input_cmp_help').html('输出只能包含实数。请选择精度:');
          }else{
            $('#input_cmp_pre').hide();
            if(way=='tra')
              $('#input_cmp_help').html('标准的评判方式，忽略尾部空格。');
            else if(way=='int')
              $('#input_cmp_help').html('输出只能包含实整数。');
            else if(way=='spj')
              $('#input_cmp_help').html('请确保在测试数据文件夹里存在"spj.exe"(windows)或是"spj.cpp"(linux)。');
          }
        }
        (function(){
          var option='';
          for(var i=0;i<10;i++){
            option+='<option value="'+i+'">'+i+'</option>';
          }
          $('#input_cmp_pre').html(option);
          show_help($('#input_cmp').val());
        })();
        $('#input_cmp').change(function(E){show_help($(E.target).val());});
		$('#btn_hide').click(function(){
          $('#tools').hide();
		  $('#showtools').show();
        });
		$('#btn_show').click(function(){
          $('#tools').show();
		  $('#showtools').hide();
        });
        $('#btn_upload').click(function(){
          window.open("upload.php",'upload_win2','left='+loffset+',top='+toffset+',width=400,height=180,channelmode=yes,directories=no,toolbar=no,resizable=no,menubar=no,location=no');
        });
        $('#edit_form textarea').focus(function(e){cur=e.target;});
        $('#edit_form input').blur(function(e){
          e.target.value=$.trim(e.target.value);
          var o=$(e.target);
          if(!e.target.value||(/\D/.test(e.target.value)))
            o.addClass('error');
          else
            o.removeClass('error');
        });
        $('#edit_form').submit(function(){
          var str=$('#input_memory').val();
          if(!str||(/\D/.test(str))){
            window.location.hash='#edit_form';
            return false;
          }
          str=$('#input_time').val();
          if(!str||(/\D/.test(str))){
            window.location.hash='#edit_form';
            return false;
          }
          str=$('#input_score').val();
          if(!str||(/\D/.test(str))){
            window.location.hash='#edit_form';
            return false;
          }
          return true;
        });
        $('#tools').click(function(e){
          if(!($(e.target).is('button')))return false;
          if(typeof(cur)=='undefined')return false;
          var op=e.target.id;
          var slt=GetSelection(cur);
          if(op=="tool_greater")
            InsertString(cur,'&gt;');
          else if(op=="tool_less")
            InsertString(cur,'&lt;');
          else if(op=="tool_img"){
            var url=prompt("Please input image url.","");
            if(url){
              InsertString(cur,slt+'<img src="'+url+'">');
            }
          }else if(op=="tool_inline"||op=="tool_tex"){
            op=op.substr(5);
            InsertString(cur,'['+op+']'+slt+'[/'+op+']');
          }else{
            op=op.substr(5);
            InsertString(cur,'<'+op+'>'+slt+'</'+op+'>');
          }
          return false;
        });
      });
    </script>
  </body>
</html>