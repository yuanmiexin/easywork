<?php if (!defined('THINK_PATH')) exit();?><script language="javascript">var act = '<?php echo ($act); ?>';
$(function(){
	$("#addFormUser<?php echo ($uniqid); ?>").form('load',{
		'username':'<?php echo $info["username"] ?>',
		'email':'<?php echo $info["email"] ?>',
		'status':'<?php echo $info["status"] ?>',
		//'report':'<?php echo $info["report"] ?>',
		'company_id':'<?php echo $info["user_main"]["company_id"] ?>',
		'group_id':'<?php echo $info["user_main"]["group_id"] ?>',
		'part_id':'<?php echo $info["user_main"]["part_id"] ?>'
	});
	
	$("#group_ids<?php echo ($uniqid); ?>").combobox({
		onLoadSuccess:function(){
			var act = '<?php echo ($act); ?>';
			if(act=='add'){
				//$("#group_ids<?php echo ($uniqid); ?>").combobox('setValue','5');
			}
		}
	});	
	
	$("#companyId<?php echo ($uniqid); ?>").combobox({
		url:'__ITEM__/__RUNTIME__/Data/Json/Comy_Client_data.json',
		editable:false,
		method:'get',
		required:true,
		valueField:'id',
		textField:'text',
		onLoadSuccess:function(){
			if(act=='edit'){
				var comyid = '<?php echo $info["user_main"]["company_id"] ?>';
				if(comyid){
					$("#partId<?php echo ($uniqid); ?>").combobox('reload','__ITEM__/__RUNTIME__/Data/Json/Part/100'+comyid+'_data.json');
					$("#partId<?php echo ($uniqid); ?>").combobox('setValue','<?php echo $info["user_main"]["part_id"] ?>');
				}
				
			}
		},
		onSelect:function(data){
			idd = '100'+data.id;
			$.ajax({
			   url:'__ITEM__/__RUNTIME__/Data/Json/Part/'+idd+'_data.json',
			   type:'HEAD',
			   error: function() {
					$("#partId<?php echo ($uniqid); ?>").combobox({
						url:'__ITEM__/__RUNTIME__/Data/Json/Empty_data.json',
						editable:false,
						required:false,
						method:'get',
						valueField:'id',
						textField:'text',
						onLoadSuccess:function(){
							$("#partId<?php echo ($uniqid); ?>").combobox('setValue','');
						}
					});	
			   },
			   success: function() {
				   $("#partId<?php echo ($uniqid); ?>").combobox({
						url:'__ITEM__/__RUNTIME__/Data/Json/Part/'+idd+'_data.json',
						editable:false,
						required:true,
						method:'get',
						valueField:'id',
						textField:'text',
						onLoadSuccess:function(){
							$("#partId<?php echo ($uniqid); ?>").combobox('setValue','');
						}
					});	
			   }
			});
		}
	});
});

var idd ='';
function onSubmitUser(idd){
	$.messager.progress();
	$("#addFormUser"+idd).form('submit',{
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
					$("#Users").datagrid('reload');
					if(sa==1){
						cancel['User'].dialog('close');
						cancel['User'] = null;
					}
				});
			}else if(data==0){
				$.messager.alert('提示','新增数据失败！','warning');
			}else if(data==2){
				$.messager.alert('提示','无法发送邮件，请检查邮箱设置！','warning');
			}else{
				$.messager.alert('提示','您没有新增权限！','warning',function(){
					var sa = '<?php echo (C("SUBMIT_ACTION")); ?>';
					if(sa==1){
						cancel['User'].dialog('close');
						cancel['User'] = null;
					}
				});
			}
		}
	});
}

function onUploadUser(idd){
	$.messager.progress();
	var ids = $("#ids"+idd).val();
	$("#addFormUser"+idd).form('submit',{
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
					$("#Users").datagrid('reload');
					if(sa==1){
						cancel['User'].dialog('close');
						cancel['User'] = null;
					}
				});
			}else if(data==0){
				$.messager.alert('提示','更新数据失败！','warning');
			}else{
				$.messager.alert('提示','您没有修改权限！','warning',function(){
					var sa = '<?php echo (C("SUBMIT_ACTION")); ?>';
					if(sa==1){
						cancel['User'].dialog('close');
						cancel['User'] = null;
					}
				});
			}
		}
	});
}

