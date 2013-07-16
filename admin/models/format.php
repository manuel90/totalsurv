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
    Var $table_name = '#__totalsurv_format';
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
    
    function load($fid = 0) {

        if( empty($fid) && !empty($this->format)) {
            return $this->format;
        }
        if( empty($this->format) ) {
            $this->format = $this->getColumns();
        }

        $table = $this->getTable();
        
        if($table->load($fid)) {
            $this->format = TotalSurvCustomFunctions::parse_args($table,$this->format);
            return $this->format;
        }

        return $this->format;
    }
    
    function store($data = null) {
        if( empty($data) ) {
            return false;
        }
        $default = $this->getColumns();
        
        $source = TotalSurvCustomFunctions::parse_args($data,$default);
        $table = $this->getTable();
        if(!$table->save()) {
            return false;
        }
        $this->format = $table;
        return true;
    }


    public function get_all_formats($start = 0,$limit = 0, $orderby = 'id', $ordered = 'ASC') {

        $db = JFactory::getDbo();
        $sql_limit = '';
        if(intVal($limit) > 0 && intVal($start)) {
            $sql_limit = ' LIMIT '.$start.', '.$limit;
        }

        $query = 'SELECT '.$this->getColumns(true).' FROM '.$this->table_name.$sql_limit.' ORDER BY '.$orderby.' '.$ordered.';';

        $db->setQuery($query);
        $list = $db->loadAssocList();
        if( !empty($list) ) {
            foreach($list as &$item) {
                $item['published'] = (bool)$item['published'];
            }
        }
        return $list;
    }

    public function getColumns($implode = false,$prefix = '') {

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

    public function getColumnsGrid($json = false,$prefix = '') {

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
}
