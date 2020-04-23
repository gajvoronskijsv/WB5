<?php

/**
 * Файл login.php для не авторизованного пользователя выводит форму логина.
 * При отправке формы проверяет логин/пароль и создает сессию,
 * записывает в нее логин и id пользователя.
 * После авторизации пользователь перенаправляется на главную страницу
 * для изменения ранее введенных данных.
 **/

// Отправляем браузеру правильную кодировку,
// файл login.php должен быть в кодировке UTF-8 без BOM.
header('Content-Type: text/html; charset=UTF-8');

// Начинаем сессию.
session_start();

// В суперглобальном массиве $_SESSION хранятся переменные сессии.
// Будем сохранять туда логин после успешной авторизации.
if (!empty($_SESSION['login'])) {
  // Если есть логин в сессии, то пользователь уже авторизован.
  // TODO: Сделать выход (окончание сессии вызовом session_destroy()
  //при нажатии на кнопку Выход).
  // Делаем перенаправление на форму.
  header('Location: ./');
}
$login_messages = array();
// В суперглобальном массиве $_SERVER PHP сохраняет некторые заголовки запроса HTTP
// и другие сведения о клиненте и сервере, например метод текущего запроса $_SERVER['REQUEST_METHOD'].
if ($_SERVER['REQUEST_METHOD'] == 'GET') 
{
	if (!empty($login_messages)) {
	  print('<div id="messages">');
	  // Выводим все сообщения.
	  foreach ($login_messages as $message) {
	    print($message);
	  }
	  print('</div>');
	}
	?>
	
	<form action="" method="post">
	  <input name="login" />
	  <input name="pass" />
	  <input type="submit" value="Войти" />
	</form>

	<?php
}
// Иначе, если запрос был методом POST, т.е. нужно сделать авторизацию с записью логина в сессию.
else {
$login_messages[] = 'post works';
  // TODO: Проверть есть ли такой логин и пароль в базе данных.
  // Выдать сообщение об ошибках.
       
  $db = new PDO('mysql:host=localhost;dbname=u20296', 'u20296', '1377191');
    try {
    	$login_messages[] = 'connected';
    	$db->query("SELECT * FROM `DBlab5` where login='".$_POST['login']."' AND pass='".$_POST['pass']."'");
	}
	catch(PDOException $e){
  	}
  if ($row) {
  	$login_messages[] = 'rownotempty';
    // Если все ок, то авторизуем пользователя.
    $_SESSION['login'] = $_POST['login'];
    // Записываем ID пользователя.
    $_SESSION['uid'] = $_POST['login'];
    // Делаем перенаправление..
    header('Location: login.php');
  }
  else 
  {
  	$login_messages[] = 'rowisempty';
  	header('Location: login.php'); 
  }
}
