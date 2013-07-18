<div id="content-options">
	<div id="grid-options"></div>
	<script type="text/javascript">
		jQuery(document).on('ready',init_options);
		function init_options() {

			var crudServiceBaseUrl = "<?php echo URL_HOME_ADMIN; ?>";
			var qo_id = "<?php echo $this->qo_id; ?>";
            /**
             * Scripts Questions
             *****/
            var dataSource = new kendo.data.DataSource({
                transport: {
                    read:  {
                        url: crudServiceBaseUrl + "&task=optionquestion.ajaxOptionsByQuestion&qo_id="+qo_id,
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
                        url: crudServiceBaseUrl + "&task=optionquestion.ajaxnew&qo_id="+qo_id,
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
			$("#grid-options").kendoGrid({
                dataSource: dataSource,
                pageable: true,
                height: 350,
                filterable: true,
                toolbar: ["create"],
                columns: [
                    <?php echo TotalSurvCustomFunctions::getColumnsGridOptionsQuestion(true); ?>,
                    { command: ["edit", "destroy"], title: "&nbsp;", width: "160px" }],
                editable: "inline"
            });
		}
	</script>
</div>