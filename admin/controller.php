<?php
/**
 * @module		com_totalsurv
 * @script		controller.php
 * @author-name Manuel L. Lara
 * @adapted by  Manuel L.Lara
 * @copyright	Copyright (C) 2012 Manuel L. Lara
 * @license		GNU/GPL, see http://www.gnu.org/licenses/old-licenses/gpl-2.0.txt
 */

// No direct access to this file
defined('_JEXEC') or die('Restricted access');
 
// import Joomla controller library
jimport('joomla.application.component.controller');
 
/**
 * General Controller of TotalSurv component
 */
class TotalSurvController extends JControllerLegacy
{
	/**
	 * display task
	 *
	 * @return void
	 */
	function display($cachable = false, $urlparams = array())
	{	// set default view if not set
		JRequest::setVar('view', JRequest::getCmd('view', 'TotalSurv'));
 
		// call parent behavior
		parent::display($cachable);
 
		// Set the submenu
		//TotalSurvHelper::addSubmenu('messages');
	}
}
