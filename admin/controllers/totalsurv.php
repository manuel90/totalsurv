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
 * TotalSurv Controller
 */
class TotalSurvControllerTotalSurv extends JControllerAdmin
{
    function apply() {
        
        /**
         * code save
         * */
         
    }
    function add() {
        $this->setRedirect('index.php?option=com_totalsurv&view=totalsurv&layout=edit');
    }
    
    function cancel() {
        $this->setRedirect(URL_HOME);
    }
    
    function save2new() {
        
        /**
         * code save
         * */
        
        $this->add();
    }
    
    function save() {
        
        /**
         * code save
         * */
        
        $this->cancel();
    }
}
