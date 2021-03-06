$(document).ready(function() { // запускаем скрипт после загрузки всех элементов
	/* засунем сразу все элементы в переменные, чтобы скрипту не приходилось их каждый раз искать при кликах */
	var overlay = $('#overlay'); // подложка, должна быть одна на странице
	var open_cat = $('.open_cat'); // все ссылки, которые будут открывать окна
	var close = $('.cat_close, #overlay'); // все, что закрывает модальное окно, т.е. крестик и оверлэй-подложка
	var cat = $('.cat_div'); // все скрытые модальные окна

	open_cat.click( function(event){ // ловим клик по ссылке с классом open_modal
	event.preventDefault(); // вырубаем стандартное поведение
	var div = $(this).attr('href'); // возьмем строку с селектором у кликнутой ссылки
	overlay.fadeIn(400, //показываем оверлэй
		function(){ // после окончания показывания оверлэя
			$(div) // берем строку с селектором и делаем из нее jquery объект
			.css('display', 'block') 
			.animate({opacity: 1, top: '50%'}, 200); // плавно показываем
		});
	});

		close.click( function(){ // ловим клик по крестику или оверлэю
		cat // все модальные окна
		.animate({opacity: 0, top: '45%'}, 200, // плавно прячем
		function(){ // после этого
			$(this).css('display', 'none');
			overlay.fadeOut(400); // прячем подложку
		});
	});
});

