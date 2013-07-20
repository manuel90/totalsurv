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
<form action="<?php echo URL_HOME_ADMIN.'&view=format&layout=edit&fid='.(int) $this->format['id']; ?>" method="post" name="adminForm" id="adminForm" class="form-validate form-totalsurv">
	<div id="inputs-format" class="column">
        <h4><?php echo JText::_('COM_TOTALSURV_REQUIRED'); ?></h4>
        <div class="row-form">
            <div class="label">
                <label for="format_code"><?php echo JText::_('VIEW_FORMAT_LABEL_CODE'); ?></label>
            </div>
            <div class="input">
                <input type="text" id="format_code" value="<?php echo $this->format['code']; ?>" name="format_code" class="k-textbox required" />
            </div>
        </div>
        <div class="row-form">
            <div class="label">
                <label for="format_version"><?php echo JText::_('VIEW_FORMAT_LABEL_VERSION'); ?></label>
            </div>
            <div class="input">
                <input type="text" id="format_version" value="<?php echo $this->format['version']; ?>" name="format_version" class="k-textbox required" />
            </div>
        </div>
        <div class="row-form">
            <div class="label">
                <label for="format_name"><?php echo JText::_('VIEW_FORMAT_LABEL_NAME'); ?></label>
            </div>
            <div class="input">
                <input type="text" id="format_name" value="<?php echo $this->format['name']; ?>" name="format_name" class="k-textbox required" />
            </div>
        </div>
        <div class="row-form">
            <div class="label">
                <label for="format_publishing"><?php echo JText::_('VIEW_FORMAT_LABEL_PUBLISHING'); ?></label>
            </div>
            <div class="input">
                <?php echo JHtml::_('select.genericlist',$options, 'format_publishing', 'class="example"', 'value', 'text', $this->format['published'], 'format_publishing'); ?>
            </div>
        </div>
        <div class="row-form">
            <div class="label">
                <label for="format_commented"><?php echo JText::_('VIEW_FORMAT_LABEL_COMMENTED'); ?></label>
            </div>
            <div class="input">
                <?php echo JHtml::_('select.genericlist',$options, 'format_commented', 'class="example"', 'value', 'text', $this->format['commented'], 'format_commented'); ?>
            </div>
        </div>
        <div class="row-form">
            <div class="label">
                <label for="format_minvalue"><?php echo JText::_('VIEW_FORMAT_LABEL_MIN_VALUE'); ?></label>
            </div>
            <div class="input">
                <input type="text" id="format_minvalue" value="<?php echo $this->format['min_value']; ?>" name="format_minvalue" class="required" />
            </div>
        </div>
        <div class="row-form">
            <div class="label">
                <label for="format_maxvalue"><?php echo JText::_('VIEW_FORMAT_LABEL_MAX_VALUE'); ?></label>
            </div>
            <div class="input">
                <input type="text" id="format_maxvalue" value="<?php echo $this->format['max_value']; ?>" name="format_maxvalue" class="required" />
            </div>
        </div>
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