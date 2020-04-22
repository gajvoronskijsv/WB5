<?php
/**
 * Реализовать проверку заполнения обязательных полей формы в предыдущей
 * с использованием Cookies, а также заполнение формы по умолчанию ранее
 * введенными значениями.
 */

// Отправляем браузеру правильную кодировку,
// файл index.php должен быть в кодировке UTF-8 без BOM.
header('Content-Type: text/html; charset=UTF-8');

// В суперглобальном массиве $_SERVER PHP сохраняет некторые заголовки запроса HTTP
// и другие сведения о клиненте и сервере, например метод текущего запроса $_SERVER['REQUEST_METHOD'].
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
  // Массив для временного хранения сообщений пользователю.
  $messages = array();

  // В суперглобальном массиве $_COOKIE PHP хранит все имена и значения куки текущего запроса.
  // Выдаем сообщение об успешном сохранении.
  if (!empty($_COOKIE['save'])) {
    // Удаляем куку, указывая время устаревания в прошлом.
    setcookie('save', '', 100000);
    // Если есть параметр save, то выводим сообщение пользователю.
    $messages[] = 'Спасибо, результаты сохранены.';
    // Если в куках есть пароль, то выводим сообщение.
    if (!empty($_COOKIE['pass'])) {
      $messages[] = sprintf('Вы можете <a href="login.php">войти</a> с логином <strong>%s</strong>
        и паролем <strong>%s</strong> для изменения данных.',
        strip_tags($_COOKIE['login']),
        strip_tags($_COOKIE['pass']));
    }
  }

  // Складываем признак ошибок в массив.
  $errors = array();
  
  $errors['username'] = !empty($_COOKIE['username_error']);
  $errors['email'] = !empty($_COOKIE['email_error']);
  $errors['birthdate'] = !empty($_COOKIE['birthdate_error']);
  $errors['sex'] = !empty($_COOKIE['sex_error']);
  $errors['limbs'] = !empty($_COOKIE['limbs_error']);
  $errors['superpower'] = !empty($_COOKIE['superpower_error']);
  $errors['biography'] = !empty($_COOKIE['biography_error']);
  $errors['checkbox'] = !empty($_COOKIE['checkbox_error']);

  // Выдаем сообщения об ошибках.
  if ($errors['username']) {
    // Удаляем куку, указывая время устаревания в прошлом.
    setcookie('username_error', '', 100000);
    // Выводим сообщение.
    $messages[] = '<div class="error">Заполните имя.</div>';
  }
  if ($errors['email']) {
    setcookie('email_error', '', 100000);
    $messages[] = '<div class="error">Адрес эл.почты указан неверно. Образец: exp@mail.ru</div>';
    }
   
    if ($errors['birthdate']) {
    setcookie('birthdate_error', '', 100000);
    $messages[] = '<div class="error">Дата рождения указана неверно. Образец: ДД.ММ.ГГГГ</div>';
    }
    
    if ($errors['sex']) {
    setcookie('sex_error', '', 100000);
    $messages[] = '<div class="error">Укажите пол.</div>';
    }
  
    if ($errors['limbs']) {
    setcookie('limbs_error', '', 100000);
    $messages[] = '<div class="error">Укажите число конечностей.</div>';
    }
  
    if ($errors['superpower']) {
    setcookie('superpower_error', '', 100000);
    $messages[] = '<div class="error">Укажите суперспособности.</div>';
    }
  
    if ($errors['biography']) {
    setcookie('biography_error', '', 100000);
    $messages[] = '<div class="error">Пожалуйста, заполните биографию!</div>';
    }

    if ($errors['checkbox']) {
    setcookie('checkbox_error', '', 100000);
    $messages[] = '<div class="error">Пожалуйста, ознакомьтесь с контрактом!</div>';
    }

  // Складываем предыдущие значения полей в массив, если есть.
  $values = array();
  
  $values['username'] = empty($_COOKIE['username_value']) ? '' :strip_tags($_COOKIE['username_value']);
  
  $values['email'] = empty($_COOKIE['email_value']) ? '' : strip_tags($_COOKIE['email_value']);
  
  $values['birthdate'] = empty($_COOKIE['birthdate_value']) ? '' : strip_tags($_COOKIE['birthdate_value']);
  
  $values['sex'] = empty($_COOKIE['sex_value']) ? '' : strip_tags($_COOKIE['sex_value']);
  
  $values['limbs'] = empty($_COOKIE['limbs_value']) ? '' : strip_tags($_COOKIE['limbs_value']);
  
  $values['superpower1'] = empty($_COOKIE['superpower1_value']) ? '' : strip_tags($_COOKIE['superpower1_value']);
  
  $values['superpower2'] = empty($_COOKIE['superpower2_value']) ? '' : strip_tags($_COOKIE['superpower2_value']);
  
  $values['superpower3'] = empty($_COOKIE['superpower3_value']) ? '' : strip_tags($_COOKIE['superpower3_value']);
  
  $values['biography'] = empty($_COOKIE['biography_value']) ? '' : strip_tags($_COOKIE['biography_value']);
  
  $values['checkbox'] = empty($_COOKIE['checkbox_value']) ? '' : strip_tags($_COOKIE['checkbox_value']);

  // Если нет предыдущих ошибок ввода, есть кука сессии, начали сессию и
  // ранее в сессию записан факт успешного логина.
  if (empty($errors) && !empty($_COOKIE[session_name()]) &&
      session_start() && !empty($_SESSION['login'])) {
    // TODO: загрузить данные пользователя из БД
    $host='localhost'; // имя хоста 
    $database='u20296'; // имя базы данных
    $user='u20296'; // имя пользователя
    $pswd='1377191'; // пароль
       
    $dbh = mysql_connect($host, $user, $pswd) or die("Не могу соединиться с MySQL.");
    mysql_select_db($database) or die("Не могу подключиться к базе.");
    $row = mysql_fetch_array(mysql_query("SELECT * FROM `DBlab5` where login='".$_SESSION['login']."'");
    $values['username'] =strip_tags($row['name']);
    $values['email'] = strip_tags($row['mail']);
    $values['birthdate'] = strip_tags($row['date']);
    $values['sex'] = strip_tags($row['gender']);
    $values['limbs'] = strip_tags($row['limb']);
    $values['superpower1'] =strip_tags($row['super1']);
    $values['superpower2'] = strip_tags($row['super2']);
    $values['superpower3'] = strip_tags($row['super3']);
    $values['biography'] = strip_tags($row['bio']);
    $values['checkbox'] = strip_tags($row['checkbox']);
    mysql_close();
  }
    // и заполнить переменную $values,
    // предварительно санитизовав.
    printf('Вход с логином %s, uid %d', $_SESSION['login'], $_SESSION['uid']);
  }


  // Включаем содержимое файла form.php.
  // В нем будут доступны переменные $messages, $errors и $values для вывода 
  // сообщений, полей с ранее заполненными данными и признаками ошибок.
  include('form.php');
}
// Иначе, если запрос был методом POST, т.е. нужно проверить данные и сохранить их в XML-файл.
else {
  // Проверяем ошибки.
  $errors = FALSE;
  if (empty($_POST['username'])) {
    // Выдаем куку на день с флажком об ошибке в поле fio.
    setcookie('username_error', '1', time() + 24 * 60 * 60);
    $errors = TRUE;
  }
  else {
    // Сохраняем ранее введенное в форму значение на год.
    setcookie('username_value', $_POST['username'], time() + 365 * 30 * 24 * 60 * 60);
  }

if (!preg_match("|^[-0-9a-z_\.]+@[-0-9a-z_^\.]+\.[a-z]{2,6}$|i", $_POST['email'])) {
      setcookie('email_error', '1', time() + 24 * 60 * 60);
      $errors = TRUE;
    }
    else {
      setcookie('email_value', $_POST['email'], time() + 365 * 30 * 24 * 60 * 60);
    }
    
    if (!preg_match('/^(\d{1,2})\.(\d{1,2})(?:\.(\d{4}))?$/', $_POST['birthdate'])) {
      setcookie('birthdate_error', '1', time() + 24 * 60 * 60);
      $errors = TRUE;
    }
    else {
      setcookie('birthdate_value', $_POST['birthdate'], time() + 365 * 30 * 24 * 60 * 60);
    }
    
    if (empty($_POST['sex'])) {
      setcookie('sex_error', '1', time() + 24 * 60 * 60);
      $errors = TRUE;
    }
    else {
      setcookie('sex_value', $_POST['sex'], time() + 365 * 30 * 24 * 60 * 60);
    }
    
    if (empty($_POST['limbs'])) {
      setcookie('limbs_error', '1', time() + 24 * 60 * 60);
      $errors = TRUE;
    }
    else {
      setcookie('limbs_value', $_POST['limbs'], time() + 365 * 30 * 24 * 60 * 60);
    }
    
    if (!isset($_POST['superpower1']) 
    && !isset($_POST['superpower2']) 
    && !isset($_POST['superpower3'])) {
      setcookie('superpower_error', '1', time() + 24 * 60 * 60);
      $errors = TRUE;
    }
    else {
      setcookie('superpower1_value', isset($_POST['superpower1']) ? $_POST['superpower1'] : '', time() + 365 * 30 * 24 * 60 * 60);
      setcookie('superpower2_value', isset($_POST['superpower2']) ? $_POST['superpower2'] : '', time() + 365 * 30 * 24 * 60 * 60);
      setcookie('superpower3_value', isset($_POST['superpower3']) ? $_POST['superpower3'] : '', time() + 365 * 30 * 24 * 60 * 60);
    }
    
    if (empty($_POST['biography'])) {
      setcookie('biography_error', '1', time() + 24 * 60 * 60);
      $errors = TRUE;
    }
    else {
      setcookie('biography_value', $_POST['biography'], time() + 365 * 30 * 24 * 60 * 60);
    }
    
    if (empty($_POST['checkbox'])) {
      setcookie('checkbox_error', '1', time() + 24 * 60 * 60);
      $errors = TRUE;
    }
    else {
      setcookie('checkbox_value', $_POST['checkbox'], time() + 365 * 30 * 24 * 60 * 60);
    }

  if ($errors) {
    // При наличии ошибок перезагружаем страницу и завершаем работу скрипта.
    header('Location: index.php');
    exit();
  }
  else {
    // Удаляем Cookies с признаками ошибок.
    setcookie('username_error', '', 100000);
    setcookie('email_error', '', 100000);
    setcookie('birthdate_error', '', 100000);
    setcookie('sex_error', '', 100000);
    setcookie('limbs_error', '', 100000);
    setcookie('superpower_error', '', 100000);
    setcookie('checkbox_error', '', 100000);
  }
  //Удаляю куки после успешного заполнения
  //setcookie('username_value', '', 100000);
  //setcookie('email_value', '', 100000);
  //setcookie('birthdate_value', '', 100000);
  //setcookie('sex_value', '', 100000);
  //setcookie('limbs_value', '', 100000);
  //setcookie('superpower1_value', '', 100000);
  //setcookie('superpower2_value', '', 100000);
  //setcookie('superpower3_value', '', 100000);
  //setcookie('checkbox_value', '', 100000);
  // Проверяем меняются ли ранее сохраненные данные или отправляются новые.
  if (!empty($_COOKIE[session_name()]) &&
      session_start() && !empty($_SESSION['login'])) {
    // TODO: перезаписать данные в БД новыми данными,
    // кроме логина и пароля.
    $dbh = mysql_connect($host, $user, $pswd) or die("Не могу соединиться с MySQL.");
    mysql_select_db($database) or die("Не могу подключиться к базе.");
    mysql_query("
        UPDATE DBlab5
        SET name = '".$_POST['username']."',
            mail = '".$_POST['email']."',
            date = '".$_POST['birthdate']."',
            gender = '".$_POST['sex']."',
            limb = '".$_POST['limbs']."',
            super1 = '".$_POST['superpower1']."',
            super2 = '".$_POST['superpower2']."',
            super3 = '".$_POST['superpower3']."',
            bio = '".$_POST['biography']."',
            checkbox = '".$_POST['checkbox']."'
        WHERE login='".$_SESSION['login']."';
      ");
    mysql_close();

  }
  else {
    // Генерируем уникальный логин и пароль.
    // TODO: сделать механизм генерации, например функциями rand(), uniquid(), md5(), substr().
    $login = '123';
    $pass = '123';
    // Сохраняем в Cookies.
    setcookie('login', $login);
    setcookie('pass', $pass);

    // TODO: Сохранение данных формы, логина и хеш md5() пароля в базу данных.
  $db = new PDO('mysql:host=localhost;dbname=u20296', u20296, 1377191);
  $name = $_POST['username'];
  $mail = $_POST['email'];
  $date = $_POST['birthdate'];
  $gender = $_POST['sex'];
  $limb = $_POST['limbs'];
  $super1 = $_POST['superpower1'];
  $super2 = $_POST['superpower2'];
  $super3 = $_POST['superpower3'];
  $bio = $_POST['biography'];
  $checkbox = $_POST['checkbox'];

  try {
    $stmt = $db->prepare("INSERT INTO DBlab5 (login, pass, name, mail, date, gender, limb, super1, super2, super3, bio, checkbox) VALUES (:login, :pass, :name, :mail,  :date, :gender, :limb, :super1, :super2, :super3, :bio, :checkbox)");
    $stmt->bindParam(':login', $login);
    $stmt->bindParam(':pass', $pass);
    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':mail', $mail);
    $stmt->bindParam(':date', $date);
    $stmt->bindParam(':gender', $gender);
    $stmt->bindParam(':limb', $limb);
    $stmt->bindParam(':super1', $super1);
    $stmt->bindParam(':super2', $super2);
    $stmt->bindParam(':super3', $super3);
    $stmt->bindParam(':bio', $bio);
    $stmt->bindParam(':checkbox', $checkbox);
    $stmt->execute();
  }
    catch(PDOException $e){
  }
  }
  // Сохраняем куку с признаком успешного сохранения.
  setcookie('save', '1');

  // Делаем перенаправление.
  header('Location: index.php');
  exit();
}
