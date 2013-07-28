<?php
/**
 * @module		com_totalsurv
 * @author-name Manuel L. Lara
 * @adapted by  Manuel L.Lara
 * @copyright	Copyright (C) 2012 Manuel L. Lara
 * @license		GNU/GPL, see http://www.gnu.org/licenses/old-licenses/gpl-2.0.txt
 */

// No direct access to this file
defined('_JEXEC') or die('Restricted Access');

$today = date('Y-m-d');
?>
<script type="text/javascript">var data_filter = { dstart: '<?php echo $today; ?>', dend: '<?php echo $today; ?>', fid: '<?php echo $this->format['id']; ?>'}; </script>
<div id="tsurv-totals">
	<div class="head">
		<h3><?php echo $this->format['name']; ?></h3>
		<div id="filters">
			<div class="range-date" style="width:470px">
                <label for="start"><?php echo JText::_('VIEW_TOTAL_LABEL_START_DATE'); ?></label>
                <input id="start" value="<?php echo $today; ?>" />
                <label for="end" style="margin-left:3em"><?php echo JText::_('VIEW_TOTAL_LABEL_END_DATE'); ?></label>
                <input id="end" value="<?php echo $today; ?>"/>
            </div>
            <div class="filters-questions-option">
            	<?php
            		foreach($this->questions_option as $key=>$dataOption) {
            			list($qo_id,$qo_name) = explode(':',$key);
            			echo '<div class="box-qo">';
            			echo '<label><input type="checkbox" name="filter_question_option" class="filter-question-option" value="'.$qo_id.'" /><span>'.$qo_name.'</span></label>';
            			echo '<div class="box-o">';
            			echo '<select id="option'.$qo_id.'" name="filter_option" class="filter-option" qoption="'.$qo_id.'">';
            			foreach($dataOption as $data) {
            				echo '<option value="'.$data['id'].'">'.$data['name'].'</option>';
            			}
            			echo '</select>';
            			echo '</div>';
            			echo '</div>';
            		}
            	?>
            </div>
		</div>
		<button id="load-results" class="k-button"><?php echo JText::_('VIEW_TOTAL_LABEL_BTN_SHOW_RESULTS'); ?></button>
		<div id="temp"></div>
	</div>
	<div id="results"></div>
    <div id="modal-comment"></div>
	<form id="" action="<?php echo URL_HOME_ADMIN.'&view=totals&layout=totals&fid='.(int)$this->format['id']; ?>" method="post" name="adminForm">
		<input type="hidden" name="task" value="" />
		<?php echo JHtml::_('form.token'); ?>
	</form>
	<script type="text/javascript" src="<?php echo URL_FOLDER_ADMIN.'/views/totals/tmpl/totals.js'; ?>"></script>
</div>