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
 * Format Model
 */
class TotalSurvModelQuestion extends JModelAdmin
{
	/**
	 * Method override to check if you can edit an existing record.
	 *
	 * @param	array	$data	An array of input data.
	 * @param	string	$key	The name of the key for the primary key.
	 *
	 * @return	boolean
	 * @since	1.6
	 */
	protected function allowEdit($data = array(), $key = 'id')
	{
        
	}
	/**
	 * Method to get the record form.
	 *
	 * @param	array	$data		Data for the form.
	 * @param	boolean	$loadData	True if the form is to load its own data (default case), false if not.
	 * @return	mixed	A JForm object on success, false on failure
	 * @since	1.6
	 */
	public function getForm($data = array(), $loadData = true) 
	{
		// Get the form.
		$form = $this->loadForm('com_totalsurv.format', 'format', array('control' => 'jform', 'load_data' => $loadData));
		if (empty($form)) 
		{
			return false;
		}
		return $form;
	}
	/**
	 * Returns a reference to the a Table object, always creating it.
	 *
	 * @param	type	The table type to instantiate
	 * @param	string	A prefix for the table class name. Optional.
	 * @param	array	Configuration array for model. Optional.
	 * @return	JTable	A database object
	 * @since	1.6
	 */
	public function getTable($type = 'Question', $prefix = 'TotalSurvTable', $config = array()) 
	{
		return JTable::getInstance($type, $prefix, $config);
	}
    
    function load($qid = 0) {
    	if( empty($qid) ) {
            return null;
        }
        $table = $this->getTable();
        
        if($table->load($qid)) {
            $load = TotalSurvCustomFunctions::parse_args($table);
            return $load;
        }
        return null;
    }
    
    function store($data = null) {
        if( empty($data) ) {
            return false;
        }
        $default = TotalSurvCustomFunctions::getColumnsTableQuestions();
        
        $update_data = TotalSurvCustomFunctions::parse_args($data,$default);
        $table = $this->getTable();

        if(!$table->bind($update_data)) {
            return false;
        }
        if($table->store()) {
            return $table;
        }
        return false;
    }

    function delete($qid) {
        if( empty($qid) ) {
            return false;
        }
        $table = $this->getTable();
        return $table->delete($qid);
    }

    function loadQuestionsByFormat($fid) {

    	$db = JFactory::getDbo();

    	$table_q = TotalSurvCustomFunctions::getNameTableQuestions();

    	$columns_q = TotalSurvCustomFunctions::getColumnsTableQuestions(true,'q.');

    	$query = 'SELECT '.$columns_q.' FROM '.$table_q.' q WHERE q.published=\'1\' AND q.format=\''.$fid.'\' ORDER BY q.ordered ASC;';

    	$db->setQuery($query);
    	$result = $db->loadAssocList();
    	
    	return $result;
    }

}
