    function showError(container, errorMessage) {
      container.className = 'error';
      var msgElem = document.createElement('span');
      msgElem.className = "error-message";
      msgElem.innerHTML = errorMessage;
      container.appendChild(msgElem);
    }

    function resetError(container) {
      container.className = '';
      if (container.lastChild.className == "error-message") {
        container.removeChild(container.lastChild);
      }
    }

    function validate(form) {
      var elems = form.elements;

      resetError(elems.login.parentNode);
      if (!elems.login.value) {
        showError(elems.login.parentNode, ' Вы забыли логин.');
      }

      resetError(elems.password1.parentNode);
      if (!elems.password1.value) {
        showError(elems.password1.parentNode, ' Укажите пароль.');
      } else if (elems.password1.value != elems.password2.value) {
        showError(elems.password1.parentNode, ' Пароли не совпадают.');
      }


      resetError(elems.to.parentNode);
      if (!elems.to.value) {
        showError(elems.to.parentNode, ' Укажите, куда.');
      }

      resetError(elems.message.parentNode);
      if (!elems.message.value) {
        showError(elems.message.parentNode, ' Отсутствует текст.');
      }

    }

    function checkPassword(form) {
      var password = form.password.value; // Получаем пароль из формы
      var s_letters = "qwertyuiopasdfghjklzxcvbnm"; // Буквы в нижнем регистре
      var b_letters = "QWERTYUIOPLKJHGFDSAZXCVBNM"; // Буквы в верхнем регистре
      var digits = "0123456789"; // Цифры
      var specials = "!@#$%^&*()_-+=\|/.,:;[]{}"; // Спецсимволы
      var is_s = false; // Есть ли в пароле буквы в нижнем регистре
      var is_b = false; // Есть ли в пароле буквы в верхнем регистре
      var is_d = false; // Есть ли в пароле цифры
      var is_sp = false; // Есть ли в пароле спецсимволы
      for (var i = 0; i < password.length; i++) {
        /* Проверяем каждый символ пароля на принадлежность к тому или иному типу */
        if (!is_s && s_letters.indexOf(password[i]) != -1) is_s = true;
        else if (!is_b && b_letters.indexOf(password[i]) != -1) is_b = true;
        else if (!is_d && digits.indexOf(password[i]) != -1) is_d = true;
        else if (!is_sp && specials.indexOf(password[i]) != -1) is_sp = true;
      }
      var rating = 0;
      var text = "";
      if (is_s) rating++; // Если в пароле есть символы в нижнем регистре, то увеличиваем рейтинг сложности
      if (is_b) rating++; // Если в пароле есть символы в верхнем регистре, то увеличиваем рейтинг сложности
      if (is_d) rating++; // Если в пароле есть цифры, то увеличиваем рейтинг сложности
      if (is_sp) rating++; // Если в пароле есть спецсимволы, то увеличиваем рейтинг сложности
      /* Далее идёт анализ длины пароля и полученного рейтинга, и на основании этого готовится текстовое описание сложности пароля */
      if (password.length < 6 && rating < 3) text = "Простой";
      else if (password.length < 6 && rating >= 3) text = "Средний";
      else if (password.length >= 8 && rating < 3) text = "Средний";
      else if (password.length >= 8 && rating >= 3) text = "Сложный";
      else if (password.length >= 6 && rating == 1) text = "Простой";
      else if (password.length >= 6 && rating > 1 && rating < 4) text = "Средний";
      else if (password.length >= 6 && rating == 4) text = "Сложный";
      showError(elems.password1.parentNode, text);// Выводим итоговую сложность пароля
      return true; // Форму не отправляем
    }

    function opencaptcha(id1,id2){

    display1 = document.getElementById(id1).style.display;
    display2 = document.getElementById(id2).style.display;

    if(display1=='none'){
      document.getElementById(id1).style.display='block';
    }
    if(display2=='block'){
      document.getElementById(id2).style.display='none';
    }
}
    function openinfo(id1){

    display1 = document.getElementById(id1).style.display;

    if(display1=='none'){
      document.getElementById(id1).style.display='block';
    }
    if(display1=='block'){
      document.getElementById(id1).style.display='none';
    }
  }