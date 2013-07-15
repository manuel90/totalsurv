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
        var crudServiceBaseUrl = "<?php echo URL_HOME_ADMIN; ?>",
        dataSource = new kendo.data.DataSource({
            transport: {
                read:  {
                    url: crudServiceBaseUrl + "&task=format.allformats",
                    dataType: "json"
                },
                parameterMap: function(options, operation) {
                    if (operation !== "read" && options.models) {
                        return {models: kendo.stringify(options.models)};
                    }
                }
            },
            batch: true,
            pageSize: 20,
            schema: {
                model: {
                    id: "id",
                    fields: {
                        id: { type: "number", editable: false, nullable: true },
                        code: { validation: { required: true } },
                        name: { type: "string", validation: { required: true, min: 1} },
                        version: { type: "string" },
                        ordered: { type: "number", validation: { min: 0, required: true } }
                    }
                }
            }
        });

        $("#grid_formats").kendoGrid({
            dataSource: dataSource,
            height: 430,
            scrollable: true,
            sortable: true,
            filterable: true,
            pageable: true,
            selectable: true,
            columns: <?php echo $this->columns; ?>
        });
    });
</script>
