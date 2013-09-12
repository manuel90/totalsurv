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

        	TotalSurvCustomFunctions::script('VIEW_TOTAL_LABEL_SHOW_COMMENT');        	

        	$this->assignRef('questions_option',$questions_options);
        	$this->assignRef('format',$format);

        } else {
        	TotalSurvCustomFunctions::script('VIEW_TOTAL_LABEL_BTN_SHOW_TABLE_RESULTS');
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
		
        $layout = JRequest::getCmd('layout','list');
        if($layout == 'list') {
            JToolBarHelper::title(JText::_('VIEW_FORMAT_LABEL_TITLE_LIST'));
            JToolBarHelper::custom('totals.home', 'home.png', 'home_f2.png', 'VIEW_FORMAT_LABEL_GO_TO_HOME', false);
        } else {
        	JToolBarHelper::title(JText::_('VIEW_TOTAL_TITLE_TOTALS'));
            JToolBarHelper::custom('totals.back', 'home.png', 'home_f2.png', 'COM_TOTALSURV_LABEL_BACK', false);
        }
	}
	/**
	 * Method to set up the document properties
	 *
	 * @return void
	 */
	protected function setDocument() 
	{
		$layout = JRequest::getCmd('layout','list');
		$isList = $layout == 'list';
		$document = JFactory::getDocument();
		$document->setTitle($isList ? JText::_('VIEW_FORMAT_LABEL_TITLE_LIST') : JText::_('VIEW_TOTAL_TITLE_TOTALS'));
	}
}
