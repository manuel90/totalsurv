<?php defined('_JEXEC') or die('Restricted access');

if(!defined('DS')){
    define('DS',DIRECTORY_SEPARATOR);
}
define('URL_HOME',JUri::root().'index.php?option=com_totalsurv');
define('URL_HOME_ADMIN',JUri::root().'administrator/index.php?option=com_totalsurv');
define('URL_FOLDER_ADMIN',JUri::root().'administrator/components/com_totalsurv');

define('KENDOUI_STYLE','uniform');

define('TYPE_OPTION_TEXT',  1);
define('TYPE_OPTION_DATE',  2);
define('TYPE_OPTION_LIST',  3);
define('TYPE_OPTION_CHECK', 4);
define('TYPE_OPTION_RADIO', 5);

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
        

        $crudServiceBaseUrl = URL_HOME_ADMIN;
        $vars_js = <<<JS
        kendo.culture("es-ES");
        var crudServiceBaseUrl = '$crudServiceBaseUrl';
JS;
        $document->addScriptDeclaration($vars_js);
    
    }

    /**
     * Table Format
     *****/
    public static function getNameTableFormat() {
        return '#__totalsurv_format';
    }
    public function getColumnsTableFormat($implode = false,$prefix = '') {

        $columns = array(
            $prefix.'id' => null,
            $prefix.'code' => null,
            $prefix.'version' => '',
            $prefix.'name' => '',
            $prefix.'commented' => 0,
            $prefix.'published' => 0,
            $prefix.'min_value' => 1,
            $prefix.'max_value' => 5,
            $prefix.'date_create' => '00-00-0000',
            $prefix.'text_info_value' => 0,
            $prefix.'enable_send_info' => 0,
            $prefix.'range_low' => 0,
            $prefix.'range_medium' => 0,
            $prefix.'range_high' => 0,
            $prefix.'range_very_high' => 0,
            $prefix.'ordered' => 0
        );
        return $implode ? implode(',',array_keys($columns)) : $columns;
    }

    public function getColumnsGridFormat($json = false,$prefix = '') {

        $columns = array(
            array('field' => $prefix.'id', 'title' => JText::_('VIEW_FORMAT_LABEL_COLUMN_ID'),'filterable' => false, 'width' => '50px'),
            array('field' => $prefix.'code', 'title' => JText::_('VIEW_FORMAT_LABEL_COLUMN_CODE'), 'width' => '50px'),
            array('field' => $prefix.'version', 'title' => JText::_('VIEW_FORMAT_LABEL_COLUMN_VERSION'), 'filterable' => false, 'width' => '50px'),
            array('field' => $prefix.'name', 'title' => JText::_('VIEW_FORMAT_LABEL_COLUMN_NAME'), 'width' => '400px'),
            array('field' => $prefix.'published', 'title' => JText::_('VIEW_FORMAT_LABEL_COLUMN_PUBLISHED'), 'filterable' => false, 'width' => '50px'),
            array('field' => $prefix.'ordered', 'title' => JText::_('VIEW_FORMAT_LABEL_COLUMN_ORDERED'), 'filterable' => false, 'width' => '50px')
        );
        return $json ? substr(json_encode($columns), 1,-1) : $columns;
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


    /**
     * Table Question Option
     *****/
    public static function getNameTableQuestionsOption() {
        return '#__totalsurv_questionsoption';
    }
    public static function getColumnsTableQuestionsOption($implode = false,$prefix = '') {

        $columns = array(
            $prefix.'id' => null,
            $prefix.'name' => '',
            $prefix.'published' => 0,
            $prefix.'format' => null,
            $prefix.'type' => null,
            $prefix.'ordered' => 0,
            $prefix.'params' => null
        );
        return $implode ? implode(',',array_keys($columns)) : $columns;
    }
    public function getColumnsGridQuestionOption($json = false,$prefix = '') {

        $columns = array(
            array('field' => $prefix.'id', 'title' => JText::_('VIEW_FORMAT_LABEL_COLUMN_ID'),'filterable' => false, 'width' => '50px'),
            array('field' => $prefix.'name', 'title' => JText::_('VIEW_FORMAT_LABEL_COLUMN_NAME'), 'width' => '150px'),
            array('field' => $prefix.'published', 'title' => JText::_('VIEW_FORMAT_LABEL_COLUMN_PUBLISHED'), 'filterable' => false, 'width' => '60px'),
            array('field' => $prefix.'type', 'title' => JText::_('VIEW_FORMAT_LABEL_COLUMN_TYPE'), 'filterable' => false, 'width' => '60px', 'format' => ''),
            array('field' => $prefix.'ordered', 'title' => JText::_('VIEW_FORMAT_LABEL_COLUMN_ORDERED'), 'filterable' => false, 'width' => '50px', 'format' => '')
        );
        return $json ? substr(json_encode($columns), 1,-1) : $columns;
    }
    /**
     * END Table Question Option
     **************************************************************************************/

    /**
     * Table Option Question
     *****/
    public static function getNameTableOptionsQuestion() {
        return '#__totalsurv_optionsquestion';
    }
    public static function getColumnsTableOptionsQuestion($implode = false,$prefix = '') {

        $columns = array(
            $prefix.'id' => null,
            $prefix.'name' => '',
            $prefix.'published' => 0,
            $prefix.'question_option' => null,
            $prefix.'ordered' => 0
        );
        return $implode ? implode(',',array_keys($columns)) : $columns;
    }
    public function getColumnsGridOptionsQuestion($json = false,$prefix = '') {

        $columns = array(
            array('field' => $prefix.'id', 'title' => JText::_('VIEW_FORMAT_LABEL_COLUMN_ID'),'filterable' => false, 'width' => '50px'),
            array('field' => $prefix.'name', 'title' => JText::_('VIEW_FORMAT_LABEL_COLUMN_NAME'), 'width' => '150px'),
            array('field' => $prefix.'published', 'title' => JText::_('VIEW_FORMAT_LABEL_COLUMN_PUBLISHED'), 'filterable' => false, 'width' => '60px'),
            array('field' => $prefix.'ordered', 'title' => JText::_('VIEW_FORMAT_LABEL_COLUMN_ORDERED'), 'filterable' => false, 'width' => '50px', 'format' => '')
        );
        return $json ? substr(json_encode($columns), 1,-1) : $columns;
    }
    /**
     * END Table Option Question
     **************************************************************************************/
}

?>