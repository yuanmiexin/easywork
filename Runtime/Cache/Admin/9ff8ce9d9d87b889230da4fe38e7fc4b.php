<?php if (!defined('THINK_PATH')) exit();?><script language="javascript">var role = '<?php echo ($role); ?>';
if(role==-2){
	cancel['Project'].dialog('close');
	cancel['Project'] = null;
	$.messager.alert('提示','您没有新增权限！','warning');
}else if(role==-3){
	cancel['Project'].dialog('close');
	cancel['Project'] = null;
	$.messager.alert('提示','您没有编辑权限！','warning');
}

if(!isset(que)){
	var que = new Array();
}
var mc = Number('<?php echo C("MORE_COMY"); ?>');
if(mc){
	var mode = 3;
}else{
	var mode = 2;
}
que['appmail_<?php echo ($uniqid); ?>'] = new acrossClass();
que['appmail_<?php echo ($uniqid); ?>'].act = '__APP__/Public/Mail';
que['appmail_<?php echo ($uniqid); ?>'].show({
	id:'<?php echo ($uniqid); ?>',
	mail:1,
	mode:mode,
	used:'<?php echo ($str); ?>'
});

var acon = $("#addRow<?php echo ($uniqid); ?>").html();

//插行
que['add_<?php echo ($uniqid); ?>'] = new actRow();
que['add_<?php echo ($uniqid); ?>'].boxid = 'addOpt<?php echo ($uniqid); ?>';
que['add_<?php echo ($uniqid); ?>'].content = '<TR>'+acon+'</TR>';

var act = '<?php echo ($act); ?>';
$(function(){
	$("#addFormProject<?php echo ($uniqid); ?>").form('load',{
		'name':'<?php echo $info["name"] ?>',
		'status':'<?php echo $info["status"] ?>',
		'view_state':'<?php echo $info["view_state"] ?>',
		'client_id':'<?php echo $info["client_id"] ?>',
		'app_handler':'<?php echo $info["pro_info"]["app_handler"] ?>',
		'itemtype':'<?php echo $info["itemtype"] ?>',
		'pro_creatdate':'<?php echo $info["pro_info"]["pro_creatdate"] ?>',
	});
	
	$("#name<?php echo ($uniqid); ?>").validatebox({
		required:true,
		validType:'ptext'
	});	
	$("#pro_progress<?php echo ($uniqid); ?>").validatebox({
		required:false,
		validType:'ptext'
	});	
	$("#description<?php echo ($uniqid); ?>").validatebox({
		required:false,
		validType:'ptext'
	});	
	$("#status<?php echo ($uniqid); ?>").combobox({
		url:'__ITEM__/__RUNTIME__/Data/Json/Linkage/xiangmuzhuangtai_data.json',
		editable:false,
		method:'get',
		required:true,
		valueField:'id',
		textField:'text'
	});
	$("#view_state<?php echo ($uniqid); ?>").combobox({
		url:'__ITEM__/__RUNTIME__/Data/Json/Linkage/chakanquanxian_data.json',
		editable:false,
		method:'get',
		required:true,
		valueField:'id',
		textField:'text'
	});
	$("#client_id<?php echo ($uniqid); ?>").combobox({
		url:'__ITEM__/__RUNTIME__/Data/Json/Client_data.json',
		editable:false,
		method:'get',
		required:false,
		valueField:'id',
		textField:'text'
	});
	$("#app_handler<?php echo ($uniqid); ?>").combotree({
		required:true,
		url:'__ITEM__/__RUNTIME__/Data/Json/User_nametree_data.json',
		editable:true,
		method:'get',
		required:true,
		valueField:'id',
		textField:'text',
		keyHandler: {
			query : function(q) {
				queryComboTree(q, "app_handler<?php echo ($uniqid); ?>", 0);
			}
		},
		onBeforeSelect:function(node){
			if(isset(node.children)){
				$("#app_handler<?php echo ($uniqid); ?>").tree("unselect");
			}
		}
	});
	$("#itemtype<?php echo ($uniqid); ?>").combobox({
		required:true,
		url:'__ITEM__/__RUNTIME__/Data/Json/Linkage/xiangmuleixing_data.json',
		editable:false,
		method:'get',
		required:true,
		valueField:'id',
		textField:'text'
	});
	
	if(act=='add'){
		$("#pro_creatdate<?php echo ($uniqid); ?>").datepicker('setValue','<?php echo date("Y-m-d",time()) ?>');
	}
});

function onSubmitProject(idd){
	$.messager.progress();
	$("#toUser"+idd+" option").attr("selected",true);
	$("#addFormProject"+idd).form('submit',{
		url:'__URL__/add/act/add/go/1',
		onSubmit: function(){
			var isValid = $(this).form('validate');
			if (!isValid){
				$.messager.progress('close');
			}
			return isValid;
		},
		success:function(data){
			$.messager.progress('close');
			$("#toUser"+idd+" option").attr("selected",false);
			if(data==1){
				$.messager.alert('提示','新增数据成功！','info',function(){
					var sa = '<?php echo (C("SUBMIT_ACTION")); ?>';
					$("#Project").datagrid('reload');
					if(sa==1){
						cancel['Project'].dialog('close');
						cancel['Project'] = null;
					}
				});
			}else if(data==0){
				$.messager.alert('提示','新增数据失败！','warning');
			}else{
				//alert(data);
				$.messager.alert('提示','您没有新增权限！','warning',function(){
					var sa = '<?php echo (C("SUBMIT_ACTION")); ?>';
					if(sa==1){
						cancel['Project'].dialog('close');
						cancel['Project'] = null;
					}
				});
			}
		}
	});
}

