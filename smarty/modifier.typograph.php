<?php
/*
* Smarty plugin
* ------------------------------------------------------------
* Файл:     modifier.typograph.php
* Тип:      modifier
* Имя:      typograph
* Назначение:  Отформатировать текст в переменной типографом.
*
* Установка: Закинуть в папку с плангинам Smarty
* Автор: Sam
* Сайт:  http://rmcreative.ru/
* ------------------------------------------------------------
*/

require_once('typographus.php');

function smarty_modifier_typograph($str){
    $typo = new Typographus();
    return $typo->process($str);
}