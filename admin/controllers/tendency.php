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
 * Tendency Controller
 */
class TotalSurvControllerTendency extends JControllerAdmin
{
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
    function back() {
        $this->cancel();
    }
    function cancel($message = null) {
        $this->setRedirect(URL_HOME_ADMIN.'&view=tendency', $message);
    }

    function allformats() {
        $model = $this->getModel('format');
        $data = $model->get_all_formats();
        echo json_encode($data);
        die();
    }

    
}