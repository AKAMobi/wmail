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

	if (!adminPerm(PERM_ADMIN_ADMINCONTROL) ){
?>
		<br>
		��û�з��ʸ���ҳ��Ȩ�ޡ�<br>
<?php
		return false;
	}



	if ( isset($_REQUEST["changeUserPasswd"])){ //ʵ���޸��û���Ϣ

	$selfID=getAdminID();

	$id=$_REQUEST['adminID'];

	if ($selfID==$id) {
		errorReturn("�����������޸��Լ���Ȩ��", "showadminlist.php");
	}
	


	if ($id=='') {
		errorReturn("����δ�������Ա�˺�",$_SERVER['PHP_SELF']);
	}

	if ($id==SYSOPID) {
		errorReturn("��������Ȩ�޸���߹���Ա". SYSOPID ."��Ȩ��","showadminlist.php");
	}

       $privilidge=PERM_ADMIN_BASIC;

        if (isset($_POST['userControl'])) {
                $privilidge |=PERM_ADMIN_USERCONTROL;
        }

        if (isset($_POST['adminControl'])) {
                $privilidge |=PERM_ADMIN_ADMINCONTROL;
        }

	$result=modifyAdminPrivilidge($id,$privilidge);	
	

	if ( ($result==ERR_FORMAT_PRIVILIDGE) ){
		errorReturn("�������������ϵͳ����Ա",$_SERVER['PHP_SELF']);
	}

	if ( ($result==ERR_FORMAT_ID) || ($result==ERR_NOSUCHID) ){
		session_unset();
		session_destroy();
		errorReturn("�޴˹���Ա�˺�,����������",$_SERVER['PHP_SELF']);
	} 
	
	if ($result!=OK) {
		errorReturn('�������󣬽�ϵͳ����Ա��debug', $_SERVER['PHP_SELF']);
	}
		echo "Ȩ���޸ĳɹ���";
		return true;
	} 
	
?>
<FORM action="<? echo $_SERVER['PHP_SELF']; ?>" method="post">
<INPUT type="hidden" name="changeUserPasswd">
<table>
<tbody>
<tr>
<td>����Ա�˺ţ�</td>
<td><input type=hidden name="adminID" value="<?php echo $_REQUEST['id']; ?>"><?php echo $_REQUEST['id']; ?></td>
</tr>
<tr>
        <td align="right" >����Ȩ�ޣ�</td><td>
                <input type=checkbox name=userControl >�û�����<br>
                <input type=checkbox name=adminControl >����Ա����<br>
        </td>
<tr>
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
