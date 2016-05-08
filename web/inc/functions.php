<?php
function get_ip(){
   if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
      return $_SERVER['HTTP_CLIENT_IP'];
    }
	else if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
      return $_SERVER['HTTP_X_FORWARDED_FOR'];
    }
  else {
      return $_SERVER['REMOTE_ADDR'];
	}
}

function resetpwd_mail(){
    require('inc/ojsettings.php');
    if(!isset($_SESSION['resetpwd_user']) || !isset($_SESSION['resetpwd_email']) || !isset($_SESSION['resetpwd_code'])) return 'timeout';
    $user = $_SESSION['resetpwd_user'];
    $email = $_SESSION['resetpwd_email'];
    $code = $_SESSION['resetpwd_code'];
    $subject = "$oj_name 密码重置验证";
    $ip = get_ip();
    $nowtime = date("Y/m/d H:i:s");
    $content = "<div>亲爱的 $user ,<br><p>我们收到了您在{$oj_name}重置密码的请求并发送了验证码来确认您的身份。</p><b><p>请求时间: $nowtime (UTC+08:00)</p><p>IP地址: $ip</p><p>验证码: $code</p></b><p>如果您没有在{$oj_name}有过重置密码的请求，您只需忽略这封邮件并不要把验证码告诉任何人。<br>如有任何问题，请回复该邮件来与管理员取得联系。</p><br>谢谢！<p>$oj_copy</p></div>";
    return postmail($email,$subject,$content);
}

function postmail($to,$subject = '',$body = ''){
    //error_reporting(E_STRICT);
    date_default_timezone_set('Asia/Shanghai');
    require('inc/class.phpmailer.php');
    include('inc/class.smtp.php');
    $mail = new PHPMailer(); 
    $mail->CharSet ="UTF-8";
    $mail->Encoding ="base64";
    $mail->IsSMTP();
    //$mail->SMTPDebug  = 0;                     // 2 - DISABLE
    $mail->SMTPAuth   = true;               
    $mail->SMTPSecure = "ssl";         
    $mail->Host       = 'YOURSMTPSERVER';      //SMTP Server Address
    $mail->Port       = 999;     //SMTP Service Port             
    $mail->Username   = 'YOUREMAIL';  //Input your admin email
    $mail->Password   = 'YOURPASSWORD';  //Input your email password.     
    $mail->SetFrom('YOUREMAIL', 'CWOJ');
    $mail->AddReplyTo('YOUREMAIL','CWOJ');
    $mail->Subject    = $subject;
	$mail->WordWrap = 60;
    //$mail->AltBody    = 'To view the message, please use an HTML compatible email viewer!'; // optional, comment out and test
    $mail->MsgHTML($body);
    $address = $to;
    $mail->AddAddress($address, '');
    $mail->IsHTML(true); 
    if(!$mail->Send()) {
        return '发送邮件失败: ' . $mail->ErrorInfo;
    } else {
        return 'success';
    }
}