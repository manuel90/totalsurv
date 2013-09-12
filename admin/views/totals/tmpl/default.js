jQuery(document).on('ready', init_list_formats);

function init_list_formats() {

    var viewTotals = function(e) {
        e.preventDefault();
        var dataItem = this.dataItem(jQuery(e.currentTarget).closest("tr"));
        window.location.href = crudServiceBaseUrl + "&view=totals&layout=totals&fid="+dataItem.id;
    };

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
                    name: { type: "string", validation: { required: true, min: 1} }
                }
            }
        }
    });
    getColumnsGridFormat.push({ command: { text: TotalSurvLang.VIEW_TOTAL_LABEL_BTN_SHOW_TABLE_RESULTS, click: viewTotals }, title: '', width: '80px' });
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
    
}