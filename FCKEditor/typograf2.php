<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" lang="ru-RU">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<script language="javascript">
<!--
var variable = null;
var FCK = window.opener.FCK;
function ok() {
if(variable != null) {
FCK.Focus();
var B = FCK.SetHTML(variable); //only works in IE
}
window.close();
}

function base64_decode( data ) {
 
 
    var b64 = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/=";
    var o1, o2, o3, h1, h2, h3, h4, bits, i = ac = 0, dec = "", tmp_arr = [];
 
    data += '';
 
    do {  // unpack four hexets into three octets using index points in b64
        h1 = b64.indexOf(data.charAt(i++));
        h2 = b64.indexOf(data.charAt(i++));
        h3 = b64.indexOf(data.charAt(i++));
        h4 = b64.indexOf(data.charAt(i++));
 
        bits = h1<<18 | h2<<12 | h3<<6 | h4;
 
        o1 = bits>>16 & 0xff;
        o2 = bits>>8 & 0xff;
        o3 = bits & 0xff;
 
        if (h3 == 64) {
            tmp_arr[ac++] = String.fromCharCode(o1);
        } else if (h4 == 64) {
            tmp_arr[ac++] = String.fromCharCode(o1, o2);
        } else {
            tmp_arr[ac++] = String.fromCharCode(o1, o2, o3);
        }
   } while (i < data.length);
 
    dec = tmp_arr.join('');
    dec = utf8_decode(dec);
 
    return dec;
}

function utf8_decode ( str_data ) {
    // http://kevin.vanzonneveld.net
    // +   original by: Webtoolkit.info (http://www.webtoolkit.info/)
    // +      input by: Aman Gupta
    // +   improved by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
    // +   improved by: Norman "zEh" Fuchs
    // +   bugfixed by: hitwork
    // +   bugfixed by: Onno Marsman
    // *     example 1: utf8_decode('Kevin van Zonneveld');
    // *     returns 1: 'Kevin van Zonneveld'
 
    var tmp_arr = [], i = ac = c1 = c2 = c3 = 0;
 
    str_data += '';
 
    while ( i < str_data.length ) {
        c1 = str_data.charCodeAt(i);
        if (c1 < 128) {
            tmp_arr[ac++] = String.fromCharCode(c1);
            i++;
        } else if ((c1 > 191) && (c1 < 224)) {
            c2 = str_data.charCodeAt(i+1);
            tmp_arr[ac++] = String.fromCharCode(((c1 & 31) << 6) | (c2 & 63));
            i += 2;
        } else {
            c2 = str_data.charCodeAt(i+1);
            c3 = str_data.charCodeAt(i+2);
            tmp_arr[ac++] = String.fromCharCode(((c1 & 15) << 12) | ((c2 & 63) << 6) | (c3 & 63));
            i += 3;
        }
    }
 
    return tmp_arr.join('');
}


//-->
</script>
</head>
<body>
<?php
$word = base64_decode($_POST['text']);
$typo_path = base64_decode($_POST['plpath']);
//require_once("$typo_path/typographus.php");
set_include_path(get_include_path() . PATH_SEPARATOR . dirname(__FILE__) . $typo_path);
require_once("typographus.php");
$typo = new typographus("UTF-8");

//$word = iconv("UTF-8", "WINDOWS-1251", $word);
$out_txt = $typo->process($word);
//$out_txt = iconv("WINDOWS-1251", "UTF-8",$out_txt);
 
?>
<script language="javascript">
variable = "<?php echo base64_encode($out_txt); ?>" ;
variable = base64_decode(variable);
</script>
<a href="#" onClick="variable; ok();">Вставить текст</a>
<hr />
<p><h2>До типографирования</h2></p>
<hr />
<div class="typo_do">
<?php echo base64_decode($_POST['text']);?>
</div>
<hr />
<p><h2>После типографирования</h2></p>
<hr />
<div class="typo_posle">
<?php echo $out_txt;?>
</div>
</body>
</html>

