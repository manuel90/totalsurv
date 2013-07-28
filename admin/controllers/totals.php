<?php
/**
 * @module		com_totalsurv
 * @script		totalsurv.php
 * @author-name Manuel L. Lara
 * @adapted by  Manuel L.Lara
 * @copyright	Copyright (C) 2012 Manuel L. Lara
 * @license		GNU/GPL, see http://www.gnu.org/licenses/old-licenses/gpl-2.0.txt
 */

// No direct access to this file
defined('_JEXEC') or die('Restricted access');
 
// import Joomla controllerform library
jimport('joomla.application.component.controlleradmin');
 
/**
 * Totals Controller
 */
class TotalSurvControllerTotals extends JControllerAdmin
{
    
    function add() {
        $model = $this->getModel('format');
        $new = array(
            'code' => '',
            'version' => '',
            'name' => '',
            'commented' => 0,
            'published' => 0,
            'min_value' => 1,
            'max_value' => 5,
            'date_create' => '00-00-0000',
            'text_info_value' => 0,
            'enable_send_info' => 0,
            'range_low' => 0,
            'range_medium' => 0,
            'range_high' => 0,
            'range_very_high' => 0,
            'ordered' => 0
        );
        $format = $model->store($new);
        $this->edit($format['id']);
    }
    function edit($fid = 0) {
        $fid = JRequest::getVar('fid',$fid);
        $this->setRedirect('index.php?option=com_totalsurv&view=format&layout=edit&fid='.$fid);
    }
    function home() {
        $this->setRedirect(URL_HOME_ADMIN);
    }
    function publish() {
        
        $this->cancel();
    }
    function unpublish() {
        
        $this->cancel();
    }
    function save2new() {
        
        /**
         * code save
         * */
        
        $this->add();
    }
    function apply($redirect = true) {

        $fid = JRequest::getVar('fid',$fid);
        $format = JRequest::getVar('dataformat',array());
        if( empty($format) ) {
            $this->setRedirect('index.php?option=com_totalsurv&view=format&layout=edit&fid='.$fid,JText::_('VIEW_FORMAT_MSG_FORMAT_SAVE_ERROR'));
            return;
        }
        $model = $this->getModel('format');
        $result = $model->store($format);
        if( empty($result) ) {
            $this->setRedirect('index.php?option=com_totalsurv&view=format&layout=edit&fid='.$fid,JText::_('VIEW_FORMAT_MSG_FORMAT_SAVE_ERROR')); 
        }
        if($redirect) {
            $this->setRedirect('index.php?option=com_totalsurv&view=format&layout=edit&fid='.$fid,JText::_('VIEW_FORMAT_MSG_FORMAT_SAVE_SUCCESS')); 
        }
    }
    function save() {
        $this->apply(false);
        $this->cancel(JText::_('VIEW_FORMAT_MSG_FORMAT_SAVE_SUCCESS'));
    }
    function cancel($message = null) {
        $this->setRedirect(URL_HOME_ADMIN.'&view=totals', $message);
    }

    function allformats() {
        $model = $this->getModel('format');
        $data = $model->get_all_formats();
        echo json_encode($data);
        die();
    }

    function ajaxGetTotals() {

        $result = array();
        $db = JFactory::getDbo();

        $fid = JRequest::getVar('fid', 0);
        $dstart = JRequest::getVar('dstart', '');
        $dend = JRequest::getVar('dend', '');
        $data_question_option = JRequest::getVar('question_option', null);

        $table_survey = TotalSurvCustomFunctions::getNameTableSurvey();
        $table_answerquestions = TotalSurvCustomFunctions::getNameTableAnswerQuestions();
        $table_questions = TotalSurvCustomFunctions::getNameTableQuestions();
        $columns_answerquestions = TotalSurvCustomFunctions::getColumnsTableAnswerQuestions(true,'ans.');

        $select_surveys = 'SELECT s.id FROM '.$table_survey.' s WHERE s.format=\''.$fid.'\' AND s.date_insert_survey>=\''.$dstart.'\' AND s.date_insert_survey<=\''.$dend.'\'';

        if( !empty($data_question_option) ) {
            $question_option = $data_question_option['id'];
            $option = $data_question_option['option'];

            $table_answerquestionsoption = TotalSurvCustomFunctions::getNameTableAnswerQuestionsOption();

            $select_surveys = 'SELECT s.id FROM '.$table_survey.' s WHERE s.id IN (SELECT aqo.survey FROM '.$table_answerquestionsoption.' aqo WHERE aqo.question_option=\''.$question_option.'\' AND aqo.answer=\''.$option.'\') AND s.format=\''.$fid.'\' AND s.date_insert_survey>=\''.$dstart.'\' AND s.date_insert_survey<=\''.$dend.'\'';
        }
        
        $db->setQuery($select_surveys);

        $surveys = $db->loadAssocList();

        $ids_survey = '';
        foreach ($surveys as $value) {
            $ids_survey .= $value['id'].',';
        }
        $ids_survey = substr($ids_survey, 0,-1);
        $query = <<<SQL
            SELECT answ.survey,q.id,q.name,answ.value,answ.comment 
            FROM 
                (
                    SELECT $columns_answerquestions 
                    FROM $table_answerquestions ans WHERE ans.survey IN ($ids_survey)
                ) AS answ
                LEFT JOIN $table_questions q 
                    ON q.published='1' AND q.id=answ.question 
            WHERE q.id IS NOT NULL 
            ORDER BY q.ordered ASC;
SQL;

        $db->setQuery($query);
        $result = $db->loadAssocList();

        $all = array();
        foreach($result as $row) {
            $arr2 = array('survey'.$row['survey'] => array('question'.$row['id'] => $row['value']));
            $all = array_merge_recursive($all,$arr2);
            if(!array_key_exists('survey', $all['survey'.$row['survey']])) {
                $all['survey'.$row['survey']]['survey'] = 'Encuesta #'.$row['survey'];
                $all['survey'.$row['survey']]['comment'] = $row['comment'];
                $all['survey'.$row['survey']]['total'] = 0;
            }
            $all['survey'.$row['survey']]['total'] += $row['value'];
        }
        $json = '['.substr(json_encode($all), 1,-1).']';
        echo(preg_replace('/"survey(\d+)":/i', '', $json));
        die();
    }
}