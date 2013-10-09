<?php
/**
 * @module      com_totalsurv
 * @author-name Manuel L. Lara
 * @adapted by  Manuel L.Lara
 * @copyright   Copyright (C) 2012 Manuel L. Lara
 * @license     GNU/GPL, see http://www.gnu.org/licenses/old-licenses/gpl-2.0.txt
 */

// No direct access to this file
defined('_JEXEC') or die('Restricted Access');
?>
<div class="graph-type">
    <script type="text/x-kendo-tmpl" id="template_type">
        <div id="id_#:Type#" class="type k-center">
            <img src="<?php echo URL_FOLDER_ADMIN.'/views/totalsurv/tmpl/images/icon-view-#:TypeImage#.png'; ?>" alt="#:TypeName#" />
            <h3>#:TypeName#</h3>
        </div>
    </script>
    <div id="list_graphtype"></div>
    <div id="message" style="display: none;"><?php echo JText::_('VIEW_GRAPHS_MESSAGE_NOT_SELECTED_GRAPH_TYPE'); ?></div>
</div>
<form action="<?php echo URL_HOME_ADMIN; ?>" method="post" name="adminForm" id="adminForm">
        <div id="grid_formats"></div>
        <div>
            <input type="hidden" name="task" value="" />
            <input type="hidden" name="boxchecked" value="0" />
            <?php echo JHtml::_('form.token'); ?>
        </div>
</form>
<script type="text/javascript" src="<?php echo URL_FOLDER_ADMIN.'/views/graphs/tmpl/default.js'; ?>"></script>