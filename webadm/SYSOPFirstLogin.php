<?
require_once("vpopadm.inc.php");
?>
<HTML>
<HEAD>
<meta http-equiv="content-type" content="text/html; charset=gb2312">
<TITLE>��ʼ��<?php echo SYSOPID; ?>@<?php echo DOMAIN; ?>����</TITLE>
</HEAD>
<BODY>
<DIV align="center">
<?

function changeUserPasswd() {

$passwd_file = VPOPMAILHOME . 'domains/' . DOMAIN . '/vpasswd';

$user_profile = VPOPMAILHOME . 'domains/' . DOMAIN . '/' . USERPROFILE;

if ((!isset($_SESSION['SYSOPFirstLogin'])) && ($_SESSION['SYSOPFirstLogin']=='TRUE')){
?>
	����ҳֻ����ϵͳ��ʼ��!
<?
	return false;
} 

	if ( isset($_REQUEST["changeUserPasswd"])){ //ʵ���޸��û���Ϣ

	$passwd1 = $_REQUEST['passwd1'];						
	$passwd2 = $_REQUEST['passwd2'];
    if ( $passwd1 != $passwd2 ) {
    	echo "����������������벻ƥ��<br>";
    	return false;
    }

	$result=addAdmin(SYSOPID,$passwd1,PERM_ADMIN_MAX,'ϵͳ��߹���Ա');
	
	if ($result==ERR_FORMAT_PASSWORD) {
		errorReturn("���뺬�зǷ��ַ�,������",$_SERVER['PHP_SELF']);
	}
	if ($result==OK){
		$_SESSION['Privilidge']=PERM_ADMIN_MAX;
		$_SESSION['AdminID']=SYSOPID;
		unset($_SESSION['SYSOPFirstLogin']);
		errorReturn(SYSOPID . "�����ʼ���ɹ�","frames.php");
	} else {
?>
	ϵͳ���󡭡������ԣ���������ظ�����������ϵͳ����Ա
<?
		}		
		return true;
	} 
	

?>

<FORM action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
<INPUT type="hidden" name="changeUserPasswd">
<table>
<tbody>
<tr>
<td>ϵͳ��߹���Ա�˺�</td>
<td><?php echo SYSOPID; ?>@<?php echo DOMAIN; ?></td>
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
<?
}


changeUserPasswd();

?>
</div>
</BODY>
</HTML>
