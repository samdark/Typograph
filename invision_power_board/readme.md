Типограф для IP.Board
-----------------------------------------------------------
 For IP.board 2.1.x, 2.2.x, (?)2.3.x
-----------------------------------------------------------
 (C) 2007-2008 Олег «Sannis» Ефимов, Алексей «Arhar» Баранов,
               Макаров Александр
-----------------------------------------------------------
 Авторы модуля типографики:
 (C) 2007-2008 Оранский Максим и Макаров Александр
 http://rmcreative.ru/article/programming/typograph/
-----------------------------------------------------------
 «Типограф» — средство подготовки текстов к web-изданию.
 Форматирует текст для приведения его к более правильному
 с точки зрения типографики виду.
-----------------------------------------------------------
 Для того чтобы введённый текст проверился Типографом,
 его необходимо будет заключить в теги [typo] [/typo].
-----------------------------------------------------------
 Объём работ:
-----------------------------------------------------------
 Файлы для изменения:
  - ./sources/classes/bbcode/class_bbcode_core.php
  - ./sources/classes/bbcode/class_bbcode.php
  - ./sources/classes/bbcode/class_bbcode_legacy.php


-----------------------------------------------------------
                         УСТАНОВКА
-----------------------------------------------------------
1. Поместить в папку ./typograph/ последнюю версию typographus.php.
2. Загрузить папку в ./sources/classes/bbcode/ на сервере форума.
3. Открыть файл ./sources/classes/bbcode/class_bbcode_core.php, найти:

	/*-------------------------------------------------------------------------*/
	// regex_code_tag: Builds this code tag HTML
	/*-------------------------------------------------------------------------*/

Добавить перед:

	/*-------------------------------------------------------------------------*/
	// (SnS) regex_typo_tag: Check typography in [typo] tags
	/*-------------------------------------------------------------------------*/
	
	/**
	* Check typography
	*
	* @author	Oleg «Sannis» Efimov
	* @author	Alex «Arhar» Baranov
	* @author   Макаров Александр
	* @param	string	Raw text
	* @return	string	Converted text
	*/
	function regex_typo_tag($matches=array()){
		$ver = substr(phpversion(), 0, 1);

		if( $ver == '5' ){
			if(!is_object($this->typo_class)){
				require_once(ROOT_PATH.'sources/classes/bbcode/typograph/typographus.php');
				$this->typo_class = new Typographus();
			}
			
			return $this->typo_class->process($matches[1]);
		}
		//PHP4 не поддерживается
		else return $matches[1];
	}


4. Открыть файл ./sources/classes/bbcode/class_bbcode.php, найти:


//-----------------------------------------
// Do [CODE] tag
//-----------------------------------------

$txt = preg_replace_callback( "#\[code\](.+?)\[/code\]#is", array( &$this, 'regex_code_tag' ), $txt );

Добавить перед:

//-----------------------------------------
// Do [typo] tag
//-----------------------------------------

$txt = preg_replace_callback( "#\[typo\](.+?)\[/typo\]#is", array( &$this, 'regex_typo_tag' ), $txt );

4. Открыть файл ./sources/classes/bbcode/class_bbcode_legacy.php, найти:

//-----------------------------------------
// Do [CODE] tag
//-----------------------------------------

$txt = preg_replace( "#\[code\](.+?)\[/code\]#ies", "\$this->regex_code_tag( '\\1' )", $txt );

Добавить перед:

//-----------------------------------------
// Do [typo] tag
//-----------------------------------------

$txt = preg_replace( "#\[typo\](.+?)\[/typo\]#ies", "\$this->regex_typo_tag( '\\1' )", $txt );