//fckplugin.js
/*
* Типограф. Использует класс типографа с сайта http://rmcreative.ru/article/programming/typograph.
* Папку с плагином положить в FCK и подключить в конфиге
*в fckeditor.config.js добавить:
* FCKConfig.Plugins.Add( 'typograf2' ) ;
*
* и в нужнный тулбар добавить (например "DrupalFull"):
* ['typograf2'],
*
* @author: Igor V.Hudorozhrov , Click1.ru  (http://Click1.ru),typo@click1.ru
*/
var InsertVariableCommand=function(){
//create our own command, we dont want to use the FCKDialogCommand because it uses the default fck layout and not our own
};
InsertVariableCommand.GetState=function() {
return FCK_TRISTATE_OFF; //we dont want the button to be toggled
}
InsertVariableCommand.Execute=function() {
var _name = document.getElementById("nameDiv");
var _text = base64_encode(FCK.GetHTML());
var _path = base64_encode(FCKConfig.PluginsPath + 'typograf2');

var params = {name:_name,title:"user preview",text:_text,plpath:_path};

var previewPopup = Form2Popup(params,FCKConfig.PluginsPath + 'typograf2/typograf2.php', 'preview', 'top=100,left=100,scrollbars=1');
}
FCKCommands.RegisterCommand('typograf2', InsertVariableCommand ); //otherwise our command will not be found
var oInsertVariables = new FCKToolbarButton('typograf2', 'TYPORAF_offline');
oInsertVariables.IconPath = FCKConfig.PluginsPath + 'typograf2/typograf2.gif'; //specifies the image used in the toolbar
FCKToolbarItems.RegisterItem( 'typograf2', oInsertVariables );


function utf8_encode ( str_data ) {    // Encodes an ISO-8859-1 string to UTF-8
    // 
    // +   original by: Webtoolkit.info (http://www.webtoolkit.info/)
 
    str_data = str_data.replace(/\r\n/g,"\n");
    var utftext = "";
 
    for (var n = 0; n < str_data.length; n++) {
        var c = str_data.charCodeAt(n);
        if (c < 128) {
            utftext += String.fromCharCode(c);
        } else if((c > 127) && (c < 2048)) {
            utftext += String.fromCharCode((c >> 6) | 192);
            utftext += String.fromCharCode((c & 63) | 128);
        } else {
            utftext += String.fromCharCode((c >> 12) | 224);
            utftext += String.fromCharCode(((c >> 6) & 63) | 128);
            utftext += String.fromCharCode((c & 63) | 128);
        }
    }
 
    return utftext;
}



function base64_encode( data ) {

   var b64 = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/=";
    var o1, o2, o3, h1, h2, h3, h4, bits, i = ac = 0, enc="", tmp_arr = [];
    data = utf8_encode(data);
    
    do { // pack three octets into four hexets
        o1 = data.charCodeAt(i++);
        o2 = data.charCodeAt(i++);
        o3 = data.charCodeAt(i++);
 
        bits = o1<<16 | o2<<8 | o3;
 
        h1 = bits>>18 & 0x3f;
        h2 = bits>>12 & 0x3f;
        h3 = bits>>6 & 0x3f;
        h4 = bits & 0x3f;
 
        // use hexets to index into b64, and append result to encoded string
        tmp_arr[ac++] = b64.charAt(h1) + b64.charAt(h2) + b64.charAt(h3) + b64.charAt(h4);
    } while (i < data.length);
    
    enc = tmp_arr.join('');
    
    switch( data.length % 3 ){
        case 1:
            enc = enc.slice(0, -2) + '==';
        break;
        case 2:
            enc = enc.slice(0, -1) + '=';
        break;
    }
 
    return enc;
}

function Form2Popup(params, actionUrl, name, popupConfig, get) { 
        var method = (get == undefined || !get) ? 'POST' : 'GET'; 
        
        if (name == undefined || name == '') { 
                name = 'tmpPopup'; 
        } 
        var form = document.createElement('<form action="' + actionUrl + '" method="' + method + '" target="' + name + '" style="display:none;"></form>'); 
        var element = null; 
        for (var propName in params) { 
                element = document.createElement('<input type="text" name="' + propName + '" value="' + params[propName] + '">'); 
                form.appendChild(element); 
        } 
        document.body.appendChild(form);

        var win = window.open('about:blank', name, popupConfig); 

        win.focus(); 
        form.submit();
        form.removeNode(true); 
        return win; 
}
