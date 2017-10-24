<?php if (!defined('THINK_PATH')) exit();?><script language="javascript">var role = '<?php echo ($role); ?>';
var act = '<?php echo ($act); ?>';
if(role==-2){
	$.messager.alert('提示','您没有新增权限！','warning');
	cancel['Task'].dialog('close');
	cancel['Task'] = null;
}else if(role==-3){
	$.messager.alert('提示','您没有编辑权限！','warning');
	cancel['Notice'].dialog('close');
	cancel['Notice'] = null;
}
$(function(){
	$("#addFormTask<?php echo ($uniqid); ?>").form('load',{
		'title':'<?php echo $info["title"] ?>',
		'type':'<?php echo $info["type"] ?>',
		'status':'<?php echo $info["status"] ?>',
		'startdate':'<?php echo $info["startdate"] ?>',
		'enddate':'<?php echo $info["enddate"] ?>',
		'from_id':'<?php echo $info["from_id"] ?>',
		'to_id':'<?php echo $info["to_id"] ?>',
		'plantime':'<?php echo $info["plantime"] ?>',
		'level':'<?php echo $info["level"] ?>',
		'degree':'<?php echo $info["degree"] ?>'
	});
	
	$("#type<?php echo ($uniqid); ?>").combobox({
		url:'__ITEM__/__RUNTIME__/Data/Json/Linkage/renwuleixing_data.json',
		editable:false,
		method:'get',
		required:true,
		valueField:'id',
		textField:'text',
	});
	$("#level<?php echo ($uniqid); ?>").combobox({
		url:'__ITEM__/__RUNTIME__/Data/Json/Linkage/youxianji_data.json',
		editable:false,
		method:'get',
		required:true,
		valueField:'id',
		textField:'text',
		onLoadSuccess:function(){
			if(act=='add'){
				$("#level<?php echo ($uniqid); ?>").combobox('setValue',37);
			}
		}
	});
	$("#degree<?php echo ($uniqid); ?>").combobox({
		url:'__ITEM__/__RUNTIME__/Data/Json/Linkage/yanzhongchengdu_data.json',
		editable:false,
		method:'get',
		required:true,
		valueField:'id',
		textField:'text',
		onLoadSuccess:function(){
			if(act=='add'){
				$("#degree<?php echo ($uniqid); ?>").combobox('setValue',26);
			}
		}
	});
	$("#status<?php echo ($uniqid); ?>").combobox({
		url:'__ITEM__/__RUNTIME__/Data/Json/Linkage/renwuzhuangtai_data.json',
		editable:false,
		method:'get',
		required:true,
		valueField:'id',
		textField:'text',
		onLoadSuccess:function(){
			if(act=='add'){
				$("#status<?php echo ($uniqid); ?>").combobox('setValue',9);
			}
		}
	});
	$("#to_id<?php echo ($uniqid); ?>").combotree({
		required:true,
		url:'__ITEM__/__RUNTIME__/Data/Json/User_tree_data.json',
		editable:true,
		method:'get',
		required:true,
		valueField:'id',
		textField:'text',
		keyHandler: {
			query : function(q) {
				queryComboTree(q, "to_id<?php echo ($uniqid); ?>", 0);
			}
		},
		onBeforeSelect:function(node){
			if(isset(node.children)){
				$("#to_id<?php echo ($uniqid); ?>").tree("unselect");
			}
		}
	});
	$("#from_id<?php echo ($uniqid); ?>").combotree({
		required:true,
		url:'__ITEM__/__RUNTIME__/Data/Json/User_tree_data.json',
		editable:true,
		method:'get',
		required:true,
		valueField:'id',
		textField:'text',
		keyHandler: {
			query : function(q) {
				queryComboTree(q, "from_id<?php echo ($uniqid); ?>", 0);
			}
		},
		onBeforeSelect:function(node){
			if(isset(node.children)){
				$("#from_id<?php echo ($uniqid); ?>").tree("unselect");
			}
		},
		onLoadSuccess:function(){
			if(act=='add'){
				$("#from_id<?php echo ($uniqid); ?>").combobox('setValue','<?php echo ($userid); ?>');
			}
		}
	});
});

var idd = '';
function onSubmitTask(idd){
	$.messager.progress();
	$("#addFormTask"+idd).form('submit',{
		url:'__URL__/task/act/add/go/1',
		onSubmit: function(){
			var isValid = $(this).form('validate');
			if (!isValid){
				$.messager.progress('close');
			}
			return isValid;
		},
		success:function(data){
			$.messager.progress('close');
			if(data==1){
				$.messager.alert('提示','新增数据成功！','info',function(){
					var sa = '<?php echo (C("SUBMIT_ACTION")); ?>';
					$("#taskTree").tree('reload');
					$("#taskList").datagrid('reload');
					if(sa==1){
						cancel['Task'].dialog('destroy');
						cancel['Task'].dialog('close');
						cancel['Task'] = null;
					}
				});
			}else if(data==0){
				$.messager.alert('提示','新增数据失败！','warning');
			}else{
				$.messager.alert('提示','您没有新增权限！','warning',function(){
					var sa = '<?php echo (C("SUBMIT_ACTION")); ?>';
					if(sa==1){
						cancel['Task'].dialog('destroy');
						cancel['Task'].dialog('close');
						cancel['Task'] = null;
					}
				});
			}
		}
	});
}

