<?php
/*
Plugin Name: TypographMachine
Plugin URI: http://rmcreative.ru/blog/post/tipograf
Description: "Типограф" - средство подготовки текстов к web-изданию. Форматирует текст для приведения его к более правильному с точки зрения типографики виду.
Version: 2.x.x (PHP5)
Author: Плагин: MAX, Типограф: Макаров Александр, Оранский Максим
Author URI: http://rmcreative.ru/

Положить в /wp-content/plugins/
Зайти в систему администрирования WordPress и на вкладке Плагины активировать плагин TypographMachine.
Проверено на WordPress версии 2.2. Работает.
*/

require_once 'typographus.php';
// Интерфейс плагина
if (isset($wp_version)) {
   // Удаляем переопределения фильтров Texturize, чтобы не было конфликта с TypographMachine
   remove_filter('category_description', 'wptexturize');
   remove_filter('list_cats', 'wptexturize');
   remove_filter('comment_author', 'wptexturize');
   remove_filter('comment_text', 'wptexturize');
   remove_filter('single_post_title', 'wptexturize');
   remove_filter('the_title', 'wptexturize');
   remove_filter('the_content', 'wptexturize');
   remove_filter('the_excerpt', 'wptexturize');

   // Переопределяем фильтры с приоритетом 10 (как и Texturize).
   // Сюда же можно добавить и другие необходимые переопределения
   //(фильтры WordPress – http://codex.wordpress.org/Plugin_API/Filter_Reference)
   add_filter('category_description', 'typographFilter', 10);
   add_filter('list_cats', 'typographFilter', 10);
   add_filter('comment_author', 'typographFilter', 10);
   add_filter('comment_text', 'typographFilter', 10);
   add_filter('single_post_title', 'typographFilter', 10);
   add_filter('the_title', 'typographFilter', 10);
   add_filter('the_content', 'typographFilter', 10);
   add_filter('the_excerpt', 'typographFilter', 10);
}

global $theTypograph;
$theTypograph = new Typographus('UTF-8');

// Фильтр "Типограф"
function typographFilter($text){
   global $theTypograph;
   return $theTypograph->process($text);
}