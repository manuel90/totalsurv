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

		$layout = JRequest::getCmd('layout','default');
        $model = $this->getModel();
        $document = JFactory::getDocument();

		if($layout == 'edit') {
			$fid = JRequest::getInt('fid', 0);
			$this->format = $model->load($fid);

			$document->addScriptDeclaration('var fid = \''.$this->format['id'].'\';');
			$document->addScriptDeclaration('var getColumnsGridQuestion = ['.TotalSurvCustomFunctions::getColumnsGridQuestion(true).'];');
			$document->addScriptDeclaration('var getColumnsGridQuestionOption = ['.TotalSurvCustomFunctions::getColumnsGridQuestionOption(true).'];');

			TotalSurvCustomFunctions::script('LAYOUT_EDIT_UPDATE_OPTIONS');
			
		} else {
			/**
			 * List General to the formats
			 ***/
			TotalSurvCustomFunctions::script('VIEW_FORMAT_LABEL_EDIT');
			TotalSurvCustomFunctions::script('VIEW_FORMAT_LABEL_DELETE');

			$document->addScriptDeclaration('var getColumnsGridFormat = ['.TotalSurvCustomFunctions::getColumnsGridFormat(true).'];');
			$document->addScriptDeclaration('var tsurv_url_edit_format = \''.URL_HOME_ADMIN.'&view=format&layout=edit&fid={fid}\';');
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
		
        $layout = JRequest::getCmd('layout','default');
        if($layout == 'default') {
            JToolBarHelper::title(JText::_('VIEW_FORMAT_LABEL_TITLE_LIST'));
            JToolBarHelper::custom('format.home', 'home.png', 'home.png', 'VIEW_FORMAT_LABEL_GO_TO_HOME', false);
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
