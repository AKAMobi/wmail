<?
require_once("vpopadm.inc.php");
?>
<HTML>
<HEAD>
<meta http-equiv="content-type" content="text/html; charset=gb2312">
<TITLE>�޸�������Ϣ</TITLE>
</HEAD>
<BODY>
<DIV align="center">
<?

function changeUserPasswd() {

	$id=getAdminID();

	if (!adminPerm(PERM_ADMIN_BASIC) ){
?>
		<br>
		��û�з��ʸ���ҳ��Ȩ�ޡ�<br>
<?php
		return false;
	}



	if ( isset($_REQUEST["changeUserPasswd"])){ //ʵ���޸��û���Ϣ

	$passwd= $_REQUEST['passwd'];
	$passwd1 = $_REQUEST['passwd1'];						
	$passwd2 = $_REQUEST['passwd2'];

    if ( $passwd1 != $passwd2 ) {
    	echo "����������������벻ƥ��<br>";
    	return false;
    }

	$result=isPasswordRight($id,$passwd);

	if ( ($result==ERR_FORMAT_PASSWORD) || ($result==ERR_WRONGPASSWORD) ){
		errorReturn("�������,����������",$_SERVER['PHP_SELF']);
	}

	if ( ($result==ERR_FORMAT_ID) || ($result==ERR_NOSUCHID) ){
		session_unset();
		session_destroy();
		errorReturn("�޴˹���Ա�˺�,����������",$_SERVER['PHP_SELF']);
	} 

	if ($result!=OK) {
		errorReturn('�������󣬽�ϵͳ����Ա��debug', $_SERVER['PHP_SELF']);
	}

	$result=setPassword($id,$passwd1);	

	if ( ($result==ERR_FORMAT_PASSWORD) ){
		errorReturn("�����ʽ����,����������",$_SERVER['PHP_SELF']);
	}

	if ( ($result==ERR_FORMAT_ID) || ($result==ERR_NOSUCHID) ){
		session_unset();
		session_destroy();
		errorReturn("�޴˹���Ա�˺�,����������",$_SERVER['PHP_SELF']);
	} 

	if ($result!=OK) {
		errorReturn('�������󣬽�ϵͳ����Ա��debug', $_SERVER['PHP_SELF']);
	}
		echo "�����޸ĳɹ���";
		return true;
	} 
	
?>
<FORM action="<? echo $_SERVER['PHP_SELF']; ?>" method="post">
<INPUT type="hidden" name="changeUserPasswd">
<table>
<tbody>
<tr>
<td>����Ա�˺�</td>
<td><? echo $id; ?></td>
</tr>
<tr>
	<td>���������</td>
	<td><input type=password name="passwd"></td>
</tr>
<tr>
	<td>����������</td>
	<td><input type=password name="passwd1"></td>
</tr>
<tr>
	<td>ȷ��������</td>
	<td><input type=password name="passwd2"></td>
</tr>

</tbody>
</table>
<INPUT type="submit" value="�ύ�޸���Ϣ">
</form>
<?php

}


changeUserPasswd();

?>
</div>
</BODY>
</HTML>