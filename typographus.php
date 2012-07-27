<?php
mb_internal_encoding('UTF-8');

/**
 * Typographus
 * 
 * @version 3.0beta
 * @author Alexander Makarov
 * @author Maxim Oransky 
 *
 * @link http://rmcreative.ru/
 */
class Typographus {
    /**
     * @var TypographusProfile 
     */ 
	private $profile;

	function __construct($profile = "Russian") {
        $profileFile = 'profiles/'.$profile.'.php';
        if(!file_exists($profileFile)) throw new TypographusException("Can't find $profile Profile.");
        
        require $profileFile;
        
        $profileClass = $profile.'TypographusProfile';
		$this->profile = new $profileClass();
	}

    /**
     * Набор безопасных блоков по-умолчанию
     * @var array
     */
    protected $safe_blocks = array(
        '<pre[^>]*>' => '<\/pre>',
        '<style[^>]*>' => '<\/style>',
        '<script[^>]*>' => '<\/script>',
        '<!--' => '-->',
        '<code[^>]*>' => '<\/code>',
    );

   /**
    * Добавляет безопасный блок, который не будет обрабатываться типографом.
    *
    * @param String $openTag
    * @param String $closeTag
    */
    public function addSafeBlock($openTag, $closeTag){
        $this->safe_blocks[$openTag] = $closeTag;
    }

   /**
    * Убирает все безопасные блоки типографа.
    * Полезно, если необходимо задать полностью свой набор.
    */
    public function removeAllSafeBlocks(){
        $this->safe_blocks = array();
    }

  /**
   * Вызывает типограф, обходя html-блоки и безопасные блоки
   *
   * @param string $str
   * @return string
   */
  public function process($str){
    $str = $this->profile->normalize($str);

    $pattern = '(';
    foreach ($this->safe_blocks as $start => $end){
      $pattern .= "$start.*?$end|";
    }
    $pattern .= '<.*?>)';
    
    $str = preg_replace_callback("~$pattern~isu", array('self', '_stack'), $str);

    $str = $this->profile->process($str);

    $str = strtr($str, self::_stack());

    // выдераем дублирующиеся nowrap
    $str = preg_replace('/(\<(\/?span[^\>]*)\>)+/i', '$1',$str);
    
    return $str;
  }

  /**
   * Накапливает исходный код безопасных блоков при использовании в качестве
   * обратного вызова. При отдельном использовании возвращает накопленный
   * массив.
   *
   * @param array $matches
   * @return array
   */
  private static function _stack($matches = false){
    static $safe_blocks = array();
    if ($matches !== false){
      $key = '<'.count($safe_blocks).'>';
      $safe_blocks[$key] = $matches[0];
      return $key;
    }
    else{
      $tmp = $safe_blocks;
      unset($safe_blocks);
      return $tmp;
    }
  }


}

/**
 *  Профиль типографа
 */
abstract class TypographusProfile {
    /**
     *  Типографирование
     *
     * @param string $input
     * @return string
     *
     */
    abstract function process($input);

    /**
    * Приводим символы в строке к единой форме для последующей обработки
    *
    * @param string $str
    * @return string
    */
    function normalize($str){
        // Убираем неразрывные пробелы
        $str = preg_replace('~&nbsp;~u', ' ', $str);
        // Приводим кавычки к «"»
        $str = preg_replace('~(„|“|&quot;)~u', '"', $str);

        return html_entity_decode(trim($str), null, 'utf-8');
    }
}

class TypographusException extends Exception {}