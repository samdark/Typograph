<!doctype html>
<html>
<head>
    <meta charset="utf-8" />
    <title>Типограф - тесты</title>
    <style type="text/css">
        .input, .output, .expected {
            padding: .5em;
            font-family: monospace;
        }

        .input {
            background: #ccffcc;
        }

        .output {
            background: #ffffcc;
            font-weight: bold;
        }

        .expected {
            background: #ffcccc;
        }
    </style>
</head>
<body>
<?php
/**
 * Запуск тестов типографа
 * @author Alexander Makarov
 */

include 'typographus.php';

class TypographusTester {
    /**
     * @var Typographus  
     */
	private $typo;

    private $pass = 0;
    private $fail = 0;    

	function  __construct(Typographus $typographus) {
		$this->typo = $typographus;
	}

    /**
	 * Загружает XML-конфиг
	 * @param string $config
	 * @return SimpleXMLElement
	 */
	static function load_config($name){
		$filename = 'tests/'.$name.'.xml';
		$result = @simplexml_load_file($filename);
		if(!$result) {
			throw new Exception("Can't load test $filename.");
		}
		return $result;
	}

    /**
     * Запускает тесты
     * @param string $testName
     */
	function run($testName){
        $this->pass = 0;
        $this->fail = 0;

		$core_xml = self::load_config($testName);
		foreach ($core_xml->group as $group){
            echo '<h2>'.$group->description.'</h2>';

            foreach($group->test as $test){
                $out = $this->typo->process($test->input);

                if($out == $test->expected){
                    $this->pass++;
                }
                else {
                    $this->fail++;

                    echo '<h3>'.$test->name.'</h3>';
                    echo '<pre class="input">'.self::encode($test->input).'</pre>';
                    echo '<pre class="output">'.self::encode($out).'</pre>';
                    echo '<pre class="expected">'.self::encode($test->expected).'</pre>';
                }
            }
		}
        echo '<hr />Пройдено: '.$this->pass.'/'.($this->fail+$this->pass).'</br>';
	}

    static function encode($str){
        /*$str = strtr($str, array(
            '' => '',
        ));*/
        return htmlentities($str, null, 'utf-8');        
    }
}

$typo = new Typographus();
$tester = new TypographusTester($typo);

$tester->run('core');
$tester->run('russian');
?>
</body>
</html>