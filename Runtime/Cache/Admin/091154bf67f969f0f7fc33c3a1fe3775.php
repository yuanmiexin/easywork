<?php if (!defined('THINK_PATH')) exit();?><script language="javascript">$(function(){
 $("#smslist").datagrid({	
		height:315,
		autoRowHeight:false,
		singleSelect:true,
		striped:true,
		rownumbers:true,
		pagination:true,
		method:'get',
		url:'__ACTION__/act/1/json/1',
		fitColumns:true,
		nowrap:Number('<?php echo (C("DATA_NOWRAP")); ?>'),
		selectOnCheck:false,
		checkOnSelect:true,
		onDblClickRow:function(e,rowIndex,rowData){
			var se = $(this).datagrid('getSelected');
			//var se = $("#smslist").datagrid('getChecked');
			//var se_len = se.length;
			var idd = se['id'];
			$("<div/>").dialog({
				title:'信息详情',
				resizable:true,
				width:520,
				height:383,
				href:'__URL__/smsdetail/id/'+idd,
				onOpen:function(){
					cancel['SmsDetail'] = $(this);
				},
				onClose:function(){
					cancel['Sendsms'].dialog('refresh');
					$(this).dialog('destroy');
					cancel['SmsDetail'] = null;
				}
			});
		},
		toolbar:[{
		iconCls: 'icon-email',
			text : '全部设为已读',
			handler: function(){
				$.messager.confirm('提示','確定设置吗？',function(r){
					if(r){
						$.get('__URL__/smsact/act/readed', function(data){
							if(data==1){
								$.messager.alert('提示','设置已读成功！','info',function(){
									cancel['Sendsms'].dialog('refresh');
								});
							}else if(data==2){
								$.messager.alert('提示','无法获取用戶ID！','warning');
							}else{
								$.messager.alert('提示','设置已读失败！','warning');
							}
						});
					}
				});
			}
		},'-',{
			iconCls: 'icon-cancel',
			text : '清空所有信息',
			handler: function(){
				$.messager.confirm('提示','确定清空吗？',function(r){
					if(r){
						$.get('__URL__/smsact/act/clear', function(data){
							if(data==1){
								$.messager.alert('提示','清空信息成功！','info',function(){
									cancel['Sendsms'].dialog('refresh');
								});
							}else if(data==2){
								$.messager.alert('提示','无法获取用戶ID！','warning');
							}else{
								$.messager.alert('提示','清空信息失敗！','warning');
							}
						});
					}
				});
			}
		}],
		columns:[[ 
			{field:'title',title:'标题',width:250},
			{field:'username',title:'发件人',width:60},
			{field:'sendtime',title:'发件时间',width:140}
		]]
	});
});

function onResetSend(idd){
	cancel['SmsDetail'].dialog('destroy');
	cancel['SmsDetail'].dialog('close');
	cancel['SmsDetail'] = null;
	cancel['Sendsms'].dialog('close');
	cancel['Sendsms'] = null;
}
</script><div class="con-tb" onselectstart="return false;" style="-moz-user-select:none;"><table id="smslist" class="infobox" width="100%" border="0" cellspacing="0" cellpadding="0"></table></div>