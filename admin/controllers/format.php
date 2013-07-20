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
 * Format Controller
 */
class TotalSurvControllerFormat extends JControllerAdmin
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
    function apply() {
        
        /**
         * code save
         * */
         
    }
    function save() {
        
        /**
         * code save
         * */
        
        $this->home();
    }
    function cancel() {
        $this->setRedirect(URL_HOME_ADMIN.'&view=format');
    }

    function allformats() {
        $model = $this->getModel('format');
        $data = $model->get_all_formats();
        echo json_encode($data);
        die();
    }
}