function onUploadTask(idd){
	$.messager.progress();
	$("#addFormTask"+idd).form('submit',{
		url:'__URL__/task/act/edit/go/1',
		onSubmit: function(){
			var isValid = $(this).form('validate');
			if (!isValid){
				$.messager.progress('close');
			}
			return isValid;
		},
		success:function(data){
			$.messager.progress('close');
			if(data==1){
				$.messager.alert('提示','更新数据成功！','info',function(){
					var sa = '<?php echo (C("SUBMIT_ACTION")); ?>';
					$("#taskTree").tree('reload');
					$("#proDetailCon").panel('refresh');
					if(sa==1){
						cancel['Task'].dialog('destroy');
						cancel['Task'].dialog('close');
						cancel['Task'] = null;
					}
				});
				$("#add").dialog('refresh');
			}else if(data==2){
				$.messager.alert('提示','该任务已审核，不能更新！','warning');
			}else if(data==0){
				$.messager.alert('提示','更新数据失败！','warning');
			}else{
				$.messager.alert('提示','您没有更新权限！','warning',function(){
					var sa = '<?php echo (C("SUBMIT_ACTION")); ?>';
					if(sa==1){
						cancel['Task'].dialog('destroy');
						cancel['Task'].dialog('close');
						cancel['Task'] = null;
					}
				});
			}
		}
	});
}

function onResetTask(idd){
	cancel['Task'].dialog('destroy');
	cancel['Task'].dialog('close');
	cancel['Task'] = null;
}
</script><div class="con-tb"><form class="add-task" id="addFormTask<?php echo ($uniqid); ?>" method="post"><table class="infobox" width="100%" border="0" cellspacing="0" cellpadding="0"><tr><td width="14%"><label for="type">任务类型</label><input name="task_id" type="hidden" value="<?php echo ($info["id"]); ?>" /><input name="_parentId" type="hidden" value="<?php echo ($tid); ?>" /><?php if($act=='add'){ ?><input name="pro_id" type="hidden" value="<?php echo ($id); ?>" /><?php }else{ ?><input name="pro_id" type="hidden" value="<?php echo ($info["pro_id"]); ?>" /><?php } ?></td><td width="20%"><input name="type" id="type<?php echo ($uniqid); ?>" class="relo" size="18" /></td><td width="13%"><label for="to_id">指派給</label></td><td width="20%"><input name="to_id" id="to_id<?php echo ($uniqid); ?>" class="relo" size="18" /><input name="oldto" type="hidden" value="<?php echo ($info["to_id"]); ?>" /></td><td width="13%"><label for="from_id">来自</label></td><td width="20%"><input name="from_id" id="from_id<?php echo ($uniqid); ?>" class="relo" size="18" /></td></tr><tr><td width="14%"><label for="startdate">计划开始日</label></td><td width="20%"><input name="startdate" id="startdate<?php echo ($uniqid); ?>" class="easyui-datepicker" data-options="required:true" size="18" autocomplete="off" /></td><td width="13%"><label for="enddate">计划完成日</label></td><td><input name="enddate" id="enddate<?php echo ($uniqid); ?>" class="easyui-datepicker" data-options="required:true" size="18" autocomplete="off" /></td><td><label for="plantime">计划用时</label></td><td><input name="plantime" id="plantime<?php echo ($uniqid); ?>" class="easyui-numberbox" size="12" data-options="precision:1" /> 小时</td></tr><tr><td width="14%"><label for="level">优先级</label></td><td width="20%"><input name="level" id="level<?php echo ($uniqid); ?>" class="relo" size="18" /></td><td width="13%"><label for="degree">严重程度</label></td><td><input name="degree" id="degree<?php echo ($uniqid); ?>" class="relo" size="18" /></td><td><label for="status">任务状态</label></td><td><input name="status" id="status<?php echo ($uniqid); ?>" class="relo" size="18" /></td></tr><tr><td width="14%"><label for="title">任务标题</label></td><td colspan="5"><input name="title" type="text" class="easyui-validatebox" value="" style="width:99%;" data-options="required:true,validType:'ptext'" /></td></tr><tr><td width="14%"><label for="contents">任务描述</label></td><td colspan="5"><textarea name="content" id="contentID<?php echo ($uniqid); ?>"  rows="18" class="easyui-kindeditor" style="width:99%; height:300px" data-options="uploadJson:'__APP__/Public/Upload/save/act/task'"><?php echo ($info["baseinfo"]["content"]); ?></textarea></td></tr><tr><td height="38" colspan="6" align="center"><?php if($act=='add'){ ?><a href="javascript:void(0);" onclick="javascript:onSubmitTask('<?php echo ($uniqid); ?>')" id="su" class="easyui-linkbutton" data-options="iconCls:'icon-save'">保存</a><?php }else{ ?><a href="javascript:void(0);" onclick="javascript:return onUploadTask('<?php echo ($uniqid); ?>')" id="sue" class="easyui-linkbutton" data-options="iconCls:'icon-save'">保存</a><?php } ?> &nbsp; <a href="javascript:void(0);" onclick="javascript:onResetTask('<?php echo ($uniqid); ?>')" id="re" class="easyui-linkbutton" data-options="iconCls:'icon-cancel'">关闭</a></td></tr></table></form></div>