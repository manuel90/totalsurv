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

        var viewTendencies= function(e) {
            e.preventDefault();
            var dataItem = this.dataItem($(e.currentTarget).closest("tr"));
            window.location.href = crudServiceBaseUrl + "&view=tendency&layout=tendency&fid="+dataItem.id;
        };

        var dataSource = new kendo.data.DataSource({
            transport: {
                read:  {
                    url: crudServiceBaseUrl + " &task=tendency.allformats",
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
                        name: { type: "string", validation: { required: true, min: 1} }
                    }
                }
            }
        });
        getColumnsGridFormat.push({ command: { text: Joomla.JText.strings.VIEW_TENDENCY_LABEL_BTN_SHOW_TENDENCY, click: viewTendencies }, title: '', width: '80px' });
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
        
    });
</script>