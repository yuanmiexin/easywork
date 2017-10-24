<?php if (!defined('THINK_PATH')) exit();?><script language="javascript">var atit;
$(function(){
	var np = Number('<?php echo ($show_np); ?>');
	var cw = $("#projectCon").width();
	var th = $(".top").height();
	th = 111-th;
	var wh = $(window).height()-th;
	var ch = $("body").height();
	var pr = '<?php echo $page_row ?>';
	var pn = false;
	if(pr>0){
		pn = true;
	}
	$("#Project").datagrid({
		//title:'项目列表',
		height:wh,
		autoRowHeight:false,
		singleSelect:true,
		striped:true,
		rownumbers:true,
		pagination:pn,
		sortName:'t1_new_status',
		sortOrder:'asc',
		showFooter:true,
		prototype:true,
		pageSize:pr,
		pageList:[30,50,80,100,100000000000],
		method:'get',
		url:'__ACTION__/json/1',
		fitColumns:Number('<?php echo (C("DG_FIT_COLUMNS")); ?>'),
		nowrap:Number('<?php echo (C("DATA_NOWRAP")); ?>'),
		selectOnCheck:false,
		checkOnSelect:true,
		onBeforeLoad: function(){  
			 if($("#ProjectCon .datagrid-toolbar table tr #sersSearchProjectItemtype").length==0){
				 var grid = $("#ProjectCon .datagrid-toolbar table tr");  
				 var date = '<td>'+$("#selectInputProject").html()+'</td>';    
				 grid.append(date); 
				 
				 $("#sersSearchProjectStatus").change(function(){
					var idd = $(this).val();
					$.post('__URL__/change/act/status', {val:idd}, function(data){
						$("#Project").datagrid('reload');
					});
				});
				
				$("#sersSearchProjectItemtype").change(function(){
					var idd = $(this).val();
					$.post('__URL__/change/act/itemtype', {val:idd}, function(data){
						$("#Project").datagrid('reload');
					});
				});
				
				$('#ProjectSearch').searchbox({   
					searcher:function(value,name){
						$.post('__URL__/change/act/'+name+'/mode/like', {val:value}, function(data){
							$("#Project").datagrid('reload');
						});
					},   
					menu:'#ProjectSearchSon',   
					prompt:'请输入关键字'  
				 }); 
			 }
			 
			 /*if($("#ProjectCon .datagrid-toolbar #ProjectSearch").length==0){
				 var toolbar = $("#ProjectCon .datagrid-toolbar");
				 toolbar.css({
					 "overflow":"hidden"
				 });
				 var tooltable = $("#ProjectCon .datagrid-toolbar table");
				 tooltable.css({
					 "float":"left"
				 });
				 var tw = toolbar.width();
				 tooltable.addClass("tname");
				 var sw = $("#ProjectCon .datagrid-toolbar .tname").width();
				 //alert(sw);
				 
				 var ww = tw-sw-8;
				 var date = '<table cellspacing="0" cellpadding="0" style="width:'+ww+'px; height:28px; float: left;" class="pname"><tr><td align="right">'+$("#selectInputProject2").html()+'</td></tr></table>';    
				 toolbar.append(date); 
				 
				 $('#ProjectSearch').searchbox({   
					searcher:function(value,name){
						$.post('__APP__?g=<?php echo GROUP_NAME; ?>&m=<?php echo MODULE_NAME; ?>&a=change&act='+name+'&mode=like', {val:value}, function(data){
							$("#Project").datagrid('reload');
						});
					},   
					menu:'#ProjectSearchSon',   
					prompt:'请输入关键字'  
				 }); 
			 }*/
		},
		/*onHeaderContextMenu:function(e,f){
			if(f!='pro_progress'){
				$("#searchProject").dialog({
					title:'快速搜索',
					resizable:true,
					width:480,
					height:80,
					href:'__APP__?g=<?php echo GROUP_NAME; ?>&m=<?php echo MODULE_NAME; ?>&a=search&field='+f
				});
			}
			e.preventDefault();
		},*/
		onDblClickRow:function(e,rowIndex,rowData){
			//var se = $("#Project").datagrid('getSelected')
			var se = $("#Project").datagrid('getChecked');
			var se_len = se.length;
			var idd = se[0]['id'];
			var idn = se[0]['name'];
			//alert(idd);
			var ishas = $("#rightTabs").tabs('exists',atit);
			if(!ishas){
				//alert('__URL__/detail/id/'+idd);
				$("#rightTabs").tabs('add',{
					id : -2,
					title : '项目-'+idn,
					href : '__URL__/detail/id/'+idd,
					closable : true,
				});
				atit = '项目-'+idn;
			}else{
				if(idd!=atit){
					var tab = $("#rightTabs").tabs('getTab',atit);
					$("#rightTabs").tabs('update',{
						tab:tab,
						options:{
							title : '项目-'+idn,
							href : '__URL__/detail/id/'+idd,
							closable : true,
						} 
					});
					atit = '项目-'+idn;
					$("#rightTabs").tabs('select',atit);
				}else{
					$("#rightTabs").tabs('select',atit);
				}
				
			}
		},
		onUncheck:function(i,d){
			$("#Project").datagrid('unselectRow',i);
		},
		toolbar:[{
		iconCls: 'icon-add',
			text : '新增',
			handler: function(){
				$("#addProject").dialog({
					title:'新增项目',
					resizable:true,
					width:920,
					height:430,
					href:'__URL__/add/act/add',
					onOpen:function(){
						cancel['Project'] = $(this);
					},
					onClose:function(){
						//$(this).dialog('destroy');
						//$("#Project").datagrid('reload');
						cancel['Project'] = null;
					}
				});
			}
		},'-',{
			iconCls: 'icon-edit',
			text : '编辑',
			handler: function(){
				//var se = $("#Project").datagrid('getSelected');
				var se = $("#Project").datagrid('getChecked');
				var se_len = se.length;
				var idd = se[0]['id'];
				if(se_len==1){
					$("#addProject").dialog({
						title:'编辑项目',
						resizable:true,
						width:920,
						height:430,
						href:'__URL__/add/act/edit/id/'+idd,
						onOpen:function(){
							cancel['Project'] = $(this);
						},
						onClose:function(){
							//$(this).dialog('destroy');
							//$("#Project").datagrid('reload');
							cancel['Project'] = null;
						}
					});
				}else if(se_len>1){
					$.messager.alert('提示','不能同时编辑两行数据！','warning');
				}
			}
		},'-',{
			iconCls: 'icon-cancel',
			text : '删除',
			handler: function(){
				var se = $("#Project").datagrid('getChecked');
				var s = "";  
				for (var property in se) {  
					s = s + se[property]['id']+',' ;  
				}
				if(s){
					$.messager.confirm('提示','确定删除吗！',function(r){
						if(r==true){
							$.messager.progress();
							$.post('__URL__/del',{id:s}, function(data){
								$.messager.progress('close');
								if(data==1){
									$.messager.alert('提示','删除数据成功！','info',function(){
										$("#Project").datagrid('reload');
									});
								}else if(data==0){
									$.messager.alert('提示','删除数据失败！','warning');
								}else{
									$.messager.alert('提示','您没有删除权限','warning');
								}
							});
						}
					});
				}
			}
		},'-',{
			iconCls: 'icon-search',
			text : '高级搜索',
			handler: function(){
				$("#searchProject").dialog({
					title:'高级搜索',
					resizable:true,
					width:500,
					height:220,
					href:'__URL__/advsearch'
				});
			}
		},'-',{
			iconCls: 'icon-reload',
			text : '重载',
			handler: function(){
				$.get('__URL__/clear', function(data){
					$("#sersSearchProjectStatus").val(0);
					$("#ProjectSearch").searchbox('setValue','');
					$("#sersSearchProjectItemtype").val(0);
					$("#Project").datagrid('reload');
				});
			}
		}],
		frozenColumns:[[
			{checkbox:true},
			{field:'name',title:'项目名称',width:200,sortable:true}
		]],
		columns:[[  
			{field:'app_handler',title:'负责人',width:55,sortable:true},
			{field:'t1_new_itemtype',title:'类型',width:100,sortable:true},
			{field:'description',title:'说明',width:290},
			{field:'pro_progress',title:'完成进度',width:260},
			{field:'t1_new_status',title:'状态',width:70,sortable:true},
			{field:'pro_creator',title:'创建人',width:55,sortable:true},
			{field:'pro_creatdate',title:'创建日期',width:90,sortable:true}
		]]
	});
	
	
	 var dataview = '<?php echo C("DATAGRID_VIEW") ?>';
	 if(dataview!='0'){
		var pager = $('#Project').datagrid('getPager');
		pager.pagination({
			layout: 'list,sep,first,prev,sep,manual,sep,next,last,sep,refresh',
			displayMsg: '共{total}记录'
		});
	 }
	
	$("#rightTabs").tabs({
		onClose:function(t,i){
			$.ajaxSetup({  
				async : false  
			});
			if(t=='项目列表'){
				$.get('__URL__/clear', function(data){});
			}	
			$.ajaxSetup({  
				async : true  
			});
		}
	});
	
	$("#rightTabs").tabs('select','项目列表');
});
</script><div id="ProjectCon" class="con" onselectstart="return false;" style="-moz-user-select:none;"><?php if(C('DATAGRID_VIEW')!='0'){ ?><table id="Project" data-options="view:<?php echo C("DATAGRID_VIEW") ?>"></table><?php }else{ ?><table id="Project"></table><?php } ?></div><div id="searchProject"></div><div id="addProject"></div><div id="selectInputProject" style="display:none"><span class="datagrid-btn-separator-nofloat"  style="margin-right:2px;"></span><input id="ProjectSearch" AUTOCOMPLETE="off" style="width:280px;"></input><div id="ProjectSearchSon" style="width:120px"><div data-options="name:'name'">项目名称</div><div data-options="name:'app_handler'">负责人</div><div data-options="name:'pro_creator'">创建人</div></div><span class="datagrid-btn-separator-nofloat"  style="margin-right:1px;"></span><select id="sersSearchProjectItemtype" ><option value="0">所有类型</option><?php if(is_array($iinfo)): foreach($iinfo as $key=>$t): ?><option value="<?php echo ($t["id"]); ?>"><?php echo ($t["text"]); ?></option><?php endforeach; endif; ?></select><span class="datagrid-btn-separator-nofloat"  style="margin-right:1px;"></span><select id="sersSearchProjectStatus" ><option value="0">所有状态</option><?php if(is_array($sinfo)): foreach($sinfo as $key=>$t): ?><option value="<?php echo ($t["id"]); ?>"><?php echo ($t["text"]); ?></option><?php endforeach; endif; ?></select></div>