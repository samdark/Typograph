<?php
/*
* Smarty plugin
* -------------------------------------------------------------
* Файл:    outputfilter.typograph.php
* Тип:     outputfilter
* Имя:     typograph
* Назначение:  Отформатировать весь выходной текст типографом.
* 
* Установка: Закинуть в папку с плангинам Smarty
* Автор: Sam
* Сайт:  http://rmcreative.ru/
* -------------------------------------------------------------
*/

require_once('typographus.php');

function smarty_outputfilter_typograph($output, &$smarty){
     $typo = new Typographus();
    return $typo->process($output);
}