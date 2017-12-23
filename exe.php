<?php
session_start();
require "logger.php";
?>
<!doctype html>
<html>
	<head>
		<meta http-equiv="Content-type" content="text/html; charset=utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=Edge">
		<title>Готель</title>
		<link rel="shortcut icon" href="images/rad.ico" type="image/x-icon">
		<link rel="stylesheet" href="css/styles.css" type="text/css">
		<link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Oswald:400,300" type="text/css">
	</head>
	<header>
			<div class="admin">
				<input class="services" type="text" name="" value="Установка базы данных" disabled="disabled">
			</div>
	</header>
<body>
<div class="host">
<?

///Проверка файла подключения базы данных
if(is_file("connection6.php"))
{
	echo '<script type="text/javascript">alert("Cайт уже был установлен!");</script>';
	// echo '<script>location.replace("index.php");</script>';
	echo '<a href="index.php">Главная страница</a>';
	$log->write($log->list_error[11],$log->fLogPath,LOG_LEVEL_MAX);
}
else{
	
	if(isset($_POST['host']) && isset($_POST['user']))	
	{
		$_SESSION['host']=$_POST['host'];
		$_SESSION['user']=$_POST['user'];
		$_SESSION['password']=$_POST['password'];
		$log->write($log->list_error[12],$log->fLogPath,LOG_LEVEL_MIN);
	}
if(isset($_SESSION['host']) && isset($_SESSION['password']))
{
	$db=mysql_connect($_SESSION['host'],$_SESSION['user'],$_SESSION['password']) or $err="Не подключено к серверу";
	if(isset($err))
	{
		unset($_POST);
		$_SESSION=array();
		session_destroy();	
		$log->write($log->list_error[1],$log->fLogPath,LOG_LEVEL_MED);
		header("Location: exe.php");
		exit();
	}
	$log->write($log->list_error[13],$log->fLogPath,LOG_LEVEL_MAX);
	mysql_query("create database hotel");
	mysql_select_db("hotel") or die("Не подключено к серверу");;
	mysql_query("set names utf8");

	$file = 'hotel.sql';
	if (!file_exists($file));
	$open_file = fopen ($file, "r");
	$buf = fread($open_file, filesize($file));
	fclose ($open_file);

	$a = 0;
	$i=0;
	while ($b = strpos($buf,";",$a+1)){
	$i++;
	$a = substr($buf,$a+1,$b-$a);
	mysql_query($a);
	$a = $b;
	}
	$setting="<?php 
	\$db=mysql_connect('".$_SESSION['host']."','".$_SESSION['user']."','".$_SESSION['password']."') or die('Не подключено к серверу'); 
	mysql_select_db('hotel'); 
	mysql_query('set names utf8');
	session_start();
	?>";
	$fp = fopen("connection6.php", 'w');
	fwrite($fp,$setting);
	fclose($fp);
	$_SESSION=array();
	session_destroy();
	echo '<script type="text/javascript">alert("База данных успешно загружена!");</script>';
	// echo '<script>location.replace("index.php");</script>';
	echo '<a href="index.php">Главная страница</a>';
	exit();

}
else{
?>
<form method=POST>
	<title>Подключение</title>
    <p>
      <label for="host" style="padding-top: 40px;">Хост:</label>
      <input type="text" name="host" value=<?php echo @$_POST['host'];?> >
    </p>

	<p>
      <label for="user">Пользователь:</label>
      <input type="text" name="user" value=<?php echo @$_POST['user'];?> >
    </p>
	
    <p>
      <label for="pass">Пароль:</label>
      <input type="password" name="password" value=<?php echo @$_POST['password'];?> >
    </p>

    <p>
      <button type="submit" name=do_login >Соединиться</button>
    </p>
  </form>
 <?
 }
 ?> 
</div>
 <?
 }
 ?> 
</body>
</html>