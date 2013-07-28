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
class TotalSurvViewTotals extends JViewLegacy
{
	/**
	 * display method of Format view
	 * @return void
	 */
	public function display($tpl = null) {
		
        $model = $this->getModel();
        $document = JFactory::getDocument();

        $layout = JRequest::getVar('layout', 'default');

        if($layout == 'totals') {
        	$fid = JRequest::getVar('fid',0);

        	$controller = TotalSurvCustomFunctions::getController();
        	$model_format = $controller->getModel('format');
        	$format = $model_format->load($fid);

        	$model_question_option = $controller->getModel('questionoption');
        	$questions_options = $model_question_option->loadQuestionsOptionByFormat($format['id']);
        	
        	$document->addScriptDeclaration('var getColumnsGridTotals = ['.TotalSurvCustomFunctions::getColumnsGridTotals($format['id'],true,'').'];');

        	JText::script('VIEW_TOTAL_LABEL_SHOW_COMMENT');        	

        	$this->assignRef('questions_option',$questions_options);
        	$this->assignRef('format',$format);

        } else {
        	JText::script('VIEW_TOTAL_LABEL_BTN_SHOW_TABLE_RESULTS');
			$document->addScriptDeclaration('var getColumnsGridFormat = ['.TotalSurvCustomFunctions::getColumnsGridFormat(true,'',true).'];');
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
		
		$user = JFactory::getUser();
		$userId = $user->id;
		$isNew = $this->format['id'] == 0;
		
        $layout = JRequest::getCmd('layout','list');
        if($layout == 'list') {
            JToolBarHelper::title(JText::_('VIEW_FORMAT_LABEL_TITLE_LIST'));
            JToolBarHelper::custom('totals.home', 'home.png', 'home_f2.png', 'VIEW_FORMAT_LABEL_GO_TO_HOME', false);
            JToolBarHelper::custom('totals.add', 'new.png', 'new_f2.png', 'VIEW_FORMAT_LABEL_NEW', false);
            JToolBarHelper::custom('totals.publish', 'publish.png', 'publish_f2.png', 'VIEW_FORMAT_LABEL_PUBLISH', false);
            JToolBarHelper::custom('totals.unpublish', 'unpublish.png', 'unpublish_f2.png', 'VIEW_FORMAT_LABEL_UNPUBLISH', false);
            return;
        }
        JRequest::setVar('hidemainmenu', true);
        
        $canDo = TotalSurvHelper::getActions($this->format->id);
		JToolBarHelper::title($isNew ? JText::_('VIEW_FORMAT_LABEL_TITLE_NEW') : JText::_('VIEW_FORMAT_LABEL_TITLE_EDIT'), 'format');
		// Built the actions for new and existing records.
		if ($isNew) 
		{
			// For new records, check the create permission.
			if ($canDo->get('core.create')) 
			{
				JToolBarHelper::apply('totals.apply', 'JTOOLBAR_APPLY');
				JToolBarHelper::save('totals.save', 'JTOOLBAR_SAVE');
				JToolBarHelper::custom('totals.save2new', 'save-new.png', 'save-new_f2.png', 'JTOOLBAR_SAVE_AND_NEW', false);
			}
			JToolBarHelper::cancel('totals.cancel', 'JTOOLBAR_CANCEL');
		}
		else
		{
			if ($canDo->get('core.edit'))
			{
				// We can save the new record
				JToolBarHelper::apply('totals.apply', 'JTOOLBAR_APPLY');
				JToolBarHelper::save('totals.save', 'JTOOLBAR_SAVE');
			}
			JToolBarHelper::cancel('totals.cancel', 'JTOOLBAR_CLOSE');
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
