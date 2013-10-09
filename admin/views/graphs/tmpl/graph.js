jQuery(document).on('ready', init_graph_js);

function init_graph_js() {

    var sfilter = '';
    
    var message = jQuery("#message");
    if (!message.data("kendoWindow")) {
        message.kendoWindow({
            width: "300px",
            title: TotalSurvLang.COM_TOTALSURV_LABEL_MESSAGE,
            actions: ["Close"],
            modal: true
        });
    }

    jQuery('.filter-option').kendoDropDownList();

    var updateSFilter = function() {
        sfilter = '&fid='+data_filter.fid+'&dstart='+data_filter.dstart+'&dend='+data_filter.dend+'';
        if( typeof(data_filter.question_option) != 'undefined') {
            sfilter += '&question_option[id]='+data_filter.question_option.id+'&question_option[option]='+data_filter.question_option.option;        
        }
    };
    var change_option = function(){
        var _this = jQuery(this);
        var op_id = _this.val();
        var qo_id = _this.attr('qoption');

        if(typeof(data_filter.question_option) != 'undefined' && qo_id == data_filter.question_option.id) {
            data_filter['question_option'] = {
                id: qo_id,
                option: op_id
            };
        }
        updateSFilter();
    };
    var change_filter_questions_option = function() {
        var _this = jQuery(this);
        var check = _this.prop("checked");
        fqo.prop("checked", false);
        _this.prop("checked", check);

        if(_this.prop("checked")) {
            var qo_id = _this.val();
            data_filter['question_option'] = {
                id: qo_id,
                option: jQuery('#option'+qo_id).val()
            };
        } else {
            delete data_filter['question_option'];
        }
        updateSFilter();
    };
    var startChange = function() {
        var startDate = start.value(),
        endDate = end.value();

        if (startDate) {
            startDate = new Date(startDate);
            startDate.setDate(startDate.getDate());
            end.min(startDate);
        } else if (endDate) {
            start.max(new Date(endDate));
        } else {
            endDate = new Date();
            start.max(endDate);
            end.min(endDate);
        }
        data_filter.dstart = jQuery("#start").val();
        updateSFilter();
    };
    var endChange = function() {
        var endDate = end.value(),
        startDate = start.value();

        if (endDate) {
            endDate = new Date(endDate);
            endDate.setDate(endDate.getDate());
            start.max(endDate);
        } else if (startDate) {
            end.min(new Date(startDate));
        } else {
            endDate = new Date();
            start.max(endDate);
            end.min(endDate);
        }
        data_filter.dend = jQuery("#end").val();
        updateSFilter();
    };
    var load_result_search = function() {
            
        var url_result = "index.php?option=com_totalsurv&view=graphs&layout=chart&gtype="+graphtype+"&tmpl=component&pgraph[fid]="+data_filter.fid+"&pgraph[dstart]="+data_filter.dstart+"&pgraph[dend]="+data_filter.dend+"";
        if(typeof(data_filter.question_option) != "undefined") {
            url_result += "&pgraph[questionoption]="+data_filter.question_option.id+"&pgraph[option]="+data_filter.question_option.option+"";
        }
        jQuery("#graph").attr('src', url_result);
        
    };

    updateSFilter();

    var fqo = jQuery('.filter-question-option');

    
    fqo.on('change',change_filter_questions_option);

    
    jQuery('.filter-option').on('change',change_option);

    var start = jQuery("#start").kendoDatePicker({
        change: startChange,
        format: "yyyy-MM-dd"
    }).data("kendoDatePicker");

    var end = jQuery("#end").kendoDatePicker({
        change: endChange,
        format: "yyyy-MM-dd"
    }).data("kendoDatePicker");

    start.max(end.value());
    end.min(start.value());

    jQuery('#load-results').on('click',load_result_search);

}

