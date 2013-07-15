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
        $this->edit();
    }
    function edit() {
        $this->setRedirect('index.php?option=com_totalsurv&view=format&layout=edit');
    }
    function home() {
        $this->setRedirect(URL_HOME);
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
        $this->setRedirect(URL_HOME.'&view=format');
    }

    function allformats() {

        $model = $this->getModel('format');

        $data = $model->get_all_formats();

        echo json_encode($data);
        die();
    }
}
