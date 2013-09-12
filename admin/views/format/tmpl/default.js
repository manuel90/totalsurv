jQuery(document).on('ready', init_list_formats);

function init_list_formats() {
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
    getColumnsGridFormat.push({ command: { text: TotalSurvLang.VIEW_FORMAT_LABEL_EDIT, click: editFormat }, title: '', width: '80px' });
    getColumnsGridFormat.push({ command: { text: TotalSurvLang.VIEW_FORMAT_LABEL_DELETE, click: deleteFormat }, title: '', width: '80px' });
    jQuery("#grid_formats").kendoGrid({
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
        var dataItem = this.dataItem(jQuery(e.currentTarget).closest("tr"));
        window.location.href = tsurv_url_edit_format.replace('{fid}',dataItem.id);
    }
}