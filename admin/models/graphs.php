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
 
// import Joomla modelform library
jimport('joomla.application.component.modeladmin');
 
/**
 * Graphs Model
 */
class TotalSurvModelGraphs extends JModelAdmin
{
    /**
     * Method override to check if you can edit an existing record.
     *
     * @param   array   $data   An array of input data.
     * @param   string  $key    The name of the key for the primary key.
     *
     * @return  boolean
     * @since   1.6
     */
    protected function allowEdit($data = array(), $key = 'id')
    {
        
    }

    /**
     * Method to get the record form.
     *
     * @param   array   $data       Data for the form.
     * @param   boolean $loadData   True if the form is to load its own data (default case), false if not.
     * @return  mixed   A JForm object on success, false on failure
     * @since   1.6
     */
    public function getForm($data = array(), $loadData = true) 
    {
        return true;
    }

	public function loadDataJson($params = array()) {

		$result = array();
        $db = JFactory::getDbo();

        $fid = $params['fid'];
        $dstart = $params['dstart'];
        $dend = $params['dend'];
        $data_question_option = null;

        if( !empty($params['questionoption']) && !empty($params['option']) ) {
            $data_question_option = array('id' => $params['questionoption'], 'option' => $params['option']);
        }

        $table_survey = TotalSurvCustomFunctions::getNameTableSurvey();
        $table_answerquestions = TotalSurvCustomFunctions::getNameTableAnswerQuestions();
        $table_questions = TotalSurvCustomFunctions::getNameTableQuestions();
        $columns_answerquestions = TotalSurvCustomFunctions::getColumnsTableAnswerQuestions(true,'ans.');

        $select_surveys = 'SELECT s.id FROM '.$table_survey.' s WHERE s.format=\''.$fid.'\' AND s.date_insert_survey>=\''.$dstart.'\' AND s.date_insert_survey<=\''.$dend.'\';';

        if( !empty($data_question_option) ) {
            $question_option = $data_question_option['id'];
            $option = $data_question_option['option'];

            $table_answerquestionsoption = TotalSurvCustomFunctions::getNameTableAnswerQuestionsOption();

            $db->setQuery('SELECT aqo.survey FROM '.$table_answerquestionsoption.' aqo WHERE aqo.question_option=\''.$question_option.'\' AND aqo.answer=\''.$option.'\';');

            $surveys = $db->loadAssocList();
            $ids_survey = '';
        
            foreach ($surveys as $value) {
                $ids_survey .= $value['survey'].',';
            }
            $ids_survey = substr($ids_survey, 0,-1);

            $select_surveys = 'SELECT s.id FROM '.$table_survey.' s WHERE s.id IN ('.$ids_survey.') AND s.format=\''.$fid.'\' AND s.date_insert_survey>=\''.$dstart.'\' AND s.date_insert_survey<=\''.$dend.'\';';
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
        $default = array();
        foreach ($params['range'] as $value) {
            $default['y'.$value] = array('y' => 0,'name' => sprintf(JText::_('COM_TOTALSURV_LABEL_SCORE'),$value));
        }
        foreach($result as $row) {
            
            $key = 'question'.$row['id'];

            if( array_key_exists($key, $all) ) {
                $data = &$all[$key];
                $kv = 'y'.$row['value'];
                $data[$kv]['y'] = $data[$kv]['y']+1;
            } else {
                $arr2 = array($key => $default);
                $all = array_merge_recursive($all,$arr2);

                $data = &$all[$key];
                $kv = 'y'.$row['value'];
                $data[$kv]['y'] = $data[$kv]['y']+1;
            }
            
        }

        $json = preg_replace('/"y(\d+)":/i', '', json_encode($all));
        $json = preg_replace('/{{/i', '[{', $json);
        $json = preg_replace('/}}/i', '}]', $json);
        return $json;
	}
}
