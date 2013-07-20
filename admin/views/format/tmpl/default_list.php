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
<form action="<?php echo URL_HOME_ADMIN; ?>" method="post" name="adminForm" id="adminForm">
    	<div id="grid_formats"></div>
    	<div>
    		<input type="hidden" name="task" value="" />
    		<input type="hidden" name="boxchecked" value="0" />
    		<?php echo JHtml::_('form.token'); ?>
    	</div>
</form>
<script type="text/javascript">
    $(document).ready(function() {
        var dataSource = new kendo.data.DataSource({
            transport: {
                read:  {
                    url: crudServiceBaseUrl + " &task=format.allformats",
                    dataType: "json"
                },
                parameterMap: function(options, operation) {
                    if (operation !== "read" && options.models) {
                        return {models: kendo.stringify(options.models)};
                    }
                }
            },
            batch: true,
            pageSize: 25,
            schema: {
                model: {
                    id: "id",
                    fields: {
                        id: { type: "number", editable: false, nullable: true },
                        code: { validation: { required: true } },
                        version: { type: "string" },
                        name: { type: "string", validation: { required: true, min: 1} },
                        published: { type: "boolean" },
                        ordered: { type: "number" }
                    }
                }
            }
        });
        getColumnsGridFormat.push({ command: { text: Joomla.JText.strings.VIEW_FORMAT_LABEL_EDIT, click: editFormat }, title: '', width: '80px' });
        getColumnsGridFormat.push({ command: { text: Joomla.JText.strings.VIEW_FORMAT_LABEL_DELETE, click: deleteFormat }, title: '', width: '80px' });
        $("#grid_formats").kendoGrid({
            dataSource: dataSource,
            height: 500,
            scrollable: true,
            sortable: true,
            filterable: true,
            pageable: true,
            selectable: true,
            columns: getColumnsGridFormat
        });
        function deleteFormat(e) {
            e.preventDefault();
        }
        function editFormat(e) {
            e.preventDefault();
            var dataItem = this.dataItem($(e.currentTarget).closest("tr"));
            window.location.href = tsurv_url_edit_format.replace('{fid}',dataItem.id);
        }
    });
</script>
