<?php
/**
 * @module      com_totalsurv
 * @script      totalsurv.php
 * @author-name Manuel L. Lara
 * @adapted by  Manuel L.Lara
 * @copyright   Copyright (C) 2012 Manuel L. Lara
 * @license     GNU/GPL, see http://www.gnu.org/licenses/old-licenses/gpl-2.0.txt
 */

// No direct access to this file
defined('_JEXEC') or die('Restricted access');
 
// import Joomla controllerform library
jimport('joomla.application.component.controlleradmin');
 
/**
 * Format Controller
 */
class TotalSurvControllerQuestion extends JControllerAdmin
{
    
    function ajaxnew() {
        
        /**
         * code save
         * */
        $data_json = JRequest::getVar('models',null);
        $result = array(
            'status' => 'error',
            'message' => JText::_('Error not delete question')
        );
        if( !empty($data_json) ) {
            $data = json_decode($data_json);
            if(count($data) > 0) {
                $data_new = is_object($data[0]) ? get_object_vars($data[0]) : $data[0];
                $data_new['published'] = (int)$data_new['published'];
                $model = $this->getModel('question');
                if(!array_key_exists('format', $data_new)) {
                    $data_new['format'] = JRequest::getInt('fid', 0);
                }
                $new = $model->store($data_new);
                if($new) {
                    $result = get_object_vars($new);
                    $result['published'] = (bool)$result['published'];
                }
            }
        }
        echo json_encode($result);
        die();
    }
    function ajaxupdate() {
        
        $data_json = JRequest::getVar('models',null);
        $result = array(
            'status' => 'error',
            'message' => JText::_('Error not update question')
        );
        if( !empty($data_json) ) {
            $data = json_decode($data_json);
            if(count($data) > 0) {
                $data_new = is_object($data[0]) ? get_object_vars($data[0]) : $data[0];
                $data_new['published'] = (int)$data_new['published'];
                $model = $this->getModel('question');
                if($model->store($data_new)) {
                    $result = $data;
                }
            }
        }
        echo json_encode($result);
        die();
    }
    function ajaxdelete() {
        $data_json = JRequest::getVar('models',null);
        $result = array(
            'status' => 'error',
            'message' => JText::_('Error not delete question')
        );
        if( !empty($data_json) ) {
            $data = json_decode($data_json);
            if(count($data) > 0) {
                $data_new = is_object($data[0]) ? get_object_vars($data[0]) : $data[0];
                $model = $this->getModel('question');
                if($model->delete($data_new['id'])) {
                    $result = $data;
                }
            }
        }
        echo json_encode($result);
        die();
    }

    function ajaxQuestionByFormat() {
        $fid = JRequest::getInt('fid', 0);
        if( empty($fid) ) {
            die(json_encode(array()));
        }
        $db = JFactory::getDbo();

        $columns = TotalSurvCustomFunctions::getColumnsTableQuestions(true,'q.');
        $table = TotalSurvCustomFunctions::getNameTableQuestions();
        $query = 'SELECT '.$columns.' FROM '.$table.' q WHERE q.format='.$fid.' ORDER BY q.ordered ASC;';

        $db->setQuery($query);
        $list = $db->loadAssocList();
        if( !empty($list) ) {
            foreach($list as &$item) {
                $item['published'] = (bool)$item['published'];
            }
        }
        die(json_encode($list));
    }
}
