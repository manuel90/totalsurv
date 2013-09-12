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
 * Tendency View
 */
class TotalSurvViewTendency extends JViewLegacy
{
	/**
	 * display method of Tendency view
	 * @return void
	 */
	public function display($tpl = null) {

        $model = $this->getModel();
        $document = JFactory::getDocument();

        $layout = JRequest::getVar('layout', 'default');

        if($layout == 'tendency') {
        	$fid = JRequest::getVar('fid',0);

        	TotalSurvCustomFunctions::loadHighcharts();

        	$controller = TotalSurvCustomFunctions::getController();
        	$model_format = $controller->getModel('format');
        	$format = $model_format->load($fid);

			$model_question_option = $controller->getModel('questionoption');
        	$questions_options = $model_question_option->loadQuestionsOptionByFormat($format['id']);

			$model_question = $controller->getModel('question');
        	$questions = $model_question->loadQuestionsByFormat($format['id']);

        	$document->addScriptDeclaration('var getColumnsGridTotals = ['.TotalSurvCustomFunctions::getColumnsGridTotals($format['id'],true,'').'];');
			
			$this->assignRef('questions',$questions);
        	$this->assignRef('questions_option',$questions_options);
        	$this->assignRef('format',$format);

        } elseif($layout == 'graphline') {

        	TotalSurvCustomFunctions::loadHighcharts();
			
			$controller = TotalSurvCustomFunctions::getController();

			TotalSurvCustomFunctions::script('VIEW_TENDENCY_TITLE_YAXIS');

			$params = JRequest::getVar('pgraph', array());

			$data = $model->loadDataJson($params);

        	$document->addScriptDeclaration('var paramsGraph = '.json_encode($params).';'.
        									'var data_series = '.$data.';');

        	
			$model_question = $controller->getModel('question');
        	$question = $model_question->load($params['question']);

        	$title = $question['name'];
        	$sub_title = '';

        	if( !empty($params['questionoption']) && !empty($params['option']) ) {
        		$model_question_option = $controller->getModel('questionoption');
	        	$question_option = $model_question_option->load($params['questionoption']);

	        	$model_option_question = $controller->getModel('optionquestion');
	        	$option_question = $model_option_question->load($params['option']);

	        	$sub_title = $question_option['name'].": ".$option_question['name'];
        	}

        	$this->assignRef('title', $title);
        	$this->assignRef('subtitle', $sub_title);
        } else {
        	JText::script('VIEW_TENDENCY_LABEL_BTN_SHOW_TENDENCY');
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
            JToolBarHelper::custom('tendency.home', 'home.png', 'home_f2.png', 'VIEW_FORMAT_LABEL_GO_TO_HOME', false);
        } else {
        	JRequest::setVar('hidemainmenu', true);
        	JToolBarHelper::title(JText::_('VIEW_TENDENCY_TITLE_TENDENCY'));
            JToolBarHelper::custom('tendency.back', 'home.png', 'home_f2.png', 'COM_TOTALSURV_LABEL_BACK', false);
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
		$document->setTitle($isList ? JText::_('VIEW_FORMAT_LABEL_TITLE_LIST') : JText::_('VIEW_TENDENCY_TITLE_TENDENCY'));
	}
}
