jQuery(document).on('ready',init_options);
function init_options() {
    /**
     * Scripts Questions
     *****/
    var dataSource = new kendo.data.DataSource({
        transport: {
            read:  {
                url: crudServiceBaseUrl + "&task=optionquestion.ajaxOptionsByQuestion&qo_id="+question_option,
                dataType: "json"
            },
            update: {
                url: crudServiceBaseUrl + "&task=optionquestion.ajaxupdate",
                dataType: "json"
            },
            destroy: {
                url: crudServiceBaseUrl + "&task=optionquestion.ajaxdelete",
                dataType: "json"
            },
            create: {
                url: crudServiceBaseUrl + "&task=optionquestion.ajaxnew&qo_id="+question_option,
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
                    id: { editable: false, nullable: true },
                    name: { validation: { required: true } },
                    published: { type: "boolean" },
                    ordered: { type: "number" }
                }
            }
        }
    });
    getColumnsGridOptionsQuestion.push({ command: ["edit", "destroy"], title: "&nbsp;", width: "160px" });
	jQuery("#grid-options").kendoGrid({
        dataSource: dataSource,
        pageable: true,
        height: 350,
        filterable: true,
        toolbar: ["create"],
        columns: getColumnsGridOptionsQuestion,
        editable: "inline"
    });
}