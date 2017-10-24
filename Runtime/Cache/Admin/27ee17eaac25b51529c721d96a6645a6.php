<?php if (!defined('THINK_PATH')) exit();?><script language="javascript">var act = '<?php echo ($act); ?>';
$(function(){
	$("#addFormBug<?php echo ($uniqid); ?>").form('load',{
		'title':'<?php echo $info["title"] ?>',
		'type':'<?php echo $info["type"] ?>',
		'os':'<?php echo $info["os"] ?>',
		'projects':'<?php echo $info["project"] ?>',
		'project':'<?php echo $info["project"] ?>'
	});
	
	$("#projects<?php echo ($uniqid); ?>").combobox({
		url:'__GROUP__/Business/getProject/act/json/val/name',
		editable:true,
		method:'get',
		valueField:'id',
		textField:'text',
		required:false,
		filter: function(q,r){
			$("#project<?php echo ($uniqid); ?>").val(q);
			var opts = $(this).combobox('options');
			var v = r[opts.textField];
			var vq = v.toUpperCase();
			var vp = String(getPinYin(v));
			var qp = q.toUpperCase();
			if(vp.indexOf(qp)>=0 || vq.indexOf(qp) >= 0){
				return r[opts.textField];
			}
		},
		onSelect:function(c){
			$("#project<?php echo ($uniqid); ?>").val(c['id']);
		}
	});
});

function onSubmitBug(idd){
	$.messager.progress();
	$("#toUser"+idd+" option").attr("selected",true);
	$("#addFormBug"+idd).form('submit',{
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
					$("#Bug").datagrid('reload');
					if(sa==1){
						cancel['Bug'].dialog('close');
						cancel['Bug'] = null;
					}
				});
			}else if(data==0){
				$.messager.alert('提示','新增数据失败！','warning');
			}else if(data<0){
				$.messager.alert('提示','您没有新增权限！','warning',function(){
					var sa = '<?php echo (C("SUBMIT_ACTION")); ?>';
					if(sa==1){
						cancel['Bug'].dialog('close');
						cancel['Bug'] = null;
					}
				});
			}else{
				$.messager.alert('提示',data,'warning');
			}
		}
	});
}

function onUploadBug(idd){
	$.messager.progress();
	$("#toUser"+idd+" option").attr("selected",true);
	var ids = $("#ids"+idd).val();
	$("#addFormBug"+idd).form('submit',{
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
					$("#Bug").datagrid('reload');
					if(sa==1){
						cancel['Bug'].dialog('close');
						cancel['Bug'] = null;
					}
				});
				$("#add").dialog('refresh');
			}else if(data==0){
				$.messager.alert('提示','更新数据失败！','warning');
			}else if(data==2){
				$.messager.alert('提示','只能更新自己所新增的数据！','warning');
			}else if(data<0){
				$.messager.alert('提示','您没有更新权限','warning',function(){
					var sa = '<?php echo (C("SUBMIT_ACTION")); ?>';
					if(sa==1){
						cancel['Bug'].dialog('close');
						cancel['Bug'] = null;
					}
				});
			}else{
				$.messager.alert('提示',data,'warning');
			}
		}
	});
}

function onResetBug(idd){
	cancel['Bug'].dialog('close');
	cancel['Bug'] = null;
}
</script><div class="con-tb"><form method="post" enctype="multipart/form-data" id="addFormBug<?php echo ($uniqid); ?>"><table class="infobox" width="100%" border="0" cellspacing="0" cellpadding="0" style="border-collapse: collapse;"><tr><td><label for="title">问题描述</label></td><td colspan="3"><input name="title" id="title<?php echo ($uniqid); ?>" class="easyui-validatebox" data-options="required:true,validType:'ptext'" type="text" style="width:99.8%" /></td></tr><tr><td width="12%"><label for="type">问题类型</label><input id="ids<?php echo ($uniqid); ?>" type="hidden" value="<?php echo ($id); ?>" /></td><td width="13%"><input name="type" id="type<?php echo ($uniqid); ?>" class="easyui-combobox" data-options="url:'__ITEM__/__RUNTIME__/Data/Json/Linkage/wentileixing_data.json',editable:true,method:'get',valueField:'id',textField:'text',required:true,editable:false" type="text" size="13"/></td><td width="12%"><label for="os">相关平台</label></td><td width="63%"><input name="os" id="os<?php echo ($uniqid); ?>" style="width:99.8%" class="easyui-validatebox" type="text" data-options="required:false,validType:'ptext'" /></td></tr><tr><td><label for="project">对应项目</label></td><td colspan="3"><input name="projects" id="projects<?php echo ($uniqid); ?>" size="60" class="relo" /><input name="project" id="project<?php echo ($uniqid); ?>"  type="hidden" value="" /><span class="up-font">（自定义时，请直接输入） </span></td></tr><tr><td><label for="content">详细现象</label></td><td height="225" colspan="3"  ><textarea name="content" id="content<?php echo ($uniqid); ?>"  rows="18" data-options="uploadJson:'__APP__/Public/Upload/save/act/Bug'" class="easyui-kindeditor" style="width:99.8%; height:220px;"><?php echo ($info["baseinfo"]["content"]); ?></textarea></td></tr><tr><td><label for="solution">解决方案</label></td><td height="225" colspan="3"><textarea name="solution" id="solution<?php echo ($uniqid); ?>"  rows="18" class="easyui-kindeditor" style="width:99.8%; height:220px" data-options="uploadJson:'__APP__/Public/Upload/save/act/Bug'"><?php echo ($info["baseinfo"]["solution"]); ?></textarea></td></tr><tr><td><label for="files">附件</label></td><td colspan="3"><input name="files" type="file" />&nbsp;<span class="up-font-over">(文件类型：<?php echo C('UPLOAD_TYPE') ?>)</span><?php if($act=='edit'){ ?><input name="oldfile" type="hidden" value="<?php echo ($info["files"]); ?>" /><br />&nbsp;<font>附件地址：</font><?php if($info['files']){ ?><font class="up-font">__ITEM__/__UPLOAD__/<?php echo ($info["files"]); ?></font><?php }else{ ?><font class="up-font">暂无上传文件</font><?php } } ?></td></tr><tr><td height="38" colspan="4" align="center"><?php if($act=='add'){ ?><a href="javascript:void(0);" onclick="javascript:onSubmitBug('<?php echo ($uniqid); ?>')" id="su" class="easyui-linkbutton" data-options="iconCls:'icon-save'">保存</a><?php }else{ ?><a href="javascript:void(0);" onclick="javascript:return onUploadBug('<?php echo ($uniqid); ?>')" id="sue" class="easyui-linkbutton" data-options="iconCls:'icon-save'">保存</a><?php } ?> &nbsp; <a href="javascript:void(0);" onclick="javascript:onResetBug('<?php echo ($uniqid); ?>')" id="re" class="easyui-linkbutton" data-options="iconCls:'icon-cancel'">关闭</a></td></tr></table></form></div><div id="addOpts"></div>