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
class TotalSurvModelFormat extends JModelAdmin
{
    var $format;
    
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
	public function getTable($type = 'Format', $prefix = 'TotalSurvTable', $config = array()) 
	{
		return JTable::getInstance($type, $prefix, $config);
	}
    
    function load($id = 0) {
        $format = new stdClass();
        if( empty($id) ) {
            
            if( !empty($this->format) ) {
                return $this->format;
            }
            
            // default values
            $format->id = 0;
            $format->code = null;
            $format->version = null;
            $format->name = '';
            $format->comented = 0;
            $format->published = 0;
            $format->min_value = 0;
            $format->max_value = 5;
            $format->date_create = '00-00-0000';
            $format->text_info_value = '';
            $format->enable_send_info = 0;
            $format->range_low = 0;
            $format->range_medium = 0;
            $format->range_high = 0;
            $format->range_very_high = 0;
            $format->order = 0;
            return $format;
        }
        
        $table = $this->getTable();
        
        if($table->load($id)) {
            return $table;
        }
        return null;
    }
    
    function store($data = null) {
        if( empty($data) ) {
            return false;
        }
        $default = array(
            'id' => null,
            'code' => null,
            'version' => '',
            'name' => '',
            'comented' => 0,
            'published' => 0,
            'min_value' => 0,
            'max_value' => 5,
            'date_create' => '00-00-0000',
            'text_info_value' => '',
            'enable_send_info' => 0,
            'range_low' => 0,
            'range_medium' => 0,
            'range_high' => 0,
            'range_very_high' => 0,
            'order' => 0
        );
        
        $source = TotalSurvCustomFunctions::parse_args($data,$default);
        $table = $this->getTable();
        if(!$table->save()) {
            return false;
        }
        $this->format = $table;
        return true;
    }
}