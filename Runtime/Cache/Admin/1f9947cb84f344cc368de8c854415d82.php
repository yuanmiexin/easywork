<?php if (!defined('THINK_PATH')) exit();?><script language="javascript">$(function(){
	$("#addFormComy<?php echo ($uniqid); ?>").form('load',{
		'name':'<?php echo $info["name"] ?>',
		'access':'<?php echo $info["access"] ?>',
		'status':'<?php echo $info["status"] ?>',
		'comment':'<?php echo $info["comment"] ?>',
		'smtp':'<?php echo $info["smtp"] ?>',
		'ssl':'<?php echo $info["ssl"] ?>',
		'port':'<?php echo $info["port"] ?>'
	});
});

var idd = '';
function onSubmitComy(idd){
	$.messager.progress();
	$("#addFormComy"+idd).form('submit',{
		url:'__URL__/add/act/add/go/1',
		success:function(data){
			$.messager.progress('close');
			if(data==1){
				$.messager.alert('提示','新增数据成功！','info',function(){
					var sa = '<?php echo (C("SUBMIT_ACTION")); ?>';
					$("#Client").datagrid('reload');
					if(sa==1){
						cancel['Client'].dialog('close');
						cancel['Client'] = null;
					}
				});
			}else if(data==0){
				$.messager.alert('提示','新增数据失败！','warning');
			}else{
				$.messager.alert('提示','您没有新增权限！','warning',function(){
					var sa = '<?php echo (C("SUBMIT_ACTION")); ?>';
					if(sa==1){
						cancel['Client'].dialog('close');
						cancel['Client'] = null;
					}
				});
			}
		}
	});
}

function onUploadComy(idd){
	$.messager.progress();
	var ids = $("#ids"+idd).val();
	$("#addFormComy"+idd).form('submit',{
		url:'__URL__/add/act/edit/go/1/id/'+ids,
		success:function(data){
			$.messager.progress('close');
			if(data==1){
				$.messager.alert('提示','更新数据成功！','info',function(){
					var sa = '<?php echo (C("SUBMIT_ACTION")); ?>';
					$("#Client").datagrid('reload');
					if(sa==1){
						cancel['Client'].dialog('close');
						cancel['Client'] = null;
					}
				});
				$("#add").dialog('refresh');
			}else if(data==0){
				$.messager.alert('提示','更新数据失败！','warning');
			}else{
				$.messager.alert('提示','您没有修改权限！','warning',function(){
					var sa = '<?php echo (C("SUBMIT_ACTION")); ?>';
					if(sa==1){
						cancel['Client'].dialog('close');
						cancel['Client'] = null;
					}
				});
			}
		}
	});
}

function onResetComy(idd){
	cancel['Client'].dialog('close');
	cancel['Client'] = null;
}
</script><div class="con-tb"><form id="addFormComy<?php echo ($uniqid); ?>" method="post"><table class="infobox" width="100%" border="0" cellspacing="0" cellpadding="0"><tr><td width="28%"><label for="name">客戶名称</label></td><td width="72%"><input name="name" class="easyui-validatebox"  size="22" data-options="required:true" /><input id="ids<?php echo ($uniqid); ?>" type="hidden" value="<?php echo ($id); ?>" /></td></tr><tr><td width="28%"><label for="access">权限值</label></td><td width="72%"><input name="access" type="text" class="easyui-numberbox" size="16" data-options="value:10" /></td></tr><tr><td width="28%"><label for="status">状态</label></td><td width="72%"><select class="easyui-combobox" name="status"><option value="1">开启</option><option  value="0">关闭</option></select></td></tr><tr><td width="28%"><label for="comment">备注</label></td><td width="72%"><input name="comment" type="text" class="easyui-validatebox" style="width:96%" data-options="" /></td></tr><tr><td height="38" colspan="2" align="center"><?php if($act=='add'){ ?><a href="javascript:void(0);" onclick="javascript:onSubmitComy('<?php echo ($uniqid); ?>')" id="su" class="easyui-linkbutton" data-options="iconCls:'icon-save'">保存</a><?php }else{ ?><a href="javascript:void(0);" onclick="javascript:return onUploadComy('<?php echo ($uniqid); ?>')" id="sue" class="easyui-linkbutton" data-options="iconCls:'icon-save'">保存</a><?php } ?> &nbsp; <a href="javascript:void(0);" onclick="javascript:onResetComy('<?php echo ($uniqid); ?>')" id="re" class="easyui-linkbutton" data-options="iconCls:'icon-cancel'">关闭</a></td></tr></table></form></div>