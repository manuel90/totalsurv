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
 * Format View
 */
class TotalSurvViewFormat extends JViewLegacy
{
    var $format;
	/**
	 * display method of Format view
	 * @return void
	 */
	public function display($tpl = null) {

		$layout = JRequest::getCmd('layout','');

		$id = JRequest::getInt('cid',0);
		
        $model = $this->getModel();
        
        $this->format = $model->load($id);

		if($layout == 'edit') {

		} else {

			$all_formats = $model->get_all_formats();

			$columns = $model->getColumnsGrid('');

			$json_columns  = json_encode($columns);

			
			$this->assignRef('all_formats',$all_formats);

			$this->assignRef('columns',$json_columns);
						
		}

        
		// Set the toolbar
		$this->addToolBar();

		parent::display($tpl);
 
		// Set the document
		$this->setDocument();
	}
 
	/**
	 * Setting the toolbar
	 */
	protected function addToolBar() 
	{
		JRequest::setVar('hidemainmenu', true);
		$user = JFactory::getUser();
		$userId = $user->id;
		$isNew = $this->format->id == 0;
		
        $layout = JRequest::getCmd('layout','list');
        if($layout == 'list') {
            JToolBarHelper::title(JText::_('VIEW_FORMAT_LABEL_TITLE_LIST'));
            JToolBarHelper::custom('format.home', 'home.png', 'home_f2.png', 'VIEW_FORMAT_LABEL_GO_TO_HOME', false);
            JToolBarHelper::custom('format.add', 'new.png', 'new_f2.png', 'VIEW_FORMAT_LABEL_NEW', false);
            JToolBarHelper::custom('format.edit', 'edit.png', 'edit_f2.png', 'VIEW_FORMAT_LABEL_EDIT', false);
            JToolBarHelper::custom('format.publish', 'publish.png', 'publish_f2.png', 'VIEW_FORMAT_LABEL_PUBLISH', false);
            JToolBarHelper::custom('format.unpublish', 'unpublish.png', 'unpublish_f2.png', 'VIEW_FORMAT_LABEL_UNPUBLISH', false);
            JToolBarHelper::custom('format.trash', 'trash.png', 'trash_f2.png', 'VIEW_FORMAT_LABEL_TRASH', false);
            return;
        }
        
        
        $canDo = TotalSurvHelper::getActions($this->format->id);
		JToolBarHelper::title($isNew ? JText::_('VIEW_FORMAT_LABEL_TITLE_NEW') : JText::_('VIEW_FORMAT_LABEL_TITLE_EDIT'), 'format');
		// Built the actions for new and existing records.
		if ($isNew) 
		{
			// For new records, check the create permission.
			if ($canDo->get('core.create')) 
			{
				JToolBarHelper::apply('format.apply', 'JTOOLBAR_APPLY');
				JToolBarHelper::save('format.save', 'JTOOLBAR_SAVE');
				JToolBarHelper::custom('format.save2new', 'save-new.png', 'save-new_f2.png', 'JTOOLBAR_SAVE_AND_NEW', false);
			}
			JToolBarHelper::cancel('format.cancel', 'JTOOLBAR_CANCEL');
		}
		else
		{
			if ($canDo->get('core.edit'))
			{
				// We can save the new record
				JToolBarHelper::apply('format.apply', 'JTOOLBAR_APPLY');
				JToolBarHelper::save('format.save', 'JTOOLBAR_SAVE');
 
				// We can save this record, but check the create permission to see if we can return to make a new one.
				if ($canDo->get('core.create')) 
				{
					JToolBarHelper::custom('format.save2new', 'save-new.png', 'save-new_f2.png', 'JTOOLBAR_SAVE_AND_NEW', false);
				}
			}
			if ($canDo->get('core.create')) 
			{
				JToolBarHelper::custom('format.save2copy', 'save-copy.png', 'save-copy_f2.png', 'JTOOLBAR_SAVE_AS_COPY', false);
			}
			JToolBarHelper::cancel('format.cancel', 'JTOOLBAR_CLOSE');
		}
	}
	/**
	 * Method to set up the document properties
	 *
	 * @return void
	 */
	protected function setDocument() 
	{
		$isNew = $this->format->id == 0;
		$document = JFactory::getDocument();
		$document->setTitle($isNew ? JText::_('COM_TOTALSURV_TOTALSURV_CREATING') : JText::_('COM_TOTALSURV_TOTALSURV_EDITING'));
	}
}
