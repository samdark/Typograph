Компонент для CakePHP
---------------------

УСТАНОВКА
— Скопировать в папку с приложением.
— Положить класс типографа в vendors/typographus.

ПРИМЕР
<?php
class TextsController extends AppController {
	var $name = 'Texts';
	
	//Подключаем компонент к контроллеру
	var $components = array('typographus');
		
	function index() {					
		$str = '«Типограф» - средство подготовки текстов к web-изданию. Форматирует текст для приведения его к более правильному с точки зрения типографики виду.';
		
		//Обрабатываем
		$str = $this->typographus->process($str);
		$this->set('text', $str);
	}
}