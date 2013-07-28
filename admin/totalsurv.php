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
 
// Access check.
if (!JFactory::getUser()->authorise('core.manage', 'com_totalsurv')) 
{
	return JError::raiseWarning(404, JText::_('JERROR_ALERTNOAUTHOR'));
}

require_once('defines.totalsurv.php');

TotalSurvCustomFunctions::load();
 
// require helper file
JLoader::register('TotalSurvHelper', dirname(__FILE__) . DS . 'helpers' . DS . 'totalsurv.php');
 
// import joomla controller library
jimport('joomla.application.component.controller');
 

$execute = $task = JRequest::getCmd('task');

// Get an instance of the controller prefixed by TotalSurv
$controller = JControllerLegacy::getInstance('TotalSurv');

if($task && (bool)strpos($task,'.')) {
	list($controller,$execute) = explode('.',$task);
	$controller = JControllerLegacy::getInstance(ucfirst($controller));
}
// Perform the Request task
$controller->execute($execute);
 
// Redirect if set by the controller
$controller->redirect();
