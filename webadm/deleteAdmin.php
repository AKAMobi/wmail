<?
require_once("vpopadm.inc.php");
?>
<HTML>
<HEAD>
<meta http-equiv="content-type" content="text/html; charset=gb2312">
<TITLE>ɾ������Ա</TITLE>
</HEAD>
<BODY>
<DIV align="center">
<?


function deleteUser() {

		if (!adminPerm(PERM_ADMIN_ADMINCONTROL) ){
?>
		<br>
		��û�з��ʸ���ҳ��Ȩ�ޡ�<br>
<?php
		return false;
	}

   	
        $id=$_REQUEST['id'];
	$selfid=getAdminID();

	if ($selfid==$id) {
		errorReturn("������ɾ���Լ����˺�", "showadminlist.php");
	}

	
	if ($id==SYSOPID) {
		errorReturn("������ɾ����߹���Ա" . SYSOP . "���˺�", "showadminlist.php");
	}

	$result=deleteAdmin($id);
	
	if ($result==OK){
?>
	����Ա�˺��ѳɹ�ɾ����<br>
<?
	} else {
?>
	����δ�ҵ��˺�Ϊ<? echo $id ;?>�Ĺ���Ա��Ϣ<br>
<?
	}
}


deleteUser();
?>
</div>
</BODY>
</HTML>
