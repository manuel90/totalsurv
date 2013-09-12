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
 * Tendency Model
 */
class TotalSurvModelTendency extends JModelAdmin
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
        $question = $params['question'];
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
            SELECT answ.survey,CONCAT(YEAR(s.date_insert_survey),"-",MONTH(s.date_insert_survey)) AS date_insert_survey,q.id,q.name,answ.value,answ.comment 
            FROM 
                (
                    SELECT $columns_answerquestions 
                    FROM $table_answerquestions ans WHERE ans.survey IN ($ids_survey)
                ) AS answ
                LEFT JOIN $table_questions q 
                    ON q.id='$question' AND q.published='1' AND q.id=answ.question 
                LEFT JOIN $table_survey s
                        ON s.id=answ.survey
            WHERE q.id IS NOT NULL 
            ORDER BY s.date_insert_survey ASC;
SQL;

        $db->setQuery($query);

        $result = $db->loadAssocList();

        $all = array();
        $months = $this->calcMonths($dstart, $dend);
        $default = $this->getDefaultValueMonths($months);
        $txt_val = JText::_('COM_TOTALSURV_LABEL_SCORE');
        foreach ($result as $key => $row) {

            if( empty($all['rg'.$row['value']]) ) {
                $all['rg'.$row['value']] = array('name' => sprintf($txt_val,$row['value']), 'data' => $default);
            }

            $arr = $all['rg'.$row['value']]['data'];

            if( array_key_exists($row['date_insert_survey'], $arr) ) {
                $val = $arr[$row['date_insert_survey']];
                $all['rg'.$row['value']]['data'][$row['date_insert_survey']] = $val+1;
            } else {
                $arr2 = array('rg'.$row['value'] => array('name' => sprintf($txt_val,$row['value']), 'data' => array($row['date_insert_survey'] => 1)) );
                $all = array_merge_recursive($all,$arr2);
            }

        }
        krsort($all);

        $json = '['.substr(json_encode($all), 1,-1).']';
        $json = preg_replace('/"rg(\d+)":/i', '', $json);
        $json = preg_replace('/"(\d{4}-\d+)":/i', '', $json);

        $json = preg_replace('/:{/i', ':[', $json);
        $json = preg_replace('/}}/i', ']}', $json);

        return $json;
	}
    
    public function calcMonths($dstart, $dend) {
        
            $part = explode('-', $dstart);
            $dsY = intVal($part[0]);
            $dsM = intVal($part[1]);

            $part = explode('-', $dend);
            $deY = intVal($part[0]);
            $deM = intVal($part[1]);

            $ms = array();
            while($dsY != $deY || $dsM != $deM) {

                $ms[] = array('month' => $dsM, 'year' => $dsY);

                if($dsM%12 == 0) {
                    $dsY++;
                }
                $dsM = $dsM%12 + 1;
            }
            $ms[] = array('month' => $dsM, 'year' => $dsY);
            return $ms;
        }

    public function getDefaultValueMonths($months) {
        $default = array();
        ksort($months);
        foreach ($months as $value) {
            $default[$value['year'].'-'.$value['month']] = 0;
        }
        return $default;
    }
}
