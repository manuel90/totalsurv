<?php defined('_JEXEC') or die('Restricted access');

if(!defined('DS')){
    define('DS',DIRECTORY_SEPARATOR);
}
define('URL_HOME',JUri::root().'index.php?option=com_totalsurv');
define('URL_HOME_ADMIN',JUri::root().'administrator/index.php?option=com_totalsurv');
define('URL_FOLDER_ADMIN',JUri::root().'administrator/components/com_totalsurv');

define('KENDOUI_STYLE','uniform');

class TotalSurvCustomFunctions {
    
    static function parse_args($data,$default) {
        if(is_object($data)) {
            $data = get_object_vars($data);
        }
        return array_merge($default,$data);
    }

    static function load() {

        $document = JFactory::getDocument();

        $document->addStyleSheet(URL_FOLDER_ADMIN.'/libraries/com_totalsurv.css');



        /**
         * Load jQuery
         **/
        $document->addScript(URL_FOLDER_ADMIN.'/libraries/kendoui/js/jquery.min.js');

        /**
         * Load Kendo
         **/
        $document->addStyleSheet(URL_FOLDER_ADMIN.'/libraries/kendoui/styles/kendo.common.min.css');
        $document->addStyleSheet(URL_FOLDER_ADMIN.'/libraries/kendoui/styles/kendo.default.min.css');
        $document->addStyleSheet(URL_FOLDER_ADMIN.'/libraries/kendoui/styles/kendo.'.KENDOUI_STYLE.'.min.css');

        $document->addScript(URL_FOLDER_ADMIN.'/libraries/kendoui/js/kendo.web.min.js');
        $document->addScript(URL_FOLDER_ADMIN.'/libraries/kendoui/js/cultures/kendo.culture.es-ES.min.js');
        $document->addScriptDeclaration('kendo.culture("es-ES");');
    
    }

    /**
     * Table Question
     *****/
    public static function getNameTableQuestions() {
        return '#__totalsurv_questions';
    }
    public static function getColumnsTableQuestions($implode = false,$prefix = '') {

        $columns = array(
            $prefix.'id' => null,
            $prefix.'name' => '',
            $prefix.'published' => 0,
            $prefix.'format' => null,
            $prefix.'ordered' => 0
        );
        return $implode ? implode(',',array_keys($columns)) : $columns;
    }
    public function getColumnsGridQuestion($json = false,$prefix = '') {

        $columns = array(
            array('field' => $prefix.'id', 'title' => JText::_('VIEW_FORMAT_LABEL_COLUMN_ID'),'filterable' => false, 'width' => '50px'),
            array('field' => $prefix.'name', 'title' => JText::_('VIEW_FORMAT_LABEL_COLUMN_NAME'), 'width' => '250px'),
            array('field' => $prefix.'published', 'title' => JText::_('VIEW_FORMAT_LABEL_COLUMN_PUBLISHED'), 'filterable' => false, 'width' => '60px'),
            array('field' => $prefix.'ordered', 'title' => JText::_('VIEW_FORMAT_LABEL_COLUMN_ORDERED'), 'filterable' => false, 'width' => '50px', 'format' => '')
        );
        return $json ? substr(json_encode($columns), 1,-1) : $columns;
    }
    /**
     * END Table Question
     **************************************************************************************/
    
}

?>