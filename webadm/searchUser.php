<?php
require_once('vpopadm.inc.php');

	if (!adminPerm(PERM_ADMIN_USERCONTROL) ){
?>
		<br>
		��û�з��ʸ���ҳ��Ȩ�ޡ�<br>
<?php
		return false;
	}
?>
<HTML>
<HEAD>
<meta http-equiv="content-type" content="text/html; charset=gb2312">
<TITLE>�����û�</TITLE>
</HEAD>
<BODY>
<DIV align="center">
<FORM action="userInfo.php" method="put">
<table>
<tbody>
<tr>
<td>����������ҵ��û��˺�:</td>
<td><INPUT type="text" name="id"></td>
</td>
</tbody>
</table>
<INPUT type="submit" value="��ʼ����">
</form>
</div>
</BODY>
</HTML>