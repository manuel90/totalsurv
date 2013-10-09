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
 * Graphs Controller
 */
class TotalSurvControllerGraphs extends JControllerAdmin
{
    function home() {
        $this->setRedirect(URL_HOME_ADMIN);
    }
    function back() {
        $this->cancel();
    }
    function cancel($message = null) {
        $this->setRedirect(URL_HOME_ADMIN.'&view=graphs', $message);
    }
}