function onRepwd(idd){
	$.messager.progress();
	var ids = $("#ids"+idd).val();
	$("#addFormUser"+idd).form('submit',{
		url:'__URL__/rspwd/id/'+ids,
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
				$.messager.alert('提示','重置密码成功！','info',function(){
					var sa = '<?php echo (C("SUBMIT_ACTION")); ?>';
					if(sa==1){
						cancel['User'].dialog('close');
						cancel['User'] = null;
					}
				});
			}else if(data==0){
				$.messager.alert('提示','重置密码失败！','warning');
			}else if(data==2){
				$.messager.alert('提示','无法发送邮件，请检查邮箱设置！','warning');
			}else{
				
				$.messager.alert('提示','你没有重置密码的权限！','warning',function(){
					var sa = '<?php echo (C("SUBMIT_ACTION")); ?>';
					if(sa==1){
						cancel['User'].dialog('close');
						cancel['User'] = null;
					}
				});
			}
		}
	});
}

function onResetUser(idd){
	cancel['User'].dialog('close');
	cancel['User'] = null;
}
</script><div class="con-tb"><form id="addFormUser<?php echo ($uniqid); ?>" method="post"><table class="infobox" width="100%" border="0" cellspacing="0" cellpadding="0"><tr><td width="23%"><label for="username">账号</label></td><td width="77%"><input name="username" class="easyui-validatebox"  size="22" data-options="required:true" /><input id="ids<?php echo ($uniqid); ?>" type="hidden" value="<?php echo ($id); ?>" /></td></tr><?php if(C('MORE_COMY')){ ?><tr><td width="23%"><label for="company_id">公司</label></td><td width="77%"><input name="company_id" class="relo" id="companyId<?php echo ($uniqid); ?>" size="28" /></td></tr><tr><td width="23%"><label for="part_id">部门</label></td><td width="77%"><input name="part_id" class="easyui-combobox relo" id="partId<?php echo ($uniqid); ?>" size="28" data-options="url:'__ITEM__/__RUNTIME__/Data/Json/Empty_data.json',editable:false,method:'get',required:false,valueField:'id',textField:'text'" /></td></tr><?php }else{ ?><tr><td width="23%"><label for="part_id">部门</label></td><td width="77%"><input name="part_id" class="easyui-combobox relo" id="partId<?php echo ($uniqid); ?>" size="28" data-options="url:'__ITEM__/__RUNTIME__/Data/Json/Client_Part_data.json',editable:false,method:'get',required:true,valueField:'id',textField:'text'" /></td></tr><?php } ?><tr><td width="23%"><label for="group_id">角色</label></td><td width="77%"><input name="group_id" class="easyui-combobox relo" id="group_ids<?php echo ($uniqid); ?>" size="28" data-options="url:'__ITEM__/__RUNTIME__/Data/Json/Group_data.json',editable:false,method:'get',required:true,valueField:'id',textField:'text'" /></td></tr><tr><td width="23%"><label for="password">密码</label></td><td width="77%"><input name="password" type="password" class="easyui-validatebox"  size="22" /><?php if($act=='add'){ ?>(留空时自动生成)<?php } ?></td></tr><tr><td width="23%"><label for="email">邮箱</label></td><td width="77%"><input name="email" type="text" class="easyui-validatebox" value="" size="42" data-options="required:true,validType:'email'" /></td></tr><tr><td width="23%"><label for="status">状态</label></td><td width="77%"><select class="easyui-combobox" name="status" data-options="editable:false"><option value="1">开启</option><option  value="0">关闭</option></select></td></tr><tr><td height="38" colspan="2" align="center"><?php if($act=='add'){ ?><a href="javascript:void(0);" onclick="javascript:onSubmitUser('<?php echo ($uniqid); ?>')" id="su" class="easyui-linkbutton" data-options="iconCls:'icon-save'">保存</a><?php }else{ ?><a href="javascript:void(0);" onclick="javascript:return onUploadUser('<?php echo ($uniqid); ?>')" id="sue" class="easyui-linkbutton" data-options="iconCls:'icon-save'">保存</a><?php } ?> &nbsp; <a href="javascript:void(0);" onclick="javascript:onResetUser('<?php echo ($uniqid); ?>')" id="re" class="easyui-linkbutton" data-options="iconCls:'icon-cancel'">关闭</a> &nbsp; <?php if($act=='edit'){ ?><a href="javascript:void(0);" onclick="javascript:return onRepwd('<?php echo ($uniqid); ?>')" id="sur" class="easyui-linkbutton" data-options="iconCls:'icon-save'">重置密码</a><?php } ?></td></tr></table></form></div>