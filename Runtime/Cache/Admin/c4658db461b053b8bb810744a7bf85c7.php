<?php if (!defined('THINK_PATH')) exit();?><script language="javascript">$(function(){
	$("#addFormMenu<?php echo ($uniqid); ?>").form('load',{
		'_parentId':'<?php echo $info["_parentId"] ?>',
		'text':'<?php echo $info["text"] ?>',
		'code':'<?php echo $info["code"] ?>',
		'url':'<?php echo $info["url"] ?>',
		'iconCls':'<?php echo $info["iconCls"] ?>',
		'state':'<?php echo $info["state"] ?>',
		'status':'<?php echo $info["status"] ?>',
		'mode':'<?php echo $info["mode"] ?>',
		'type':'<?php echo $info["type"] ?>',
		'level':'<?php echo $info["level"] ?>',
		'sort':'<?php echo $info["sort"] ?>'
	});
	
	$("#view<?php echo ($uniqid); ?>").combobox({
		required:false,
		url:'__ITEM__/__RUNTIME__/Data/Json/User_noadmin_data.json',
		editable:true,
		multiple:true,
		method:'get',
		valueField:'id',
		textField:'text',
		filter: function(q,r){
			var opts = $(this).combobox('options');
			var v = r[opts.textField];
			var vp = ','+String(getPinYin(v));
			var qp = ','+q.toUpperCase();
			if(vp.indexOf(qp)>=0 || v.indexOf(q) == 0){
				return r[opts.textField];
			}
		}
	});
	
	var act = '<?php echo ($act); ?>';
	if(act=='add'){
		$("#level<?php echo ($uniqid); ?>").val("10");
	}else{
		$("#view<?php echo ($uniqid); ?>").combobox('setValues',[<?php echo $info["view"] ?>]);
	}
});

function onSubmitMenu(idd){
	$.messager.progress();
	$("#addFormMenu"+idd).form('submit',{
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
					$("#Menu").treegrid('reload');
					if(sa==1){
						cancel['Menu'].dialog('close');
						cancel['Menu'] = null;
					}
				});
			}else if(data==0){
				$.messager.alert('提示','新增数据失败！','warning');
			}else{
				$.messager.alert('提示','您没有新增权限！','warning',function(){
					var sa = '<?php echo (C("SUBMIT_ACTION")); ?>';
					if(sa==1){
						cancel['Menu'].dialog('close');
						cancel['Menu'] = null;
					}
				});
			}
		}
	});
}

function onUploadMenu(idd){
	$.messager.progress();
	var ids = $("#ids"+idd).val();
	$("#addFormMenu"+idd).form('submit',{
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
					$("#Menu").treegrid('reload');
					if(sa==1){
						cancel['Menu'].dialog('close');
						cancel['Menu'] = null;
					}
				});
			}else if(data==0){
				$.messager.alert('提示','更新数据失败！','warning');
			}else{
				$.messager.alert('提示','您没有修改权限！','warning',function(){
					var sa = '<?php echo (C("SUBMIT_ACTION")); ?>';
					if(sa==1){
						cancel['Menu'].dialog('close');
						cancel['Menu'] = null;
					}
				});
			}
		}
	});
}

function onResetMenu(idd){
	cancel['Menu'].dialog('close');
	cancel['Menu'] = null;
}
</script><div class="con-tb"><form id="addFormMenu<?php echo ($uniqid); ?>" method="post"><table class="infobox" width="100%" border="0" cellspacing="0" cellpadding="0"><tr><td width="23%"><label for="_parentId">上级菜单</label></td><td width="77%"><input name="_parentId" class="easyui-combotree relo" id="parentId" size="28" data-options="url:'__ITEM__/__RUNTIME__/Data/Json/Menu_data.json',editable:true,lines:true,method:'get'" /><input id="ids<?php echo ($uniqid); ?>" type="hidden" value="<?php echo ($id); ?>" /></td></tr><tr><td width="23%"><label for="text">菜单名称</label></td><td width="77%"><input name="text" type="text" class="easyui-validatebox" size="28" data-options="required:true" /></td></tr><tr><td width="23%"><label for="code">识别码</label></td><td width="77%"><input name="code" type="text" class="easyui-validatebox" size="22" data-options="required:false" /> (对应控制器名称)</td></tr><tr><td><label for="url">链接</label></td><td><input name="url" type="text" class="easyui-validatebox" size="38" /></td></tr><tr><td width="23%"><label for="iconCls">标题图片</label></td><td width="77%"><input name="iconCls" type="text" class="easyui-validatebox" size="22" /></td></tr><tr><td width="23%"><label for="state">展开状态</label></td><td width="77%"><select class="easyui-combobox" name="state"><option value="open">展开</option><option  value="closed">隐藏</option></select></td></tr><tr><td width="23%"><label for="level">查看权限</label></td><td width="77%"><select class="easyui-combobox" name="mode"><option value="1">组别</option><?php if(C('MORE_COMY')){ ?><option  value="2">公司</option><?php } ?><option  value="3">部门</option></select><select class="easyui-combobox" name="type"><option value=">=">≥</option><option  value="=">＝</option></select><input name="level" id="level<?php echo ($uniqid); ?>" type="text" class="easyui-validatebox" size="16" data-options="" /></td></tr><tr><td width="23%"><label for="view">开启用户</label></td><td width="77%"><input name="view[]" id="view<?php echo ($uniqid); ?>" type="text" size="38" /></td></tr><tr><td width="23%"><label for="status">状态</label></td><td width="77%"><select class="easyui-combobox" name="status"><option value="1">开启</option><option  value="0">关闭</option></select></td></tr><tr><td width="23%"><label for="sort">排序</label></td><td width="77%"><input name="sort" type="text" class="easyui-numberspinner" data-options="value:50" size="16" /></td></tr><tr><td height="38" colspan="2" align="center"><?php if($act=='add'){ ?><a href="javascript:void(0);" onclick="javascript:onSubmitMenu('<?php echo ($uniqid); ?>')" id="su" class="easyui-linkbutton" data-options="iconCls:'icon-save'">保存</a><?php }else{ ?><a href="javascript:void(0);" onclick="javascript:return onUploadMenu('<?php echo ($uniqid); ?>')" id="sue" class="easyui-linkbutton" data-options="iconCls:'icon-save'">保存</a><?php } ?> &nbsp; <a href="javascript:void(0);" onclick="javascript:onResetMenu('<?php echo ($uniqid); ?>')" id="re" class="easyui-linkbutton" data-options="iconCls:'icon-cancel'">关闭</a></td></tr></table></form></div>