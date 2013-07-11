<?php
/**
 * @module		com_totalsurv
 * @author-name Manuel L. Lara
 * @adapted by  Manuel L.Lara
 * @copyright	Copyright (C) 2012 Manuel L. Lara
 * @license		GNU/GPL, see http://www.gnu.org/licenses/old-licenses/gpl-2.0.txt
 */

// No direct access to this file
defined('_JEXEC') or die('Restricted access');
 
// import Joomla view library
jimport('joomla.application.component.view');
 
/**
 * TotalSurv View
 */
class TotalSurvViewTotalSurv extends JViewLegacy
{
	/**
	 * TotalSurv view display method
	 * @return void
	 */
	function display($tpl = null) 
	{
		// Get data from the model
		//$items = $this->get('Items');
		//$pagination = $this->get('Pagination');
 
		// Check for errors.
		if (count($errors = $this->get('Errors'))) 
		{
			JError::raiseError(500, implode('<br />', $errors));
			return false;
		}
		// Assign data to the view
		//$this->items = $items;
		//$this->pagination = $pagination;
 
		// Set the toolbar
		//$this->addToolBar();
        JToolBarHelper::title(JText::_('COM_TOTALSURV_MANAGER_TOTALSURVS'), 'totalsurv');
        //$this->sidebar = JHtmlSidebar::render();
 
		// Display the template
		parent::display($tpl);
 
		// Set the document
		$document = JFactory::getDocument();
		$document->setTitle(JText::_('COM_TOTALSURV_ADMINISTRATION'));
	}
 
	/**
	 * Setting the toolbar
	 */
	protected function addToolBar() 
	{
		$canDo = TotalSurvHelper::getActions();
		JToolBarHelper::title(JText::_('COM_TOTALSURV_MANAGER_TOTALSURVS'), 'totalsurv');
		if ($canDo->get('core.create')) 
		{
			JToolBarHelper::addNew('totalsurv.add', 'JTOOLBAR_NEW');
		}
		if ($canDo->get('core.edit')) 
		{
			JToolBarHelper::editList('totalsurv.edit', 'JTOOLBAR_EDIT');
		}
		if ($canDo->get('core.delete')) 
		{
			JToolBarHelper::deleteList('', 'totalsurv.delete', 'JTOOLBAR_DELETE');
		}
		if ($canDo->get('core.admin')) 
		{
			JToolBarHelper::divider();
			JToolBarHelper::preferences('com_totalsurv');
		}
	}
    
    protected function loadUrlsViews() {
        
    }
}
