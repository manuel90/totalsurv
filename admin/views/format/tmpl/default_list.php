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
// load tooltip behavior
JHtml::_('behavior.tooltip');
?>
<form action="<?php echo URL_HOME; ?>" method="post" name="adminForm" id="adminForm">
    	<table class="table table-striped">
    		<thead>
                <th class="width"></th>
                <th><?php echo ''; ?></th>
                <th></th>
                <th></th>
            </thead>
    		<tfoot></tfoot>
    		<tbody></tbody>
    	</table>
    	<div>
    		<input type="hidden" name="task" value="" />
    		<input type="hidden" name="boxchecked" value="0" />
    		<?php echo JHtml::_('form.token'); ?>
    	</div>
</form>
