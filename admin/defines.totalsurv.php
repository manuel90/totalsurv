<?php defined('_JEXEC') or die('Restricted access');

if(!defined('DS')){
    define('DS',DIRECTORY_SEPARATOR);
}
define('PATH_TOTALSURV_ADMIN', dirname(__FILE__));
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
    

    public static function getController() {
        
        jimport('joomla.application.component.controller');

        // Get an instance of the controller prefixed by TotalSurv
        $controller = JControllerLegacy::getInstance('TotalSurv');
        return $controller;
    }
    public static function parse_args($data,$default = array()) {
        if(is_object($data)) {
            $data = get_object_vars($data);
        }
        return array_merge($default,$data);
    }
    public static function script($text) {
        $txt = JText::_($text);
        $document = JFactory::getDocument();
        $document->addScriptDeclaration('TotalSurvLang.'.$text.' = "'.$txt.'";');
    }
    public static function load() {

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
        $kendo_style = KENDOUI_STYLE;
        $vars_js = <<<JS
        kendo.culture("es-ES");
        var TotalSurvLang = {};
        var crudServiceBaseUrl = '$crudServiceBaseUrl';
        var kendoui_style = '$kendo_style';
JS;
        $document->addScriptDeclaration($vars_js);
    
    }

    public static function loadHighcharts($add_exporting = false) {
        $document = JFactory::getDocument();
        $document->addScript(URL_FOLDER_ADMIN.'/libraries/highchart/js/highcharts.js');
        if($add_exporting) {
            $document->addScript(URL_FOLDER_ADMIN.'/libraries/highchart/js/modules/exporting.js');
        }
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

    public function getColumnsGridFormat($json = false,$prefix = '',$simple = false) {

        $columns = array(
            array('field' => $prefix.'id', 'title' => JText::_('VIEW_FORMAT_LABEL_COLUMN_ID'),'filterable' => false, 'width' => '50px'),
            array('field' => $prefix.'code', 'title' => JText::_('VIEW_FORMAT_LABEL_COLUMN_CODE'), 'width' => '50px'),
            array('field' => $prefix.'version', 'title' => JText::_('VIEW_FORMAT_LABEL_COLUMN_VERSION'), 'filterable' => false, 'width' => '50px'),
            array('field' => $prefix.'name', 'title' => JText::_('VIEW_FORMAT_LABEL_COLUMN_NAME'), 'width' => '400px')
        );
        if(!$simple) {
            $columns[] = array('field' => $prefix.'published', 'title' => JText::_('VIEW_FORMAT_LABEL_COLUMN_PUBLISHED'), 'filterable' => false, 'width' => '50px');
            $columns[] = array('field' => $prefix.'ordered', 'title' => JText::_('VIEW_FORMAT_LABEL_COLUMN_ORDERED'), 'filterable' => false, 'width' => '50px');
        }
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
    public static function getColumnsTableQuestionsOption($implode = false,$prefix = '',$alias = '') {

        $columns = array(
            $prefix.'id'.($alias != '' ? ' AS '.$alias.'id' : $alias) => null,
            $prefix.'name'.($alias != '' ? ' AS '.$alias.'name' : $alias) => '',
            $prefix.'published'.($alias != '' ? ' AS '.$alias.'published' : $alias) => 0,
            $prefix.'format'.($alias != '' ? ' AS '.$alias.'format' : $alias) => null,
            $prefix.'type'.($alias != '' ? ' AS '.$alias.'type' : $alias) => null,
            $prefix.'ordered'.($alias != '' ? ' AS '.$alias.'ordered' : $alias) => 0,
            $prefix.'params'.($alias != '' ? ' AS '.$alias.'params' : $alias) => null
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

    /**
     * Table Survey
     *****/
    public static function getNameTableSurvey() {
        return '#__totalsurv_survey';
    }
    public static function getColumnsTableSurvey($implode = false,$prefix = '') {

        $columns = array(
            $prefix.'id' => null,
            $prefix.'format' => null,
            $prefix.'date_survey' => '0000-00-00',
            $prefix.'comment' => null,
            $prefix.'date_insert_survey' => '0000-00-00'
        );
        return $implode ? implode(',',array_keys($columns)) : $columns;
    }
    /**
     * END Table Survey
     **************************************************************************************/

    /**
     * Table Answer Question
     *****/
    public static function getNameTableAnswerQuestions() {
        return '#__totalsurv_answerquestions';
    }
    public static function getColumnsTableAnswerQuestions($implode = false,$prefix = '') {

        $columns = array(
            $prefix.'id' => null,
            $prefix.'survey' => null,
            $prefix.'question' => null,
            $prefix.'value' => 0,
            $prefix.'comment' => null
        );
        return $implode ? implode(',',array_keys($columns)) : $columns;
    }
    /**
     * END Table Answer Question
     **************************************************************************************/

    /**
     * Table Answer Question
     *****/
    public static function getNameTableAnswerQuestionsOption() {
        return '#__totalsurv_answerquestionsoption';
    }
    public static function getColumnsTableAnswerQuestionsOption($implode = false,$prefix = '') {

        $columns = array(
            $prefix.'id' => null,
            $prefix.'survey' => null,
            $prefix.'question_option' => null,
            $prefix.'answer' => ''
        );
        return $implode ? implode(',',array_keys($columns)) : $columns;
    }
    /**
     * END Table Answer Question
     **************************************************************************************/

    /**
     * Grid Totals
     *****/
    public function getColumnsGridTotals($fid,$json = false,$prefix = '') {

        $db = JFactory::getDbo();
        $table_question = TotalSurvCustomFunctions::getNameTableQuestions();
        
        $query = 'SELECT CONCAT(\'question\',q.id) AS field,q.name AS title,CONCAT(\'250px\') AS width FROM '.$table_question.' q WHERE q.format=\''.$fid.'\' ORDER BY q.ordered ASC;';

        $db->setQuery($query);

        $columns = $db->loadAssocList();
        $firts_columns = array(
            array('field' => 'survey', 'title' => JText::_('VIEW_TOTAL_LABEL_SURVEY'), 'width' => '100px')
        );
        $columns = array_merge($firts_columns,$columns);

        $columns[] = array('field' => 'total', 'title' => JText::_('VIEW_TOTAL_LABEL_TOTAL'), 'width' => '100px');
        $columns[] = array('field' => 'comment', 'title' => JText::_('VIEW_TOTAL_LABEL_COMMENTS'), 'width' => '150px');

        return $json ? substr(json_encode($columns), 1,-1) : $columns;
    }
}

?>