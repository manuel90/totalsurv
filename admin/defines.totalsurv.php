<?php defined('_JEXEC') or die('Restricted access');

if(!defined('DS')){
    define('DS',DIRECTORY_SEPARATOR);
}
define('URL_HOME','index.php?option=com_totalsurv');
define('URL_FOLDER_ADMIN',JUri::root().'administrator/components/com_totalsurv');


class TotalSurvCustomFunctions {
    
    static function parse_args($data,$default) {
        $new = $default;
        foreach($new as $key=>$item) {
            if(array_key_exists($key,$data)) {
                $new[$key] = $data[$key];
            }
        }
        return $new;
    }
    
}

?>