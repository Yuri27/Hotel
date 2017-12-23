<?php
	require "connection.php";
if(isset($_POST['login-btn'])){
	if (isset($_POST['login'])){ 
	$login = $_POST['login'];
        if ($login == ''){ 
            unset($login);
        }
    } 

    if (isset($_POST['password'])){
        $password=$_POST['password']; 
        if ($password ==''){
            unset($password);
        } 
    }
       
if (empty($login) or empty($password)) 
    {
    exit ("Вы ввели не всю информацию, вернитесь назад и заполните все поля!");
    }
    //если логин и пароль введены,то обрабатываем их, чтобы теги и скрипты не работали, мало ли что люди могут ввести
    $login = stripslashes($login);
    $login = htmlspecialchars($login);
    $password = stripslashes($password);
    $password = htmlspecialchars($password);

    //удаляем лишние пробелы
    $login = trim($login);
    $password = trim($password);

    $ip=getenv("HTTP_X_FORWARDED_FOR");
    if (empty($ip) || $ip=='unknown'){
        $ip=getenv("REMOTE_ADDR");
    }//извлекаем ip          
    echo $ip;
    mysql_query ("DELETE FROM error_user WHERE UNIX_TIMESTAMP() - UNIX_TIMESTAMP(date) > 900");//удаляем ip-адреса ошибавшихся при входе пользователей через 15 минут.           
    $result = mysql_query("SELECT col FROM error_user WHERE ip='$ip'");// извлекаем из базы количество неудачных попыток входа за    последние 15 у пользователя с данным ip 
    $myrow = mysql_fetch_array($result);
    if ($myrow['col'] > 2) {
        //если ошибок больше двух, т.е три, то выдаем сообщение.
        exit("Вы набрали логин или пароль неверно 3 раз. Подождите    15 минут до следующей попытки.");
    }          
    $password = md5($password);//шифруем пароль
    $password = strrev($password);// для надежности добавим реверс
    $password = $password."b3p6f";    
 

    $result = mysql_query("SELECT * FROM users WHERE login='$login' AND password='$password'"); //извлекаем из базы все данные о пользователе с    введенным логином и паролем
    $myrow = mysql_fetch_array($result);

    if (empty($myrow['id'])){
            //если пользователя с введенным логином и паролем не    существует
            //Делаем запись о том, что данный ip не смог войти.          
    $select = mysql_query ("SELECT ip FROM error_user WHERE ip='$ip'");
    $tmp = mysql_fetch_row ($select);
        if ($ip == $tmp[0]) {//проверяем, есть ли пользователь в таблице "error_user" 
            $result52 = mysql_query("SELECT col FROM error_user WHERE ip='$ip'");
            $myrow52 = mysql_fetch_array($result52);          
            $col = $myrow52[0] + 1;//прибавляем    еще одну попытку неудачного входа 
            mysql_query ("UPDATE error_user SET col=$col,date=NOW() WHERE ip='$ip'");
        }          
        else {
            mysql_query ("INSERT INTO error_user (ip,date,col) VALUES ('$ip',NOW(),'1')");
            //если за последние 15 минут ошибок не было, то вставляем    новую запись в таблицу "error_user"
        }          
        exit ("Извините, введённый вами логин или пароль неверный.");
    }
    if($myrow['status']=='N'){
        echo '<script type="text/javascript">alert("Извините, Вы заблокированы!");</script>';
    }
    else {          
     //если пароли    совпадают, то запускаем пользователю сессию! Можете его поздравить, он вошел!
        $_SESSION['password']=$myrow['password']; 
        $_SESSION['login']=$myrow['login']; 

        $_SESSION['id']=$myrow['id'];//эти    данные очень часто используются, вот их и будет "носить с собой"    вошедший пользователь
                     
                //Далее мы запоминаем данные в куки, для последующего входа.
                //ВНИМАНИЕ!!! ДЕЛАЙТЕ ЭТО НА ВАШЕ УСМОТРЕНИЕ, ТАК КАК ДАННЫЕ ХРАНЯТСЯ    В КУКАХ БЕЗ ШИФРОВКИ
        if ($_POST['save'] == 1) {
        //Если пользователь хочет, чтобы его данные сохранились для    последующего входа, то сохраняем в куках его браузера
            setcookie("login", $_POST["login"], time()+9999999);
            setcookie("password", $_POST["password"], time()+9999999);
        }
    }  
    echo '<script>location.replace("index.php");</script>';                
    // echo "<html><head><meta    http-equiv='Refresh' content='0;    URL=index.php'></head></html>";//перенаправляем пользователя на главную страничку, там    ему и сообщим об удачном входе     

    }     
?>
