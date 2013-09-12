<?php
/**
 * @module		com_totalsurv
 * @author-name Manuel L. Lara
 * @adapted by  Manuel L.Lara
 * @copyright	Copyright (C) 2012 Manuel L. Lara
 * @license		GNU/GPL, see http://www.gnu.org/licenses/old-licenses/gpl-2.0.txt
 */

// No direct access
defined('_JEXEC') or die('Restricted access');
jimport( 'joomla.html.html.select' );


$options = array();

$options[] = JHTML::_('select.option','1',JText::_('COM_TOTALSURV_YES'));
$options[] = JHTML::_('select.option','0',JText::_('COM_TOTALSURV_NO'));

?>
<form action="<?php echo URL_HOME_ADMIN.'&view=format&layout=edit&fid='.(int)$this->format['id']; ?>" method="post" name="adminForm" id="admin-form-totalsurv" class="form-validate form-totalsurv">
    <input type="hidden" name="dataformat[id]" value="<?php echo (int)$this->format['id']; ?>" />
	<div id="inputs-format" class="column">
        <p id="msg-edit-format" class="message"></p>
        <h4><?php echo JText::_('COM_TOTALSURV_REQUIRED'); ?></h4>
        <div class="row-form">
            <div class="label">
                <label for="format_code"><?php echo JText::_('VIEW_FORMAT_LABEL_CODE'); ?></label>
            </div>
            <div class="input">
                <input type="text" id="format_code" value="<?php echo $this->format['code']; ?>" name="dataformat[code]" class="k-textbox required" required validationMessage="<?php echo JText::_('VIEW_FORMAT_LABEL_REQUIRED_CODE'); ?>" />
            </div>
        </div>
        <div class="row-form">
            <div class="label">
                <label for="format_version"><?php echo JText::_('VIEW_FORMAT_LABEL_VERSION'); ?></label>
            </div>
            <div class="input">
                <input type="text" id="format_version" value="<?php echo $this->format['version']; ?>" name="dataformat[version]" class="k-textbox required" required validationMessage="<?php echo JText::_('VIEW_FORMAT_LABEL_REQUIRED_VERSION'); ?>" />
            </div>
        </div>
        <div class="row-form">
            <div class="label">
                <label for="format_name"><?php echo JText::_('VIEW_FORMAT_LABEL_NAME'); ?></label>
            </div>
            <div class="input">
                <input type="text" id="format_name" value="<?php echo $this->format['name']; ?>" name="dataformat[name]" class="k-textbox required" required validationMessage="<?php echo JText::_('VIEW_FORMAT_LABEL_REQUIRED_NAME'); ?>" />
            </div>
        </div>
        <div class="row-form">
            <div class="label">
                <label for="format_published"><?php echo JText::_('VIEW_FORMAT_LABEL_PUBLISHED'); ?></label>
            </div>
            <div class="input">
                <?php echo JHtml::_('select.genericlist',$options, 'dataformat[published]', 'class="example"', 'value', 'text', $this->format['published'], 'format_published'); ?>
            </div>
        </div>
        <div class="row-form">
            <div class="label">
                <label for="format_commented"><?php echo JText::_('VIEW_FORMAT_LABEL_COMMENTED'); ?></label>
            </div>
            <div class="input">
                <?php echo JHtml::_('select.genericlist',$options, 'dataformat[commented]', 'class="example"', 'value', 'text', $this->format['commented'], 'format_commented'); ?>
            </div>
        </div>
        <div class="row-form">
            <div class="label">
                <label for="format_minvalue"><?php echo JText::_('VIEW_FORMAT_LABEL_MIN_VALUE'); ?></label>
            </div>
            <div class="input">
                <input type="text" id="format_minvalue" value="<?php echo $this->format['min_value']; ?>" name="dataformat[min_value]" class="required" required validationMessage="<?php echo JText::_('VIEW_FORMAT_LABEL_REQUIRED_MIN_VALUE'); ?>" />
            </div>
        </div>
        <div class="row-form">
            <div class="label">
                <label for="format_maxvalue"><?php echo JText::_('VIEW_FORMAT_LABEL_MAX_VALUE'); ?></label>
            </div>
            <div class="input">
                <input type="text" id="format_maxvalue" value="<?php echo $this->format['max_value']; ?>" name="dataformat[max_value]" class="required" required validationMessage="<?php echo JText::_('VIEW_FORMAT_LABEL_REQUIRED_MAX_VALUE'); ?>" />
            </div>
        </div>
        <!-- DATE CREATE -->
        <div class="row-form">
            <div class="label">
                <label for="format_date_create"><?php echo JText::_('VIEW_FORMAT_LABEL_DATE_CREATE'); ?></label>
            </div>
            <div class="input">
                <input id="format_date_create" value="<?php echo $this->format['date_create']; ?>" name="dataformat[date_create]" class="required" required validationMessage="<?php echo JText::_('VIEW_FORMAT_LABEL_REQUIRED_DATE_CREATE'); ?>" />
            </div>
        </div>
        <!-- TEXT INFO VALUE -->
        <div class="row-form">
            <div class="label">
                <label for="format_text_info_value"><?php echo JText::_('VIEW_FORMAT_LABEL_TEXT_INFO_VALUE'); ?></label>
            </div>
            <div class="input">
                <textarea type="text" id="format_text_info_value" name="dataformat[text_info_value]" rows="10" cols="30" style="width:100%;height:200px;"><?php echo $this->format['text_info_value']; ?></textarea>
            </div>
        </div>
        <!-- ENABLE SEND INFO -->
        <div class="row-form">
            <div class="label">
                <label for="format_enable_send_info"><?php echo JText::_('VIEW_FORMAT_LABEL_ENABLE_SEND_INFO'); ?></label>
            </div>
            <div class="input">
                <?php echo JHtml::_('select.genericlist',$options, 'dataformat[enable_send_info]', 'class="example"', 'value', 'text', $this->format['enable_send_info'], 'format_enable_send_info'); ?>
            </div>
        </div>
        <!-- RANGES -->
        <div class="row-form">
            <div class="label">
                <label for="format_range_low"><?php echo JText::_('VIEW_FORMAT_LABEL_RANGE_LOW'); ?></label>
            </div>
            <div class="input">
                <input type="text" id="format_range_low" value="<?php echo $this->format['range_low']; ?>" name="dataformat[range_low]" class="required" required validationMessage="<?php echo JText::_('VIEW_FORMAT_LABEL_REQUIRED_RANGE_LOW'); ?>" />
            </div>
        </div>
        <div class="row-form">
            <div class="label">
                <label for="format_range_medium"><?php echo JText::_('VIEW_FORMAT_LABEL_RANGE_MEDIUM'); ?></label>
            </div>
            <div class="input">
                <input type="text" id="format_range_medium" value="<?php echo $this->format['range_medium']; ?>" name="dataformat[range_medium]" class="required" required validationMessage="<?php echo JText::_('VIEW_FORMAT_LABEL_REQUIRED_RANGE_MEDIUM'); ?>" />
            </div>
        </div>
        <div class="row-form">
            <div class="label">
                <label for="format_range_high"><?php echo JText::_('VIEW_FORMAT_LABEL_RANGE_HIGH'); ?></label>
            </div>
            <div class="input">
                <input type="text" id="format_range_high" value="<?php echo $this->format['range_high']; ?>" name="dataformat[range_high]" class="required" required validationMessage="<?php echo JText::_('VIEW_FORMAT_LABEL_REQUIRED_RANGE_HIGH'); ?>" />
            </div>
        </div>
        <div class="row-form">
            <div class="label">
                <label for="format_range_very_high"><?php echo JText::_('VIEW_FORMAT_LABEL_RANGE_VERY_HIGH'); ?></label>
            </div>
            <div class="input">
                <input type="text" id="format_range_very_high" value="<?php echo $this->format['range_very_high']; ?>" name="dataformat[range_very_high]" class="required" required validationMessage="<?php echo JText::_('VIEW_FORMAT_LABEL_REQUIRED_RANGE_VERY_HIGH'); ?>" />
            </div>
        </div>
        <!-- --------------------------------------- -->
    </div>
    <div id="panel-edit-format" class="column">
        <h3><?php echo JText::_('LAYOUT_EDIT_TITLE_QUESTIONOPTION_BEFORE'); ?></h3>
        <div id="grid-questionsoption-before"></div>
        <h3><?php echo JText::_('LAYOUT_EDIT_TITLE_QUESTION'); ?></h3>
        <div id="grid-questions"></div>
        <h3><?php echo JText::_('LAYOUT_EDIT_TITLE_QUESTIONOPTION_AFTER'); ?></h3>
        <div id="grid-questionsoption-after"></div>
    </div>
	<input type="hidden" name="task" value="" />
	<?php echo JHtml::_('form.token'); ?>
    <script type="text/javascript" src="<?php echo URL_FOLDER_ADMIN.'/views/format/tmpl/editformat.js'; ?>"></script>
</form>
<div id="dialog-update-options"></div>