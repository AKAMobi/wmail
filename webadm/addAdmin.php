<?
require_once("vpopadm.inc.php");
?>
<HTML>
<HEAD>
<meta http-equiv="content-type" content="text/html; charset=gb2312">
<TITLE>�û��б�</TITLE>
<style>

table { font-size:x-small;}

.title {font-size:medium;color:#ffffff;background-color:#6fa6e6;}
</style>
</HEAD>
<BODY>

<!-- Insert HTML here -->

<?

function addUser(){
	
	if (!adminPerm(PERM_ADMIN_ADMINCONTROL) ){
?>
		<br>
		��û�з��ʸ���ҳ��Ȩ�ޡ�<br>
<?php
		return false;
	}
//�ж��û���Ϣ��д�Ƿ�������
	if (!isset($_REQUEST['user_id'])){ 
		echo "����δ�����û�ID<br>";
		return false;
	}
	if (!isset($_REQUEST['passwd1'])){ 
		echo "����δ�����û�����<br>";
		return false;
	}
	if (!isset($_REQUEST['passwd2'])){ 
		echo "����δȷ�������û�����<br>";
		return false;
	}
	if (!isset($_REQUEST['user_note'])){ 
		echo "����δ���뱸ע<br>";
		return false;
	}

	if ($_REQUEST['user_id']==''){ 
		echo "����δ�����û�ID<br>";
		return false;
	}
	if ($_REQUEST['passwd1']==''){ 
		echo "����δ�����û�����<br>";
		return false;
	}
	if ($_REQUEST['passwd2']==''){ 
		echo "����δȷ�������û�����<br>";
		return false;
	}


	
	$user_id = $_REQUEST['user_id'];		//�û�ID
	$passwd1 = $_REQUEST['passwd1'];						
	$passwd2 = $_REQUEST['passwd2'];

	$user_note = $_REQUEST['user_note'];		//�û�֤������

    if ( $passwd1 != $passwd2 ) {
    	echo "����������������벻ƥ��<br>";
    	return false;
    }

	$privilidge=PERM_ADMIN_BASIC;

	if (isset($_POST['userControl'])) {
		$privilidge |=PERM_ADMIN_USERCONTROL;
	}

	if (isset($_POST['adminControl'])) {
		$privilidge |=PERM_ADMIN_ADMINCONTROL;
	}

	$result=addAdmin($user_id,$passwd1,$privilidge,$user_note);
	
	if ($result==ERR_FORMAT_PASSWORD) {
		errorReturn("���뺬�зǷ��ַ�,������",$_SERVER['PHP_SELF']);
	}
	if ($result==ERR_FORMAT_ID) {
		errorReturn("�˺ź��зǷ��ַ�,������",$_SERVER['PHP_SELF']);
	}
	if ($result==ERR_FORMAT_PRIVILIDGE) {
		errorReturn("Ȩ�����ô���,������",$_SERVER['PHP_SELF']);
	}
	if ($result==ERR_FORMAT_NOTE) {
		errorReturn("��ע�к��зǷ��ַ���:��,������",$_SERVER['PHP_SELF']);
	}
	if ($result==ERR_IDEXIST) {
		errorReturn("�û�ID�Ѵ���,������",$_SERVER['PHP_SELF']);
	}

	if ($result==OK){
		return true;
	} 
   	
	return false;
}

if ( (isset($_REQUEST['addUser']) && addUser()) ){
	echo "����Ա ${_REQUEST['user_id'] }�Ѿ��ɹ����룡<br>";
} else {


?>
<center>
<form action="<? echo $_SERVER['PHP_SELF']; ?>" method=post>
<INPUT type="hidden" name="addUser">
<table border=0>
<tr align="center" bgcolor=#6fa6e6>
<td colspan="3" class=title><b>����¹���Ա</b></td>
</tr>
<tr>
	<td align="right">�¹���Ա�ʺţ�</td><td><input type=text name="user_id" value="<? echo $_REQUEST['user_id'] ?>">
	</td>
	<td><font color=#ff0000>��ʹ��СдӢ����ĸ���������ʺ���������ʹ��Ӣ����ĸ��ͷ��</font></td>
</tr>
<tr>
	<td align="right">�������룺</td><td><input type=password name="passwd1"></td>
	<td><font color=#ff0000>��ʹ�ô�СдӢ����ĸ��������Ϊ�ʼ����롣</font></td>
</tr>
<tr>
	<td align="right">ȷ�����룺</td><td><input type=password name="passwd2"></td>
	<td><font color=#ff0000>���ٴ��������룬�������������ͬ��</font></td>
</tr>
<tr>
	<td align="right" >����Ȩ�ޣ�</td><td colspan=2>
		<input type=checkbox name=userControl >�û�����<br>
		<input type=checkbox name=adminControl >����Ա����<br>
	</td>
<tr>
	<td align="right">��ע��</td><td><input type=text name="user_note" value="<? echo $user_note ?>"></td>
	<td><font color=#ff0000></font></td>
</tr>
<tr align="center" >
	<td colspan=3><input type=submit name="adduser" value="  ȷ  ��  ">
		&nbsp;&nbsp;&nbsp;&nbsp;
	<input type=reset value="  ��  ��  ">
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