function onUploadProject(idd){
	$.messager.progress();
	$("#toUser"+idd+" option").attr("selected",true);
	var ids = $("#ids"+idd).val();
	$("#addFormProject"+idd).form('submit',{
		url:'__URL__/add/act/edit/go/1/id/'+ids,
		onSubmit: function(){
			var isValid = $(this).form('validate');
			if (!isValid){
				$.messager.progress('close');
			}
			return isValid;
		},
		success:function(data){
			$.messager.progress('close');
			$("#toUser"+idd+" option").attr("selected",false);
			if(data==1){
				$.messager.alert('提示','更新数据成功！','info',function(){
					var sa = '<?php echo (C("SUBMIT_ACTION")); ?>';
					$("#Project").datagrid('reload');
					$("#ProjectDetail").panel('refresh');
					if(sa==1){
						cancel['Project'].dialog('close');
						cancel['Project'] = null;
					}
				});
			}else if(data==0){
				$.messager.alert('提示','更新数据失败！','warning');
			}else{
				//alert(data);
				$.messager.alert('提示','您没有更新权限','warning',function(){
					var sa = '<?php echo (C("SUBMIT_ACTION")); ?>';
					if(sa==1){
						cancel['Project'].dialog('close');
						cancel['Project'] = null;
					}
				});
			}
		}
	});
}

function onResetProject(idd){
	cancel['Project'].dialog('close');
	cancel['Project'] = null;
}
</script><div class="con-tb"><form id="addFormProject<?php echo ($uniqid); ?>" method="post"><table class="infobox" width="100%" border="0" cellspacing="0" cellpadding="0" style="border-collapse: collapse;"><tbody><tr><td width="11%"><label for="name">项目名称</label><input id="ids<?php echo ($uniqid); ?>" type="hidden" value="<?php echo ($id); ?>" /></td><td width="23%"><input name="name" id="name<?php echo ($uniqid); ?>" type="text" size="26" autocomplete="off" /></td><td width="11%"><label for="status">状态</label></td><td width="22%"><input name="status" id="status<?php echo ($uniqid); ?>" class="relo" size="24" /></td><td width="11%"><label for="view_state">查看权限</label></td><td width="22%"><input name="view_state" id="view_state<?php echo ($uniqid); ?>" class="relo" size="24" /></td></tr><tr><td width="11%"><label for="client_id">所属客户</label></td><td width="23%"><input name="client_id" id="client_id<?php echo ($uniqid); ?>" class="relo" size="26" /></td><td width="11%"><label for="app_handler">负责人</label></td><td width="22%"><input name="app_handler" id="app_handler<?php echo ($uniqid); ?>" type="text" size="24" /></td><td width="11%"><label for="itemtype">项目类型</label></td><td width="22%"><input name="itemtype" id="itemtype<?php echo ($uniqid); ?>" class="relo" size="24" /></td></tr><tr><td><label for="pro_progress">说明</label></td><td colspan="5"><input name="description" type="text" id="description<?php echo ($uniqid); ?>" value="<?php echo htmlspecialchars($info['pro_info']['description']) ?>" autocomplete="off" style="width:99%" /></td></tr><tr><td><label for="description">进度</label></td><td colspan="5"><input name="pro_progress" id="pro_progress<?php echo ($uniqid); ?>" type="text" value="<?php echo htmlspecialchars($info['pro_info']['pro_progress']) ?>" autocomplete="off" style="width:99%" /><input name="pro_creatdate" id="pro_creatdate<?php echo ($uniqid); ?>" size="24" maxlength="19" class="easyui-datepicker" type="hidden" /></td></tr><tr><td><label for="concern">项目关注人</label></td><td colspan="5" style="padding:0px" id="<?php echo ($uniqid); ?>">&nbsp;</td></tr></tbody><tr><td height="38" colspan="6" align="center"><?php if($act=='add'){ ?><a href="javascript:void(0);" onclick="javascript:onSubmitProject('<?php echo ($uniqid); ?>')" id="su" class="easyui-linkbutton" data-options="iconCls:'icon-save'">保存</a><?php }else{ ?><a href="javascript:void(0);" onclick="javascript:return onUploadProject('<?php echo ($uniqid); ?>')" id="sue" class="easyui-linkbutton" data-options="iconCls:'icon-save'">保存</a><?php } ?> &nbsp; <a href="javascript:void(0);" onclick="javascript:onResetProject('<?php echo ($uniqid); ?>')" id="re" class="easyui-linkbutton" data-options="iconCls:'icon-cancel'">关闭</a></td></tr></table></form></div><div id="addApp"></div>