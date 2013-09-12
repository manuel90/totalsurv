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
 * OptionQuestion View
 */
class TotalSurvViewOptionQuestion extends JViewLegacy
{
	/**
	 * display method of OptionQuestion view
	 * @return void
	 */
	public function display($tpl = null) {

		$document = JFactory::getDocument();

		$qo_id = JRequest::getInt('qo_id', 0);

		$document->addScriptDeclaration('var getColumnsGridOptionsQuestion = ['.TotalSurvCustomFunctions::getColumnsGridOptionsQuestion(true).'];'.
										'var question_option = '.json_encode($qo_id).';');

		parent::display($tpl);
	}
}
