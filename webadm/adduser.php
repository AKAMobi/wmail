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
		if (!adminPerm(PERM_ADMIN_USERCONTROL) ){
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
	if (!isset($_REQUEST['user_name'])){ 
		echo "����δ�����û�����<br>";
		return false;
	}
	if (!isset($_REQUEST['user_unit'])){ 
		echo "����δ�����û����ڵ�λ<br>";
		return false;
	}
	if (!isset($_REQUEST['user_department'])){ 
		echo "����δ�����û����ڲ���<br>";
		return false;
	}
	if (!isset($_REQUEST['user_station'])){ 
		echo "����δ�����û���λ<br>";
		return false;
	}
	if (!isset($_REQUEST['user_id_code'])){ 
		echo "����δ�����û�֤������<br>";
		return false;
	}

	if (!isset($_REQUEST['user_box_size'])){ 
		echo "����δ���������С<br>";
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
	if ($_REQUEST['user_name']==''){ 
		echo "����δ�����û�����<br>";
		return false;
	}
    if ( !ereg("^[0-9]+$", $_REQUEST['user_box_size'])){
    	echo "�����û������Сδָ�����䲻����Ч���֡�:��<br>";
    	return false;
    }

	
	$user_id = $_REQUEST['user_id'];		//�û�ID
	$passwd1 = $_REQUEST['passwd1'];						
	$passwd2 = $_REQUEST['passwd2'];
	$user_name = $_REQUEST['user_name'];	//�û�����
	$user_unit = $_REQUEST['user_unit'];		//�û���λ
	$user_department = $_REQUEST['user_department']; 	//�û�����
	$user_station = $_REQUEST['user_station']; 		//�û���λ
	$user_id_code = $_REQUEST['user_id_code'];		//�û�֤������
	$user_note = $_REQUEST['user_note'];		//�û�֤������
	$user_is_public = isset($_REQUEST['user_is_public']);
	$user_box_size = 1024 * 1024 * (intval($_REQUEST['user_box_size']) );

	if ($user_box_size<0) {
		$user_box_size=0;
	}

	if ($user_unit==''){
		$user_unit=' ';
	}
	if ($user_department==''){
		$user_department=' ';
	}
	if ($user_station==''){
		$user_station=' ';
	}
	if ($user_id_code==''){
		$user_id_code=' ';
	}
    if (!ereg( "^[a-z][_0-9a-z\.]*$", $user_id )) { //
        echo "�����û�ID�к��зǷ��ַ�<br>";
        return false;
    }
    if (!eregi( "^[0-9a-z]+$", $passwd1 )) {
    	echo  "���������к��зǷ��ַ�<br>";
    	return false;
    }
    if ( $passwd1 != $passwd2 ) {
    	echo "����������������벻ƥ��<br>";
    	return false;
    }
    
    if ( !ereg("^[^:]+$", $user_name)){
    	echo "�����û������к��зǷ��ַ���:��<br>";
    	return false;
    }

    if ( !ereg("^[^:]*$", $user_unit)){
    	echo "�����û���λ�к��зǷ��ַ���:��<br>";
    	return false;
    }
    
    if ( !ereg("^[^:]*$", $user_department)){
    	echo "�����û������к��зǷ��ַ���:��<br>";
    	return false;
    }
    
    if ( !ereg("^[^:]*$", $user_station)){
    	echo "�����û���λ�к��зǷ��ַ���:��<br>";
    	return false;
    }
    
    if ( !ereg("^[^:]*$", $user_id_code)){
    	echo "�����û�֤�������к��зǷ��ַ�������<br>";
    	return false;
    }
    if ( !ereg("^[^:]*$", $user_note)){
    	echo "���󣺱�ע�к��зǷ��ַ�������<br>";
    	return false;
    }

   	$user_profile = VPOPMAILHOME . 'domains/' . DOMAIN . '/' . USERPROFILE;
   	
    $h_user_profile = fopen ($user_profile,"a+");
   
    if ($h_user_profile == NULL ){
        echo "�����û������ļ��޷��򿪡�<br>";
		exit(-1);
    }
   
    flock($h_user_profile, LOCK_EX);
    
//��vpopmailϵͳ��������û�
   	system( VPOPMAILHOME . 'bin/vadduser -c "' . $user_name . '" -q ' . $user_box_size . ' ' . $user_id . "@" . DOMAIN . ' "'  . $passwd1 . '" > /dev/null', $add_result );
/* �������Ƿ�ɹ�
   	if ($add_result!=0) {
   		echo "�����û�id�Ѵ���<br>";
	   	flock($h_user_profile, LOCK_UN);
   		return false;
   	}
*/
	
	fseek($h_user_profile,0, SEEK_SET);
 	
   	while (!feof($h_user_profile)){
	    $userinfo = fgets($h_user_profile,1024); 
	    list ($id, $unit, $department, $station, $id_code, $create_time , $is_public, $note) = explode( ':', $userinfo);
	    if (!strcmp($id,$user_id)){
	    	echo "�����û�id�Ѵ��ڣ�<br>";
		   	flock($h_user_profile, LOCK_UN);
	    	return false;
	    }
	}


	
	$user_create_time=date("Y-m-d");
   	
   	$userinfo=implode(":",array($user_id, $user_unit, $user_department, $user_station, $user_id_code, $user_create_time,$user_is_public, $user_note));
   	
	$userinfo .= "\n";
	
   	fseek($h_user_profile, 0, SEEK_END );
	
	fputs($h_user_profile,$userinfo);
   	
   	flock($h_user_profile, LOCK_UN);
   	
   	fclose($h_user_profile);
   	
	return true;
}

if ( (isset($_REQUEST['addUser']) && addUser()) ){
	echo "�û� ${_REQUEST['user_id'] }�Ѿ��ɹ����룡<br>";
} else {


?>
<center>
<form action="<? echo $_SERVER['PHP_SELF']; ?>" method=post>
<INPUT type="hidden" name="addUser">
<table border=0>
<tr align="center" bgcolor=#6fa6e6>
<td colspan="2" class=title><b>������û�</b></td>
</tr>
<tr>
	<td>���ʺ�����<input type=text name="user_id" value="<? echo $_REQUEST['user_id'] ?>">
	</td>
	<td><font color=#ff0000>��ʹ��СдӢ����ĸ���������ʺ���������ʹ��Ӣ����ĸ��ͷ��</font></td>
</tr>
<tr>
	<td>�������룺<input type=password name="passwd1"></td>
	<td><font color=#ff0000>��ʹ�ô�СдӢ����ĸ��������Ϊ�ʼ����롣</font></td>
</tr>
<tr>
	<td>ȷ�����룺<input type=password name="passwd2"></td>
	<td><font color=#ff0000>���ٴ��������룬�������������ͬ��</font></td>
</tr>
<tr>
	<td>�û�������<input type=text name="user_name" value="<? echo $_REQUEST['user_name'] ?>"></td>
	<td><font color=#ff0000>�û���������</font></td>
</tr>
<tr>
	<td>�û���λ��<input type=text name="user_unit" value="<? echo $_REQUEST['user_unit'] ?>"></td>
	<td><font color=#ff0000>�û����ڵĵ�λ��</font></td>
</tr>
<tr>
	<td>�û����ţ�<input type=text name="user_department" value="<? echo $_REQUEST['user_department'] ?>"></td>
	<td><font color=#ff0000>�û����ڵĲ��š�</font></td>
</tr>
<tr>
	<td>�û���λ��<input type=text name="user_station" value="<? echo $_REQUEST['user_station'] ?>"></td>
	<td><font color=#ff0000>�û��ĸ�λ��</font></td>
</tr>
<tr>
	<td>�û�֤�����룺<input type=text name="user_id_code" value="<? echo $_REQUEST['user_id_code'] ?>"></td>
	<td><font color=#ff0000>�û���֤�����롣</font></td>
</tr>
<tr>
<?
	if (isset($_REQUEST['user_box_size'])) {
		$user_box_size=$_REQUEST['user_box_size'];
	} else {
		$user_box_size=$DEFAULTMAILBOXSIZE;
	}
?>
	<td>�����С��M����<input type=text name="user_box_size" value="<? echo $user_box_size ?>"></td>
	<td><font color=#ff0000>�û��������С��</font></td>
</tr>
<tr>
	<td><input type=checkbox name="user_is_public" <? echo ($user_is_public?'checked':''); ?>>������ʾ</td>
	<td><font color=#ff0000>�Ƿ񹫿�������ʾ�ڹ����ʼ��б���</font></td>
</tr>
<tr>
	<td>��ע��<input type=text name="user_note" value="<? echo $user_note ?>"></td>
	<td><font color=#ff0000></font></td>
</tr>
<tr align="center" >
	<td colspan=2><input type=submit name="adduser" value="  ȷ  ��  ">
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
