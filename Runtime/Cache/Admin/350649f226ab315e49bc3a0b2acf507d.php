<?php if (!defined('THINK_PATH')) exit();?><script language="javascript">//$(".linebox tr:odd").addClass('even');
$(function(){
	$("#co<?php echo ($uniqid); ?>").linkbutton({
		iconCls:'icon-cancel'
	});
});

function onCloseSmsDetail(idd){
	cancel['Sendsms'].dialog('refresh');
	cancel['SmsDetail'].dialog('destroy');
	cancel['SmsDetail'].dialog('close');
	cancel['SmsDetail'] = null;
}
</script><div class="con-tb"><table class="infobox linebox" width="100%" border="0" cellspacing="0" cellpadding="0" ><tr><td class="rebg" width="17%"><label for="customer">发信人</label></td><td width="21%"><?php echo ($info["username"]); ?></td><td class="rebg" width="17%"><label for="daily_date">发信时间</label></td><td width="45%"><?php echo ($info["sendtime"]); ?></td></tr><tr><td class="rebg"><label for="user_id">标题</label></td><td colspan="3"><?php echo ($info["title"]); ?></td></tr><tr><td class="rebg"><label for="purpose">內容</label></td><td colspan="3"><?php echo ($info["baseinfo"]["description"]); ?></td></tr></tbody><tr><td height="38" colspan="4" align="center"><a href="#" onclick="javascript:onCloseSmsDetail('<?php echo ($uniqid); ?>')" id="co<?php echo ($uniqid); ?>">关闭</a></td></tr></table></div><div id="addOpts"></div>