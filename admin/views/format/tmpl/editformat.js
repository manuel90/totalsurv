Joomla.submitbutton = function(pressbutton) {

    var validator = jQuery("#admin-form-totalsurv").kendoValidator().data("kendoValidator");
    var status = jQuery("#msg-edit-format");

    if(pressbutton == 'format.save' || pressbutton == 'format.apply') {
        if (!validator.validate()) {
            status.text("Faltan datos por ingresar.").removeClass("valid").addClass("invalid");
            return;
        }
    }
    
    submitform(pressbutton);

};

jQuery(document).on('ready', init_editformat_js);
function init_editformat_js() {

    var editOptions = function(e) {
        e.preventDefault();
        var dataItem = this.dataItem(jQuery(e.currentTarget).closest("tr"));
        var qo_id = dataItem.id;
        

        if(dataItem.type != 1 && dataItem.type != 2) {
            var kendoWindow = dialog.data("kendoWindow");
            kendoWindow.refresh(crudServiceBaseUrl + "&view=optionquestion&tmpl=component&qo_id="+qo_id);
            kendoWindow.center();
            kendoWindow.open();
        }
    };

    jQuery("#format_text_info_value").kendoEditor({
        tools: ["bold", "italic", "underline","justifyLeft", "justifyCenter", "justifyRight", "justifyFull"]
    });

    jQuery("#format_range_low").kendoNumericTextBox({format: "#",min: 1,step: 1});
    jQuery("#format_range_medium").kendoNumericTextBox({format: "#",min: 1,step: 1});
    jQuery("#format_range_high").kendoNumericTextBox({format: "#",min: 1,step: 1});
    jQuery("#format_range_very_high").kendoNumericTextBox({format: "#",min: 1,step: 1});

    jQuery("#format_enable_send_info").kendoDropDownList();

    jQuery("#format_published").kendoDropDownList();
    jQuery("#format_commented").kendoDropDownList();

    jQuery("#format_minvalue").kendoNumericTextBox({format: "#",min: 1,max: 5,step: 1});
    jQuery("#format_maxvalue").kendoNumericTextBox({format: "#",min: 1,max: 5,step: 1});

    jQuery("#format_date_create").kendoDatePicker({
        format: "yyyy-MM-dd"
    });

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
    jQuery("#grid-questions").kendoGrid({
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
    getColumnsGridQuestionOption.push({ command: { text: TotalSurvLang.LAYOUT_EDIT_UPDATE_OPTIONS, click: editOptions }, title: '', width: '120px' });
    jQuery("#grid-questionsoption-before").kendoGrid({
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
    jQuery("#grid-questionsoption-after").kendoGrid({
        dataSource: dataSource,
        pageable: true,
        height: 200,
        filterable: true,
        toolbar: ["create"],
        columns: getColumnsGridQuestionOption,
        editable: "popup"
    });
    var dialog = jQuery('#dialog-update-options');
    dialog.kendoWindow({
        width: "615px",
        height: "400px",
        title: "Editar Opciones",
        modal: true,
        visible: false
    });
    /**
     * END Scripts Questions After
     *********************************************************************************/
}