<html>
  <head lang=ru>
    <meta charset="utf-8">
    <link rel="stylesheet" href="style.css">
  </head>
 <body>

<?php
if (!empty($messages)) {
  print('<div id="messages">');
  // Выводим все сообщения.
  foreach ($messages as $message) {
    print($message);
  }
  print('</div>');
}

// Далее выводим форму отмечая элементы с ошибками классом error
// и задавая начальные значения элементов ранее сохраненными.
?>
  <div class="form" id=form>
      <h2><b>Форма</b></h2>  
      <form action="" method="POST">

        <label><b <?php if ($errors['username']) {print 'class="error"';} ?> >Имя</b><br /><input value="<?php print $values['username']; ?>" name="username" ></label><br />
        
        <label><b <?php if ($errors['email']) {print 'class="error"';} ?> >E-mail</b><br /><input value="<?php print $values['email']; ?>" name="email" type="email" ></label><br />
        
        <label><b <?php if ($errors['birthdate']) {print 'class="error"';} ?> >Дата рождения</b><br /><input value="<?php print $values['birthdate']; ?>" name="birthdate" type="text"></label><br />
        
        <b>Пол</b <?php if ($errors['sex']) {print 'class="error"';} ?> ><br />
          <label><input type="radio" name ="sex" value="s1" <?php if ($values['sex'] == 's1') {print 'checked="checked"';} ?> >Мужской</label><br />
          <label><input type="radio" name ="sex" value="s2" <?php if ($values['sex'] == 's2') {print 'checked="checked"';} ?>>Женский</label><br />
        
        <b <?php if ($errors['limbs']) {print 'class="error"';} ?> >Количество конечностей</b><br />
          <label><input type="radio" name ="limbs" value="l1"<?php if ($values['limbs'] == 'l1') {print 'checked="checked"';} ?>>Одна</label><br />
          <label><input type="radio" name ="limbs" value="l2"<?php if ($values['limbs'] == 'l2') {print 'checked="checked"';} ?>>Две</label><br />
          <label><input type="radio" name ="limbs" value="l3"<?php if ($values['limbs'] == 'l3') {print 'checked="checked"';} ?>>Три</label><br />
          <label><input type="radio" name ="limbs" value="l4"<?php if ($values['limbs'] == 'l4') {print 'checked="checked"';} ?>>Четыре</label><br />
          <label><input type="radio" name ="limbs" value="l5"<?php if ($values['limbs'] == 'l5') {print 'checked="checked"';} ?>>Более четырех</label><br />
          
        <b <?php if ($errors['superpower']) {print 'class="error"';} ?> >Сверхспособности</b><br />
          <label><input type="checkbox" name ="superpower1" value="sp1" <?php if ($values['superpower1'] != '') {print 'checked="checked"';} ?> >Бессмертие</label><br />
          <label><input type="checkbox" name ="superpower2" value="sp2"<?php if ($values['superpower2'] != '') {print 'checked="checked"';} ?> >Всезнание</label><br />
          <label><input type="checkbox" name ="superpower3" value="sp3"<?php if ($values['superpower3'] != '') {print 'checked="checked"';} ?> >Всемогущество</label><br />

        <label><b <?php if ($errors['biography']) {print 'class="error"';} ?> >Биография</b><br />
          <textarea name="biography" value="<?php print $values['biography']; ?>" ></textarea>
        </label><br />
        
        <label><input <?php if ($values['checkbox'] != '') {print 'checked="checked"';} ?>  name="checkbox" type="checkbox">
          <b <?php if ($errors['checkbox']) {print 'class="error"';} ?> >С контрактом ознакомлен(а)</b></label><br />
        
        <input class="submit" name="sendform" type="submit" value="Отправить"><br />

      </form>
      </div>
    </div>
  </body>
</html>