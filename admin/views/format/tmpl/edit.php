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
JHtml::_('behavior.tooltip');
JHtml::_('behavior.formvalidation');
JHtml::_('formbehavior.chosen', '.chzn-select');
JHtml::_('jquery.ui', array('core', 'sortable'));
?>
<form action="<?php echo JRoute::_('index.php?option=com_totalsurv&view=format&layout=edit&id='.(int) $this->format->id); ?>" method="post" name="adminForm" id="adminForm" class="form-validate">
	<fieldset>
        <legend><?php echo JText::_('VIEW_FORMAT_LEGEND_DETAILS'); ?></legend>
        <small><?php echo JText::_('COM_TOTALSURV_REQUIRED'); ?></small>
        
        <label><?php echo JText::_('VIEW_FORMAT_LABEL_CODE'); ?></label>
        <input type="text" placeholder="" class="required"/>
        
        <label><?php echo JText::_('VIEW_FORMAT_LABEL_VERSION'); ?></label>
        <input type="text" placeholder="" class="required"/>
        
        <label><?php echo JText::_('VIEW_FORMAT_LABEL_NAME'); ?></label>
        <input type="text" placeholder="" class="required"/>
        
        <label><?php echo JText::_('VIEW_FORMAT_LABEL_PUBLISHING'); ?></label>
        <fieldset id="fieldset_published" class="radio btn-group">
            <input type="radio" id="published1" name="published" value="1" />
            <label for="published1" class="btn"><?php echo JText::_('COM_TOTALSURV_YES'); ?></label>
            <input type="radio" id="published2" name="published" value="0" checked="checked" />
            <label for="published2" class="btn"><?php echo JText::_('COM_TOTALSURV_NO'); ?></label>
        </fieldset>
        
        <label><?php echo JText::_('VIEW_FORMAT_LABEL_COMMENTED'); ?></label>
        <fieldset id="fieldset_comented" class="radio btn-group">
            <input type="radio" id="comented1" name="comented" value="1" />
            <label for="comented1" class="btn"><?php echo JText::_('COM_TOTALSURV_YES'); ?></label>
            <input type="radio" id="comented2" name="comented" value="0" checked="checked" />
            <label for="comented2" class="btn"><?php echo JText::_('COM_TOTALSURV_NO'); ?></label>
        </fieldset>
        <label><?php echo JText::_('VIEW_FORMAT_LABEL_MIN_VALUE'); ?></label>
        <input id="min_value" name="min_value" value="1" />
        <label><?php echo JText::_('VIEW_FORMAT_LABEL_MAX_VALUE'); ?></label>
        
    </fieldset>
    <div>
		<input type="hidden" name="task" value="" />
		<?php echo JHtml::_('form.token'); ?>
	</div>
    <script type="text/javascript">
        jQuery(document).on('ready', function(){
            jQuery('#min_value').spinner({min: 1});
        });
    </script>
</form>
