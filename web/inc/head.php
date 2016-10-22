<head>
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<meta name="renderer" content="webkit">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="description" content="<?php echo $oj_name, _(' - An Open-source Online Judge designed for OI trainings, built for you to code your future.');?>">
	<?php header("Content-Type:text/html;charset=utf-8");?>
	<link rel="shortcut icon" href="/assets/res/favicon.ico" type="image/x-icon" />
	<link rel="apple-touch-icon" href="/assets/res/ojlogo_ios.png" />
	<title><?php echo $Title?></title>
	<?php 
		$hour = date('H',time());
		if($pref->night=='on') 
			$t_night='on';
		else if($pref->night=='off') 
			$t_night='off';
		else{
			if($hour>=$daystart && $hour<$nightstart)
				$t_night='off';
			else
				$t_night='on';
		}
		if($t_night=='on'){
			$loginimg='/assets/res/loginbg_dark.png';
			echo '<link href="/assets/css/bootstrap_slate.min.css" rel="stylesheet" type="text/css" />';
			echo '<link href="/assets/css/docs_dark.css?v='.$web_ver.'" rel="stylesheet" type="text/css" />';
		}else{
			$loginimg='/assets/res/loginbg.png';
			echo '<link href="/assets/css/bootstrap_cerulean.min.css" rel="stylesheet" type="text/css" />';
			echo '<link href="/assets/css/docs.css?v='.$web_ver.'" rel="stylesheet" type="text/css" />';
		}
	?>
	<link href="/assets/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
	<script src="/assets/js/jquery.min.js?v=310"></script>
	<script src="/assets/js/bootstrap.min.js?v=337"></script>
	<!--[if lt IE 9]>
		<script type="text/javascript">
			window.location = "fuckie.php"; 
		</script>
	<![endif]-->
	<!--[if lt IE 10]>
		<script src="/assets/js/html5.min.js"></script>
		<script src="/assets/js/respond.min.js"></script>
		<script src="/assets/js/jquery.placeholder.min.js"></script>
	<![endif]-->
</head>