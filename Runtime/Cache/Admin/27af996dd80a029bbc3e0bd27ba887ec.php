<?php if (!defined('THINK_PATH')) exit();?><script language="javascript">$(function(){
	
});

function onSubmitMenu(idd){
	$.messager.progress();
	var ids = $("#ids"+idd).val();
	$("#addFormMenu"+idd).form('submit',{
		url:'__URL__/role/id/'+ids+'/go/1',
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
				$.messager.alert('提示','权限文件修改成功！','info',function(){
					var sa = '<?php echo (C("SUBMIT_ACTION")); ?>';
					$("#Menu").treegrid('reload');
					if(sa==1){
						cancel['MenuRole'].dialog('close');
						cancel['MenuRole'] = null;
					}
				});
			}else if(data==0){
				$.messager.alert('提示','权限文件修改失败！','warning');
			}else if(data==2){
				$.messager.alert('提示','权限文件修改失败！','warning');
				$.messager.alert('提示','菜单识别码无效，请检查！','warning',function(){
					var sa = '<?php echo (C("SUBMIT_ACTION")); ?>';
					if(sa==1){
						cancel['MenuRole'].dialog('close');
						cancel['MenuRole'] = null;
					}
				});
			}else{
				$.messager.alert('提示','您没有修改权限！','warning',function(){
					var sa = '<?php echo (C("SUBMIT_ACTION")); ?>';
					if(sa==1){
						cancel['MenuRole'].dialog('close');
						cancel['MenuRole'] = null;
					}
				});
			}
		}
	});
}

function onResetMenu(idd){
	cancel['MenuRole'].dialog('close');
	cancel['MenuRole'] = null;
}
</script><div class="con-tb"><form id="addFormMenu<?php echo ($uniqid); ?>" method="post"><table class="infobox" width="100%" border="0" cellspacing="0" cellpadding="0"><tr><td width="23%"><label for="path">文件地址</label></td><td width="77%"><?php echo ($path); ?><input name="code" type="hidden" value="<?php echo ($code); ?>" /><input id="ids<?php echo ($uniqid); ?>" type="hidden" value="<?php echo ($id); ?>" /></td></tr><tr><td width="23%" height="325"><label for="file">配置內容</label></td><td width="77%"><textarea style="width:99%; height:320px;" name="file"><?php echo ($file); ?></textarea></td></tr><tr><td height="38" colspan="2" align="center"><a href="javascript:void(0);" onclick="javascript:onSubmitMenu('<?php echo ($uniqid); ?>')" id="su" class="easyui-linkbutton" data-options="iconCls:'icon-save'">保存</a> &nbsp; <a href="javascript:void(0);" onclick="javascript:onResetMenu('<?php echo ($uniqid); ?>')" id="re" class="easyui-linkbutton" data-options="iconCls:'icon-cancel'">关闭</a></td></tr></table></form></div>