$(document).on('ready', function(){
    $("#format_publishing").kendoDropDownList();
    $("#format_commented").kendoDropDownList();

    $("#format_minvalue").kendoNumericTextBox({format: "#",min: 1,max: 5,step: 1});
    $("#format_maxvalue").kendoNumericTextBox({format: "#",min: 1,max: 5,step: 1});

    

    /**
     * Scripts Questions
     *****/
    var dataSource = new kendo.data.DataSource({
        transport: {
            read:  {
                url: crudServiceBaseUrl + "&task=question.ajaxQuestionByFormat&fid="+fid,
                dataType: "json"
            },
            update: {
                url: crudServiceBaseUrl + "&task=question.ajaxupdate",
                dataType: "json"
            },
            destroy: {
                url: crudServiceBaseUrl + "&task=question.ajaxdelete",
                dataType: "json"
            },
            create: {
                url: crudServiceBaseUrl + "&task=question.ajaxnew&fid="+fid,
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
    getColumnsGridQuestion.push({ command: ["edit", "destroy"], title: "&nbsp;", width: "160px" });
    $("#grid-questions").kendoGrid({
        dataSource: dataSource,
        pageable: true,
        height: 430,
        filterable: true,
        toolbar: ["create"],
        columns: getColumnsGridQuestion,
        editable: "popup"
    });
    /**
     * END Scripts Questions
     *********************************************************************************/

    /**
     * Scripts Questions Before
     *****/
    dataSource = new kendo.data.DataSource({
        transport: {
            read:  {
                url: crudServiceBaseUrl + "&task=questionoption.ajaxQuestionsOptionByFormat&position_survey=before&fid="+fid,
                dataType: "json"
            },
            update: {
                url: crudServiceBaseUrl + "&task=questionoption.ajaxupdate",
                dataType: "json"
            },
            destroy: {
                url: crudServiceBaseUrl + "&task=questionoption.ajaxdelete",
                dataType: "json"
            },
            create: {
                url: crudServiceBaseUrl + "&task=questionoption.ajaxnew&fid="+fid,
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
                    type: { type: "number", validation: { min: 1, max: 5 } },
                    ordered: { type: "number" }
                }
            }
        }
    });
    getColumnsGridQuestionOption.push({ command: ["edit", "destroy"], title: "&nbsp;", width: "160px" });
    getColumnsGridQuestionOption.push({ command: { text: Joomla.JText.strings.LAYOUT_EDIT_UPDATE_OPTIONS, click: editOptions }, title: '', width: '120px' });
    $("#grid-questionsoption-before").kendoGrid({
        dataSource: dataSource,
        pageable: true,
        height: 200,
        filterable: true,
        toolbar: ["create"],
        columns: getColumnsGridQuestionOption,
        editable: "popup"
    });
    /**
     * END Scripts Questions Before
     *********************************************************************************/

    /**
     * Scripts Questions After
     *****/
    dataSource = new kendo.data.DataSource({
        transport: {
            read:  {
                url: crudServiceBaseUrl + "&task=questionoption.ajaxQuestionsOptionByFormat&position_survey=after&fid="+fid,
                dataType: "json"
            },
            update: {
                url: crudServiceBaseUrl + "&task=questionoption.ajaxupdate",
                dataType: "json"
            },
            destroy: {
                url: crudServiceBaseUrl + "&task=questionoption.ajaxdelete",
                dataType: "json"
            },
            create: {
                url: crudServiceBaseUrl + "&task=questionoption.ajaxnew&fid="+fid,
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
                    type: { type: "number", validation: { min: 1, max: 5 } },
                    ordered: { type: "number" }
                }
            }
        }
    });
    $("#grid-questionsoption-after").kendoGrid({
        dataSource: dataSource,
        pageable: true,
        height: 200,
        filterable: true,
        toolbar: ["create"],
        columns: getColumnsGridQuestionOption,
        editable: "popup"
    });
    var dialog = $('#dialog-update-options');
    dialog.kendoWindow({
        width: "615px",
        height: "400px",
        title: "Editar Opciones",
        modal: true,
        visible: false
    });

    function editOptions(e) {
        e.preventDefault();
        var dataItem = this.dataItem($(e.currentTarget).closest("tr"));
        var qo_id = dataItem.id;
        

        if(dataItem.type != 1 && dataItem.type != 2) {
            var kendoWindow = dialog.data("kendoWindow");
            kendoWindow.refresh(crudServiceBaseUrl + "&view=optionquestion&tmpl=component&qo_id="+qo_id);
            kendoWindow.center();
            kendoWindow.open();
        }
    }

    /**
     * END Scripts Questions After
     *********************************************************************************/


});