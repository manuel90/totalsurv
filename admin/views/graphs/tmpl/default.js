jQuery(document).on('ready',init_graph);
function init_graph() {
    var list_graphtype = jQuery("#list_graphtype");
    if(list_graphtype.length > 0) {
        var dataTypes = [
            {
                "Type": "graphpie",
                "TypeName": TotalSurvLang.VIEW_TOTALSURV_LABEL_LAYOUT_GRAPHPIE,
                "TypeImage": "graph-pie"
            },
            {
                "Type": "graphbar",
                "TypeName": TotalSurvLang.VIEW_TOTALSURV_LABEL_LAYOUT_GRAPHBAR,
                "TypeImage": "graph-bar"
            }
        ];
        var changeGraphType = function () {
            var selected = jQuery.map(this.select(), function(item) {
                return dataTypes[jQuery(item).index()].Type;
            });
            graphtype = selected.join("");
        };
        list_graphtype.kendoListView({
            dataSource: dataTypes,
            selectable: true,
            change: changeGraphType,
            template: kendo.template(jQuery("#template_type").html())
        });
        
        if(graphtype != "none") {
            var listView = list_graphtype.data("kendoListView");
            listView.select(document.getElementById("id_"+graphtype));
        }
        

        var message = jQuery("#message");
        if (!message.data("kendoWindow")) {
            message.kendoWindow({
                width: "300px",
                title: TotalSurvLang.COM_TOTALSURV_LABEL_MESSAGE,
                actions: ["Close"],
                modal: true
            });
        }
    }
    var goToGraph = function(e) {
        e.preventDefault();

        if(graphtype == 'none') {
            var dialog = message.data("kendoWindow");
            dialog.center();
            dialog.open();
        } else {
            var dataItem = this.dataItem(jQuery(e.currentTarget).closest("tr"));
            window.location.href = crudServiceBaseUrl + "&view=graphs&layout=graph&gtype="+graphtype+"&fid="+dataItem.id;
        }
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
    getColumnsGridFormat.push({ command: { text: TotalSurvLang.VIEW_GRAPHS_LABEL_BTN_GRAPH, click: goToGraph }, title: '', width: '80px' });
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