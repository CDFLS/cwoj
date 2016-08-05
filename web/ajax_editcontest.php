<?php
require 'inc/privilege.php';
require 'inc/problem_flags.php';

function JUDGE_TYPE($way)
{
	if($way=='cwoj')
      return 0;
    else if($way=='acm-like')
      return 1;
    else if($way=='oi-like')
      return 2;
}
session_start();
if(!check_priv(PRIV_PROBLEM))
	die('你没有权限...');
else if(!isset($_POST['op']))
	die('参数无效...');

require 'inc/database.php';

if($_POST['op']=='del'){
    if(!isset($_POST['contest_id']))
        die('题目不存在...');
    $id=intval($_POST['contest_id']);
    $result=mysqli_query($con,"select defunct from contest where contest_id=$id");
    if($row=mysqli_fetch_row($result)){
	if($row[0]=='N') $opr='Y';
    else $opr='N';
    if(mysqli_query($con,"update contest set defunct='$opr' where contest_id=$id"))
        echo 'success';
    else
        echo '系统错误...';
    }
}else{
isset($_POST['start_time'])&&!empty($_POST['start_time']) ? $start_time=mysqli_real_escape_string($con,$_POST['start_time']) : die('请输入时间...');
if($start_time<0) die('请输入有效时间...');
isset($_POST['end_time'])&&!empty($_POST['end_time']) ? $end_time=mysqli_real_escape_string($con,$_POST['end_time']) : die('请输入时间...');
if($end_time<0) die('请输入有效时间...');
if(strtotime($start_time)>strtotime($end_time)) die('开始时间不能大于结束时间...');
$judge_way=isset($_POST['judge']) ? JUDGE_TYPE($_POST['judge']) : 0;
isset($_POST['title'])&&!empty($_POST['title']) ? $title=mysqli_real_escape_string($con,$_POST['title']) : die('请输入标题...');
isset($_POST['problems'])&&!empty($_POST['problems']) ? $problems=mysqli_real_escape_string($con,$_POST['problems']) : die('请输入题目列表...');
$num=substr_count($problems,',')+1;
$prob_arr=explode(',',$problems);
$problems=serialize($prob_arr);
$des=isset($_POST['description']) ? mysqli_real_escape_string($con,$_POST['description']) : '';
$source=isset($_POST['source']) ? mysqli_real_escape_string($con,$_POST['source']) : '';


$has_tex=0;
if(isset($_POST['option_level'])){
	$l=intval($_POST['option_level']);
	$level_max=(PROB_LEVEL_MASK>>PROB_LEVEL_SHIFT);
	if($l>=0 && $l<=$level_max){
		$has_tex|=($l<<PROB_LEVEL_SHIFT);
	}
}

for($i=0;$i<$num;$i++){
  $r=mysqli_fetch_row(mysqli_query($con,'select has_tex from problem where problem_id='.$prob_arr[$i].' limit 1'));
  if(!$r)
    die('题目#'.$prob_arr[$i].'不存在...');
  if($r[0] & PROB_IS_HIDE && !isset($_POST['hide_cont']))
    die('题目#'.$prob_arr[$i].'为隐藏题目，需将比赛隐藏才可加入...');
}

if(isset($_POST['hide_cont'])){
	$has_tex|=PROB_IS_HIDE;
}
foreach ($_POST as $value) {
	if(strstr($value,'[tex]') || strstr($value,'[inline]')) {
		$has_tex|=PROB_HAS_TEX;
		//echo $value;
		break;
	}
}

if($_POST['op']=='edit'){
	if(!isset($_POST['contest_id']))
		die('参数无效...');
	$id=intval($_POST['contest_id']);

	$result=mysqli_query($con,"update contest set title='$title',start_time='$start_time',end_time='$end_time',problems='$problems',num='$num',description='$des',source='$source',has_tex=$has_tex,judge_way=$judge_way,ranked='N' where contest_id=$id");
	if(!$result)
		die('数据库操作失败...');
	else
		echo('success');
}else if($_POST['op']=='add'){
	$id=1000;
	$result=mysqli_query($con,'select max(contest_id) from contest');
	if(($row=mysqli_fetch_row($result)) && intval($row[0]))
		$id=intval($row[0])+1;
	$result=mysqli_query($con,"insert into contest (contest_id,title,start_time,end_time,description,problems,num,source,in_date,has_tex,judge_way,enroll_user) values ($id,'$title','$start_time','$end_time','$des','$problems','$num','$source',NOW(),$has_tex,$judge_way,0)");
	if(!$result)
		die("insert into contest (contest_id,title,start_time,end_time,description,problems,num,source,in_date,has_tex,judge_way,enroll_user) values ($id,'$title','$start_time','$end_time','$des','$problems','$num','$source',NOW(),$has_tex,$judge_way,0)");
	else
		echo('success');
}
}
?>