<?php if (!defined('THINK_PATH')) exit();?><script language="javascript">$(function(){
	$("#addFormLinkage<?php echo ($uniqid); ?>").form('load',{
		'_parentId':'<?php echo $info["_parentId"] ?>',
		'text':'<?php echo $info["text"] ?>',
		'code':'<?php echo $info["code"] ?>',
		'layer':'<?php echo $info["layer"] ?>',
		'status':'<?php echo $info["status"] ?>',
		'sort':'<?php echo $info["sort"] ?>'
	});
});

function onSubmitLinkage(idd){
	$.messager.progress();
	$("#addFormLinkage"+idd).form('submit',{
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
			if(data==1){
				$.messager.alert('提示','新增数据成功！','info',function(){
					var sa = '<?php echo (C("SUBMIT_ACTION")); ?>';
					$("#Linkage").treegrid('reload');
					if(sa==1){
						cancel['Linkage'].dialog('close');
						cancel['Linkage'] = null;
					}
				});
			}else if(data==0){
				$.messager.alert('提示','新增数据失败！','warning');
			}else{
				$.messager.alert('提示','您没有新增权限！','warning',function(){
					var sa = '<?php echo (C("SUBMIT_ACTION")); ?>';
					if(sa==1){
						cancel['Linkage'].dialog('close');
						cancel['Linkage'] = null;
					}
				});
			}
		}
	});
}

function onUploadLinkage(idd){
	$.messager.progress();
	var ids = $("#ids"+idd).val();
	$("#addFormLinkage"+idd).form('submit',{
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
			if(data==1){
				$.messager.alert('提示','更新数据成功！','info',function(){
					var sa = '<?php echo (C("SUBMIT_ACTION")); ?>';
					$("#Linkage").treegrid('reload');
					if(sa==1){
						cancel['Linkage'].dialog('close');
						cancel['Linkage'] = null;
					}
				});
			}else if(data==0){
				$.messager.alert('提示','更新数据失败！','warning');
			}else{
				$.messager.alert('提示','您没有修改权限！','warning',function(){
					var sa = '<?php echo (C("SUBMIT_ACTION")); ?>';
					if(sa==1){
						cancel['Linkage'].dialog('close');
						cancel['Linkage'] = null;
					}
				});
			}
		}
	});
}

function onResetLinkage(idd){
	cancel['Linkage'].dialog('close');
	cancel['Linkage'] = null;
}
</script><div class="con-tb"><form id="addFormLinkage<?php echo ($uniqid); ?>" method="post"><table class="infobox" width="100%" border="0" cellspacing="0" cellpadding="0"><tr><td width="23%"><label for="_parentId">上级联动</label></td><td width="77%"><input name="_parentId" class="easyui-combotree relo" size="32" data-options="url:'__ITEM__/__RUNTIME__/Data/Json/Linkage_notit_data.json',editable:true,lines:true,method:'get',valueField:'id',textField:'text'" /><input id="ids<?php echo ($uniqid); ?>" type="hidden" value="<?php echo ($id); ?>" /></td></tr><tr><td width="23%"><label for="text">联动名称</label></td><td width="77%"><input name="text" type="text" class="easyui-validatebox" size="22" data-options="required:true" /></td></tr><tr><td width="23%"><label for="val">显示样式</label></td><td width="77%" height="50" ><textarea name="val" style="font-size:13px; line-height:16px; width:99%; height:46px" class="easyui-validatebox" data-options="required:false"><?php echo $info["val"] ?></textarea>      (使用HTML标签)</td></tr><tr><td width="23%"><label for="code">识别码</label></td><td width="77%"><input name="code" type="text" class="easyui-validatebox" size="22" />(留空时，自动生成)</td></tr><tr><td width="23%"><label for="status">状态</label></td><td width="77%"><select class="easyui-combobox" name="status"><option value="1">开启</option><option  value="0">关闭</option></select></td></tr><tr><td width="23%"><label for="layer">子联动层数</label></td><td width="77%"><input name="layer" type="text" class="easyui-numberspinner" data-options="value:1,min:1,max:3" size="8" />(为顶级联动时有效)</td></tr><tr><td width="23%"><label for="sort">排序</label></td><td width="77%"><input name="sort" type="text" class="easyui-numberspinner" data-options="value:50" size="16" /></td></tr><tr><td height="38" colspan="2" align="center"><?php if($act=='add'){ ?><a href="javascript:void(0);" onclick="javascript:onSubmitLinkage('<?php echo ($uniqid); ?>')" id="su" class="easyui-linkbutton" data-options="iconCls:'icon-save'">保存</a><?php }else{ ?><a href="javascript:void(0);" onclick="javascript:return onUploadLinkage('<?php echo ($uniqid); ?>')" id="sue" class="easyui-linkbutton" data-options="iconCls:'icon-save'">保存</a><?php } ?> &nbsp; <a href="javascript:void(0);" onclick="javascript:onResetLinkage('<?php echo ($uniqid); ?>')" id="re" class="easyui-linkbutton" data-options="iconCls:'icon-cancel'">关闭</a></td></tr></table></form></div>