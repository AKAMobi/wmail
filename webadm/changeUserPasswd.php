<?
require_once("vpopadm.inc.php");
?>
<HTML>
<HEAD>
<meta http-equiv="content-type" content="text/html; charset=gb2312">
<TITLE>�޸��˻���Ϣ</TITLE>
</HEAD>
<BODY>
<DIV align="center">
<?

function changeUserPasswd() {

	if (!adminPerm(PERM_ADMIN_USERCONTROL) ){
?>
		<br>
		��û�з��ʸ���ҳ��Ȩ�ޡ�<br>
<?php
		return false;
	}

$passwd_file = VPOPMAILHOME . 'domains/' . DOMAIN . '/vpasswd';

$user_profile = VPOPMAILHOME . 'domains/' . DOMAIN . '/' . USERPROFILE;



if (!isset($_REQUEST['id'])){
?>
	����:δָ���û��˺ţ�
<?
	return false;
} 

	if ( isset($_REQUEST["changeUserPasswd"])){ //ʵ���޸��û���Ϣ

	$passwd1 = $_REQUEST['passwd1'];						
	$passwd2 = $_REQUEST['passwd2'];
    if (!eregi( "^[0-9a-z]+$", $passwd1 )) {
    	echo  "���������к��зǷ��ַ�<br>";
    	return false;
    }
    if ( $passwd1 != $passwd2 ) {
    	echo "����������������벻ƥ��<br>";
    	return false;
    }

		$user_list = file( $passwd_file );
	 	
	    $mail_count=count($user_list);
		for( $i = 0 ; $i < $mail_count ; $i++)
		{
			list( $user_account, $xxx, $xxx, $xxx, $xxx, $xxx, $xxx )  = explode( ':', $user_list[$i] );
			if (!strcmp($user_account, $_REQUEST['id'])){
				   	system( VPOPMAILHOME . 'bin/vpasswd ' . $user_account . "@" . DOMAIN . ' ' . $passwd1 .' > /dev/null', $add_result );
				break;
			}
		}
	
		if ($i<$mail_count){
?>
	�˺������޸ĳɹ���<br>
<?
		} else {
?>
	����δ�ҵ��˺�Ϊ<? echo $_REQUEST['id'] ;?>���û���Ϣ<br>
<?
		}		
		return true;
	} 
	
	//��ʾ�û���Ϣ


	$user_list = file( $passwd_file );
 	
    $mail_count=count($user_list);
	for( $i = 0 ; $i < $mail_count ; $i++)
	{
		list( $user_account, $xxx, $xxx, $xxx, $user_name, $xxx, $user_quota )  = explode( ':', $user_list[$i] );
		if (!strcmp($user_account, $_REQUEST['id'])){
			break;
		}
	}
	if ($i<$mail_count){
?>

<FORM action="<? echo $_SERVER['PHP_SELF']; ?>" method="post">
<INPUT type="hidden" name="changeUserPasswd">
<table>
<tbody>
<tr>
<td>�˺�</td>
<INPUT type="hidden" name="id" value="<? echo $user_account; ?>">
<td><? echo $user_account; ?></td>
</tr>
<tr>
<td>����</td>
<td><? echo $user_name; ?></td>
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
	} else {
?>
	����δ�ҵ��˺�Ϊ<? echo $_REQUEST['id'] ;?>���û���Ϣ
<?
	}
}


changeUserPasswd();

?>
</div>
</BODY>
</HTML>