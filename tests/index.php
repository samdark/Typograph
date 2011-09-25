<?php header('Content-type: text/html; charset=windows-1251'); ?>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=windows-1251">
        <title>Типограф - Тесты</title>
    </head>
    <body>
        <h1>Типограф - Тесты</h1>
        <h4>Дополнительные параметры: «all=1» для просмотра всех тестов, «show=1» для отображения пробелов.</h4>
<?php

ob_start();
require_once('../Typographus.php');

function typo($str){
	$typo = new Typographus();
	return $typo->process($str);
}

$_GET['all_errors'] = 0;
$_GET['all_tests'] = 0;

print preform_tests("typo", "_test.typo-dizzyman.dat");
print preform_tests("typo", "_test.typo-basic.dat");
print preform_tests("typo", "_test.typo-symbols.dat");
print preform_tests("typo", "_test.typo-html.dat");
//print preform_tests("typo", "_test.typo-phones.dat");
print preform_tests("typo", "_test.typo-quotes.dat");
print preform_tests("typo", "_test.typo-latest.dat");
print preform_tests("typo", "_test.fazeful.dat");
print preform_tests("typo", "_test.isaykin.dat");
print preform_tests("typo", "_test.dr_death.dat");

print '<hr><h2>Итого:</h2><b>Ошибок / Тестов:</b> '.$_GET['all_errors'].' / '.$_GET['all_tests'];

function show_entities($str){
	$entities = array(
		'&nbsp;' => '•'
	);
	
	if (isset($_GET['show']))
	  $str = str_replace(' ', '^', $str);
	
  return htmlspecialchars(str_replace(array_keys($entities), array_values($entities), $str));
}

function preform_tests($func, $test_file){		
	$rez = "\n<h2>$test_file"."</h2>\n<br>";
	$execute_test = true;
	$n_errors = 0;
	$n_tests  = 0;

	foreach (file($test_file) as $line_number => $str){
		$str = trim($str);
		$str = str_replace('<nobr>', '<span style="white-space:nowrap;">', $str);
		$str = str_replace('</nobr>', '</span>', $str);
		if ($str && !preg_match('~^#~', $str)){
			if ($execute_test){
				$in  = $str;
				$out = $func($in);
				$n_tests++;
				$_GET['all_tests']++;
			}
			else{
				$cfg = $str;
				if ($out != $cfg){
					$rez .= '<br><span style="color: #600; font-weight: bold">Ошибка в строке: '.++$line_number."</span>\n".'<br>';
					$rez .= 'IN: '.show_entities($in)."\n".'<br>';
				  $rez .= 'OUT: '.show_entities($out)."\n".'<br>';
				  $rez .= 'CFG: '.show_entities($cfg)."\n\n".'<br>';
                    
					$n_errors++;
					$_GET['all_errors']++;
				}
				elseif(isset($_GET['all'])){
          $rez .= "<br><span style=\"color: #060; font-weight: bold\">Все верно!</span><br>";
					$rez .= 'IN: '.show_entities($in)."\n".'<br>';
				  $rez .= 'OUT: '.show_entities($out)."\n".'<br>';
				  $rez .= 'CFG: '.show_entities($cfg)."\n\n".'<br>';

				}
			}
			$execute_test = !$execute_test;
		}
	}

	if (!$execute_test) $rez .= "Внимание! [$test_file] повреждён!\n".'<br>';
	$rez .= "<br><b>Ошибок / Тестов:</b> $n_errors / $n_tests\n".'<br>';

	return $rez;
}
	
?>
    </body>
</html>