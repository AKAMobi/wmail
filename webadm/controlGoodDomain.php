<?
require_once("vpopadm.inc.php");
?>
<HTML>
<HEAD>
<meta http-equiv="content-type" content="text/html; charset=gb2312">
<TITLE>��������������</TITLE>
<style>

table { font-size:x-small;}

.title {font-size:medium;color:#ffffff;background-color:#6fa6e6;}
</style>
</HEAD>
<BODY>

<!-- Insert HTML here -->

<?

function doConfig(){
	if (!adminPerm(PERM_ADMIN_ADMINCONTROL) ){
		?>
			<br>
			��û�з��ʸ���ҳ��Ȩ�ޡ�<br>
			<?php
			return false;
	}
	if (!isset($_POST['content'])){ 
		return false;
	}
	$handle=fopen("/var/qmail/control/goodmailfrom","w");	
	if (!$handle) {
		echo "�����޷��������ã�<br>";
		return false;
	}
	fputs($handle,str_replace("\r","",$_POST['content']));
	fclose($handle);
	return true;
}

if ( (isset($_REQUEST['doConfig']) && doConfig()) ){
	echo "���ñ���ɹ���<br>";
} else {
	if ( ! file_exists("/var/qmail/control/goodmailfrom") ){
		fclose( fopen("/var/qmail/control/goodmailfrom","w") );
	}
	
	$handle = fopen ("/var/qmail/control/goodmailfrom", "r");
	$list="";
	while (!feof ($handle)) {
		$buffer= fgets($handle, 4096);
		$list.=$buffer;
	}
	fclose ($handle);

	?>
		<center>
		<form action="<? echo $_SERVER['PHP_SELF']; ?>" method=post>
		<INPUT type="hidden" name="doConfig">
		<table border=0>
		<tr align="center" bgcolor=#6fa6e6>
		<td colspan="2" class=title><b>���������������б�</b></td>
		</tr>
		<tr>
		<td colspan="2">������������
		</td>
		</tr>
		<tr>
		<td colspan="2"><textarea name="content" rows=20 cols=20><? echo $list ?></textarea>
		</td>
		</tr>
		<tr align="center" >
		<td colspan=2><input type=submit name="adduser" value="  ��  ��  ">
		</td>
		</tr>
		</table>

		</form>
		</br>
		<?
}
?>
</BODY>
</HTML>
