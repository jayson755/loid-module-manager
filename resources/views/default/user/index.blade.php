@extends($view_base_prefix . '/layouts/child')
@section('css')
<link href="{{asset_site($base_resource, 'plugin', 'jqgrid/css/ui.jqgrid.css')}}" rel="stylesheet">
@endsection

@section('content')
<div class="row">
    <div class="col-sm-12">
        <div class="ibox float-e-margins">
            <div class="ibox-content">
                <div class="row">
                    <div class="col-sm-12" style="height: 25px;">
                        <div class="ibox-tools">
                            <div class="adm-fa-hover"><a href="javascript:window.location.href='{{route('manage.user')}}'"><i class="fa fa-refresh"></i></a></div>
                        </div>
                    </div>
                </div>
                <div class="row" id="jqGridRow">
                    <div class="jqGrid_wrapper">
                        <table id="table_list_2"></table>
                        <div id="pager_list_2"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<script type="text/javascript" src="{{asset_site($base_resource, 'plugin', 'jqgrid/js/jquery.jqGrid.min.js')}}"></script>
<script type="text/javascript" src="{{asset_site($base_resource, 'plugin', 'jqgrid/js/i18n/grid.locale-cn.js')}}"></script>
<script type="text/javascript" src="{{asset_site($base_resource, 'js', 'jqgrid-custom.js')}}"></script>
<script type="text/javascript">
var statusJson = {"1":"正常","0":"禁用"};
$(document).ready(function() {
	$("#table_list_2").jqGrid({
        url: "{{route('manage.user.list', ['param'=>'type'])}}",
		editurl: "{{route('manage.user.modify')}}",
		datatype: "json",
		height:$(window).height() - 210,
		autowidth: true,
		shrinkToFit: true,
		rowNum: {{$rows}},
		rowList: [10, 20, 30],
        sortname: 'id',
        sortorder: 'desc',
		loadComplete : function(xhr){ //请求成功事件
			try{
				$('.ui-jqdialog-titlebar-close').click();
			}catch(e){}
		},
		colNames: ["序号", "登录名", "密码", "邮箱", "创建时间"],
		colModel: [
			{name:"id",index: "id",width: 60,sorttype: "int",editable:true,align: "center",search: true,hidden:true},
			
			{name:"name",index:"name",align: "center",editable:true,width: 90,search: true},
			
			{name:"password",index:"password",align: "center",editable:true,edittype:'password',editrules:{edithidden:true},width: 90,search: false, hidden:true},
			
			{name:"email",index:"email",align: "center",editable:true,edittype:'text',editrules:{edithidden:true,required:true},width: 90,search: true},
			
			{name:"created_at",index:"created_at",align: "center",editable:false,width: 90,search: true},
			
			//{name:"role",index:"role",align:"center",editable:true,edittype:'select',editrules:{edithidden:true,required:true},
			//	editoptions : {dataUrl:"{{route('api.role')}}"},
			//	width: 90,search: false, sortable:false
			//},
		],
		pager: "#pager_list_2",
		viewrecords: true,
        pgbuttons:true,
		hidegrid: false
	}).navGrid('#pager_list_2', {edit: true, add: true, del: false, search:true,searchtext:''},{
		editCaption : "修改",
		top:50,
		left:($(document).innerWidth() - 400) / 5 * 2,
		width:500,
		jqModal : true,  
		reloadAfterSubmit : true,  
		afterShowForm : function(form) {
            $("#name").attr('disabled', true);
			$("#password").attr('placeholder', '不修改密码不输入');
		},  
		afterSubmit: function(response, postdata) {
			if (response.responseJSON.code == 0) {
				return [false, response.responseJSON.msg];
			} else {
				window.top._toastr(response.responseJSON.msg);
				return [true, '', ''];
			}
		}
	},{
		addCaption : "新增",
		top:50,
		left:($(document).innerWidth() - 400) / 5 * 2,
		width:500,
		modal:true,
		jqModal: true,
		reloadAfterSubmit : true,
		afterShowForm : function(form) {
			addporp(form);
		},  
		afterSubmit: function(response, postdata) {
			if (response.responseJSON.code == 0) {
				return [false, response.responseJSON.msg];
			} else {
				window.top._toastr(response.responseJSON.msg);
				return [true, '', ''];
			}
		}
	},{
		caption: "删除",  
		msg: "确定删除所选记录？",  
		bSubmit: "删除",  
		bCancel: "取消",
		left:($(document).innerWidth() - 400) / 5 * 2,
		afterSubmit: function(response, postdata) {
			if (response.responseJSON.code == 0) {
				return [false, response.responseJSON.msg];
			} else {
				return [true, '', ''];
			}
		}
	},{
		caption : "搜索",
		top:50,
		left:($(document).innerWidth() - 400) / 5 * 2,
		width:500,
		multipleSearch:true
	});
});
//设置宽度
jQuery("#table_list_2").setGridWidth($("#jqGridRow").innerWidth(), true);
</script>
@endsection