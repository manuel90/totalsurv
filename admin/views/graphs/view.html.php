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
 * Graphs View
 */
class TotalSurvViewGraphs extends JViewLegacy
{
	/**
	 * display method of Graphs view
	 * @return void
	 */
	public function display($tpl = null) {

        $model = $this->getModel();
        $document = JFactory::getDocument();
        $controller = TotalSurvCustomFunctions::getController();
		
		$layout = JRequest::getCmd('layout','default');

		$type = JRequest::getCmd('gtype','none');
		$document->addScriptDeclaration('var getColumnsGridFormat = ['.TotalSurvCustomFunctions::getColumnsGridFormat(true,'',true).'];'.
				'var graphtype = "'.$type.'";');
		TotalSurvCustomFunctions::script('VIEW_GRAPHS_LABEL_BTN_GRAPH');
		TotalSurvCustomFunctions::script('COM_TOTALSURV_LABEL_MESSAGE');
		TotalSurvCustomFunctions::script('VIEW_TOTALSURV_LABEL_LAYOUT_GRAPHBAR');
		TotalSurvCustomFunctions::script('VIEW_TOTALSURV_LABEL_LAYOUT_GRAPHPIE');

		$fid = JRequest::getVar('fid',0);
		
		$format = null;
		if( !empty($fid) ) {
			$model_format = $controller->getModel('format');
	        $format = $model_format->load($fid);
		}

		switch ($layout) {
			case 'graph':
	        	
				$model_question_option = $controller->getModel('questionoption');
	        	$questions_options = $model_question_option->loadQuestionsOptionByFormat($format['id']);

	        	$this->assignRef('questions_option',$questions_options);
				$this->assignRef('graphtype', $type);
				$this->assignRef('format',$format);
			break;
			case 'chart':
					
				TotalSurvCustomFunctions::loadHighcharts(true);
				TotalSurvCustomFunctions::script('COM_TOTALSURV_LABEL_SCORES');
				TotalSurvCustomFunctions::script('VIEW_GRAPHS_TITLE_YAXIS');
				TotalSurvCustomFunctions::script('VIEW_GRAPHS_LABEL_TOTAL');
				
				$params = JRequest::getVar('pgraph', array());

				$model_format = $controller->getModel('format');
        		$format = $model_format->load($params['fid']);

				$model_question = $controller->getModel('question');
        		$questions = $model_question->loadQuestionsByFormat($format['id']);

        		$categories = range($format['min_value'], $format['max_value']);
        		$params['range'] = $categories;

        		$dataJson = $model->loadDataJson($params);
        		$document->addScriptDeclaration('var questionsCharts = '.json_encode($questions).';'.
        			'var dataGraphJson = '.$dataJson.';'.
        			'var categoriesChart = '.json_encode($categories).';');

				$this->assignRef('questions',$questions);
			default:
				
			break;
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
		
        $layout = JRequest::getCmd('layout','default');
        if($layout == 'default') {
            JToolBarHelper::title(JText::_('VIEW_FORMAT_LABEL_TITLE_LIST'));
            JToolBarHelper::custom('graphs.home', 'home.png', 'home.png', 'VIEW_FORMAT_LABEL_GO_TO_HOME', false);
        } else {
        	$type = JRequest::getCmd('gtype','none');

        	JRequest::setVar('hidemainmenu', true);
        	JToolBarHelper::title( $type == 'graphbar' ? JText::_('VIEW_GRAPHS_TITLE_GRAPH_BAR') : JText::_('VIEW_GRAPHS_TITLE_GRAPH_PIE'));
            JToolBarHelper::custom('graphs.back', 'back.png', 'back.png', 'COM_TOTALSURV_LABEL_BACK', false);
        }
        
	}
	/**
	 * Method to set up the document properties
	 *
	 * @return void
	 */
	protected function setDocument() 
	{
		$layout = JRequest::getCmd('layout','default');

		if($layout == 'default') {

		} else {
			
		}
		$type = JRequest::getCmd('gtype','none');
		switch ($type) {
			case 'graphbar':
				$title = JText::_('VIEW_GRAPHS_TITLE_GRAPH_BAR');
			break;
			case 'graphpie':
				$title = JText::_('VIEW_GRAPHS_TITLE_GRAPH_PIE');
			break;
			default:
				$title = JText::_('VIEW_FORMAT_LABEL_TITLE_LIST');
			break;
		}

		$document = JFactory::getDocument();
		$document->setTitle($title);
	}
}
