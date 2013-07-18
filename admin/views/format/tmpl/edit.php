<?php
/**
 * @module		com_totalsurv
 * @author-name Manuel L. Lara
 * @adapted by  Manuel L.Lara
 * @copyright	Copyright (C) 2012 Manuel L. Lara
 * @license		GNU/GPL, see http://www.gnu.org/licenses/old-licenses/gpl-2.0.txt
 */

// No direct access
defined('_JEXEC') or die('Restricted access');
jimport( 'joomla.html.html.select' );


$options = array();

$options[] = JHTML::_('select.option','1',JText::_('COM_TOTALSURV_YES'));
$options[] = JHTML::_('select.option','0',JText::_('COM_TOTALSURV_NO'));

?>
<form action="<?php echo URL_HOME_ADMIN.'&view=format&layout=edit&fid='.(int) $this->format['id']; ?>" method="post" name="adminForm" id="adminForm" class="form-validate form-totalsurv">
	<div id="inputs-format" class="column">
        <h4><?php echo JText::_('COM_TOTALSURV_REQUIRED'); ?></h4>
        <div class="row-form">
            <div class="label">
                <label for="format_code"><?php echo JText::_('VIEW_FORMAT_LABEL_CODE'); ?></label>
            </div>
            <div class="input">
                <input type="text" id="format_code" value="<?php echo $this->format['code']; ?>" name="format_code" class="k-textbox required" />
            </div>
        </div>
        <div class="row-form">
            <div class="label">
                <label for="format_version"><?php echo JText::_('VIEW_FORMAT_LABEL_VERSION'); ?></label>
            </div>
            <div class="input">
                <input type="text" id="format_version" value="<?php echo $this->format['version']; ?>" name="format_version" class="k-textbox required" />
            </div>
        </div>
        <div class="row-form">
            <div class="label">
                <label for="format_name"><?php echo JText::_('VIEW_FORMAT_LABEL_NAME'); ?></label>
            </div>
            <div class="input">
                <input type="text" id="format_name" value="<?php echo $this->format['name']; ?>" name="format_name" class="k-textbox required" />
            </div>
        </div>
        <div class="row-form">
            <div class="label">
                <label for="format_publishing"><?php echo JText::_('VIEW_FORMAT_LABEL_PUBLISHING'); ?></label>
            </div>
            <div class="input">
                <?php echo JHtml::_('select.genericlist',$options, 'format_publishing', 'class="example"', 'value', 'text', $this->format['published'], 'format_publishing'); ?>
            </div>
        </div>
        <div class="row-form">
            <div class="label">
                <label for="format_commented"><?php echo JText::_('VIEW_FORMAT_LABEL_COMMENTED'); ?></label>
            </div>
            <div class="input">
                <?php echo JHtml::_('select.genericlist',$options, 'format_commented', 'class="example"', 'value', 'text', $this->format['commented'], 'format_commented'); ?>
            </div>
        </div>
        <div class="row-form">
            <div class="label">
                <label for="format_minvalue"><?php echo JText::_('VIEW_FORMAT_LABEL_MIN_VALUE'); ?></label>
            </div>
            <div class="input">
                <input type="text" id="format_minvalue" value="<?php echo $this->format['min_value']; ?>" name="format_minvalue" class="required" />
            </div>
        </div>
        <div class="row-form">
            <div class="label">
                <label for="format_maxvalue"><?php echo JText::_('VIEW_FORMAT_LABEL_MAX_VALUE'); ?></label>
            </div>
            <div class="input">
                <input type="text" id="format_maxvalue" value="<?php echo $this->format['max_value']; ?>" name="format_maxvalue" class="required" />
            </div>
        </div>
    </div>
    <div id="panel-edit-format" class="column">
        <h3><?php echo JText::_('LAYOUT_EDIT_TITLE_QUESTIONOPTION_BEFORE'); ?></h3>
        <div id="grid-questionsoption-before"></div>
        <h3><?php echo JText::_('LAYOUT_EDIT_TITLE_QUESTION'); ?></h3>
        <div id="grid-questions"></div>
        <h3><?php echo JText::_('LAYOUT_EDIT_TITLE_QUESTIONOPTION_AFTER'); ?></h3>
        <div id="grid-questionsoption-after"></div>
    </div>
	<input type="hidden" name="task" value="" />
	<?php echo JHtml::_('form.token'); ?>
    <script type="text/javascript">
        var fid = '<?php echo $this->format['id'];?>';
        $(document).on('ready', function(){
            $("#format_publishing").kendoDropDownList();
            $("#format_commented").kendoDropDownList();

            $("#format_minvalue").kendoNumericTextBox({format: "#",min: 1,max: 5,step: 1});
            $("#format_maxvalue").kendoNumericTextBox({format: "#",min: 1,max: 5,step: 1});

            var crudServiceBaseUrl = "<?php echo URL_HOME_ADMIN; ?>";

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
            $("#grid-questions").kendoGrid({
                dataSource: dataSource,
                pageable: true,
                height: 430,
                filterable: true,
                toolbar: ["create"],
                columns: [
                    <?php echo TotalSurvCustomFunctions::getColumnsGridQuestion(true); ?>,
                    { command: ["edit", "destroy"], title: "&nbsp;", width: "160px" }],
                editable: "popup"
            });
            /**
             * END Scripts Questions
             *********************************************************************************/

            /**
             * Scripts Questions Before
             *****/
            var dialog = $('#dialog');
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
            $("#grid-questionsoption-before").kendoGrid({
                dataSource: dataSource,
                pageable: true,
                height: 200,
                filterable: true,
                toolbar: ["create"],
                columns: [
                    <?php echo TotalSurvCustomFunctions::getColumnsGridQuestionOption(true); ?>,
                    { command: ["edit", "destroy"], title: "&nbsp;", width: "160px" },
                    { command: { text: "<?php echo JText::_('Editar Opciones'); ?>", click: editOptions }, title: '', width: '120px' }
                ],
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
                columns: [
                    <?php echo TotalSurvCustomFunctions::getColumnsGridQuestionOption(true); ?>,
                    { command: ["edit", "destroy"], title: "&nbsp;", width: "160px" },
                    { command: { text: "<?php echo JText::_('Editar Opciones'); ?>", click: editOptions }, title: '', width: '120px' }
                ],
                editable: "popup"
            });


            function editOptions(e) {
                e.preventDefault();
                var dataItem = this.dataItem($(e.currentTarget).closest("tr"));
                var qo_id = dataItem.id;
                
                dialog.kendoWindow({
                    width: "615px",
                    height: "400px",
                    title: "Editar Opciones",
                    content: crudServiceBaseUrl + "&view=optionquestion&tmpl=component&qo_id="+qo_id,
                    modal: true
                });
                dialog.data("kendoWindow").center();
            }

            /**
             * END Scripts Questions After
             *********************************************************************************/


        });
    </script>
</form>
<div id="dialog"></div>