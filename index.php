<?php if(!defined('IS_CMS')) die();


class Webcambild extends Plugin {


function getContent($value) {
    

    
$parameters = "width|height|url|refresh";

//Zugelassene Parameter parsen
preg_match_all("#($parameters)\s*=([\S]*)#",$value,$treffer);
//preg_match_all("#(?:\s)*($parameters)(?:\s)*=(?:\s)*([^\s]*)(?:\s)*#",$value,$treffer);

if (is_array($treffer[2])) $treffer_tmp = array_map('trimplus', $treffer[2]); 

//Geparste parameter und Werte in Array ablegen
if (is_array($treffer_tmp) && is_array($treffer[1])) $values = array_combine($treffer[1],$treffer_tmp); 

//Imagegröße ermitteln
if (isset($values['url'])) $groesse = @getimagesize("http://".$values['url']); 

// Fallback wenn Image nicht erreichbar
if (empty($groesse)) $this->settings->get("cam_offline");

//Wenn "height" nicht angegeben wurde, wird $values['height'] errechnet
if (empty($values['height'])) $values['height'] = ceil($values['width'] * ($groesse['1'] / $groesse['0']));

//Url zum refresher.php zusammenbasteln
$freshurl = 'plugins/Webcambild/refresher.php?refresh='.$values['refresh']."&width=".$values['width']."&url=".$values['url']; 

//Ausgabe zusammenbasteln
$back = '<iframe src="'.$freshurl.'" name="'.$values['url'].'" width="'.$values['width'].'" height="'.$values['height'].'"  scrolling="no" marginheight="0" marginwidth="0" frameborder="0">
Ihr Browser kann leider keine eingebetteten Frames anzeigen:<img src="'.$url.'" name="cam" width="'.$values['width'].'" height="'.$values['height'].'" border="0" alt="Bild">
</iframe>';


return $back;


    } // function getContent
    
 
    

function getConfig() {
        
        global $ADMIN_CONF;
        $language = $ADMIN_CONF->get("language");


        $config = array();
        

        
        $config['cam_offline']  = array(
            "type" => "text",                          
            "description" => "Alternativtext<br><span style='color:#aaa;font-weight:normal;font-size:small;' >Wenn das Camimage nicht erreichbar ist erscheint dieser Text</span>",     // Pflicht:  Beschreibung
            "maxlength" => "100",                     
            "size" => "50",                             
        );


        return $config;
        

} // function getConfig    
    

   
    
    
    
    function getInfo() {
        global $ADMIN_CONF;
        $language = $ADMIN_CONF->get("language");
        # nur eine Sprache ---------------------------------
        $info = array(
            // Plugin-Name + Version
            "<b>Webcambild</b>",
            // moziloCMS-Version
            "2.0",
            // Kurzbeschreibung 
            "Bietet eine einfache Möglichkeit, ein Webcambild einzubauen. Das Bild wird in ein iFrame eingebettet, so dass es sich zyklisch refresht",
            // Name des Autors
            "Bo",
            // Download-URL
            "http://www.mozilo.de/pluginarchiv/",
            // Platzhalter für die Selectbox in der Editieransicht 
            // - ist das Array leer, erscheint das Plugin nicht in der Selectbox
            array(
                '{Webcambild|
url=www.url_zum_cambild.de/camimage.jpg
width=200
refresh=30
}' => 'Kurzbeschreibung'
            )
        );
        // Rückgabe der Infos.
        // Auch hier könnte man die Inhalte natürlich von der aktuell im Admin eingestellten 
        // Sprache abhängig machen - siehe getConfig().
        return $info;
        
    } // function getInfo

} // class DEMOPLUGIN

    function trimplus ($v) {
    
   $v =  trim($v);
$v = str_replace("-html_br~", "", $v);
    
    return $v;
    
    } 

?>