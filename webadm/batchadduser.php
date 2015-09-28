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
global $DEFAULTMAILBOXSIZE;
		if (!adminPerm(PERM_ADMIN_USERCONTROL) )
	{
?>
		<br>
		��û�з��ʸ���ҳ��Ȩ�ޡ�<br>
<?php
		return false;
	}

//�ж��û���Ϣ��д�Ƿ�������
	if (!isset($_REQUEST['data'])){ 
		echo "����δ���������û�����<br>";
		return false;
	}
	$tmp_userlist=split("\n",$_REQUEST['data']);
	$userlist=array();
	foreach ($tmp_userlist as $user){
		if (trim($user)=='') {
			continue;
		}
		$usercontent=split(',',$user);
		$passwd=rand();
		$userlist[]=array('id'=>$usercontent[0],'name'=>$usercontent[1],'department'=>$usercontent[2],'unit'=>$usercontent[3],'station'=>$usercontent[4],'code'=>$usercontent[5],'passwd'=>$passwd,'boxsize'=>$DEFAULTMAILBOXSIZE);
	}



    

	foreach ($userlist as $user){
		$user_id = $user['id'];		//�û�ID
		$passwd = $user['passwd'];						
	    $user_name = $user['name'];	//�û�����
		$user_unit = $user['unit'];		//�û���λ
		$user_department = $user['department']; 	//�û�����
		$user_station = $user['station']; 		//�û���λ
		$user_id_code = $user['code'];		//�û�֤������
		$user_note = '';		//�û�֤������
		$user_is_public = 'N';
		$user_box_size = 1024 * 1024 * intval($user['boxsize']);

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
		if (!ereg( "^[A-Za-z][_0-9A-Za-z\.]*$", $user_id )) { //
			echo "�����û�ID {$user_id} �к��зǷ��ַ�<br>";
			return false;
		}

		
		if ( !ereg("^[^:]+$", $user_name)){
			echo "�����û����� {$user_name} �к��зǷ��ַ���:��<br>";
			return false;
		}

		if ( !ereg("^[^:]*$", $user_unit)){
			echo "�����û���λ {$user_unit} �к��зǷ��ַ���:��<br>";
			return false;
		}
		
		if ( !ereg("^[^:]*$", $user_department)){
			echo "�����û����� {$user_department}�к��зǷ��ַ���:��<br>";
			return false;
		}
		
		if ( !ereg("^[^:]*$", $user_station)){
			echo "�����û���λ {$user_station} �к��зǷ��ַ���:��<br>";
			return false;
		}
		
		if ( !ereg("^[^:]*$", $user_id_code)){
			echo "�����û�֤������ {$user_id_code} �к��зǷ��ַ�������<br>";
			return false;
		}
	}

   	$user_profile = VPOPMAILHOME . 'domains/' . DOMAIN . '/' . USERPROFILE;
   	
    $h_user_profile = fopen ($user_profile,"a+");
   
    if ($h_user_profile == NULL ){
        echo "�����û������ļ��޷��򿪡�<br>";
		exit(-1);
    }
   
    flock($h_user_profile, LOCK_EX);

	foreach ($userlist as $user){
		$user_id = $user['id'];		//�û�ID
		$passwd = $user['passwd'];						
	    $user_name = $user['name'];	//�û�����
		$user_unit = $user['unit'];		//�û���λ
		$user_department = $user['department']; 	//�û�����
		$user_station = $user['station']; 		//�û���λ
		$user_id_code = $user['code'];		//�û�֤������
		$user_note = '';		//�û�֤������
		$user_is_public = 'N';
		$user_box_size = 1024 * 1024 * intval($user['boxsize']);
		
		fseek($h_user_profile,0, SEEK_SET);
		$is_exist=false;
		while (!feof($h_user_profile)){
			$userinfo = fgets($h_user_profile,1024); 
			list ($id, $unit, $department, $station, $id_code, $create_time , $is_public, $note) = explode( ':', $userinfo);
			if (!strcmp($id,$user_id)){
				$is_exist=true;
				break;
			}
		}

		if ($is_exist){
			echo $user_name."���˺�".$user_id."�Ѵ���<br>\n";
			continue;
		}

		system( VPOPMAILHOME . 'bin/vadduser -c "' . $user_name . '" -q ' . $user_box_size . ' ' . $user_id . "@" . DOMAIN . ' "'  . $passwd . '" > /dev/null', $add_result );
		
		$user_create_time=date("Y-m-d");
		
		$userinfo=implode(":",array($user_id, $user_unit, $user_department, $user_station, $user_id_code, $user_create_time,$user_is_public, $user_note));
		
		$userinfo .= "\n";
		
		fseek($h_user_profile, 0, SEEK_END );
		
		fputs($h_user_profile,$userinfo);
	}
   	flock($h_user_profile, LOCK_UN);
   	
   	fclose($h_user_profile);

?>
<table>
<thead>
<th>�û�ID</th>
<th>�û�����</th>
<th>�û���λ</th>
<th>�û�����</th>
<th>�û���λ</th>
<th>�û�֤������</th>
<th>�û�����</th>
</thead>
<tbody>

<?php
	foreach ($userlist as $user){
		echo '<tr>';
		echo "<td>{$user['id']} </td>";
		echo "<td>{$user['name']} </td>";
		echo "<td>{$user['unit']} </td>";
		echo "<td>{$user['department']} </td>";
		echo "<td>{$user['station']} </td>";
		echo "<td>{$user['code']} </td>";
		echo "<td>{$user['passwd']} </td>";
		echo '</tr>';
	}
?>
</tbody>
</table>
<?php
  	
	return true;
}

if ( (isset($_REQUEST['addUser']) && addUser()) ){
	echo "�����û������Ѿ��ɹ����룡<br>";
} else {
	
?>
<center>
<form action="<? echo $_SERVER['PHP_SELF']; ?>" method=post>
<INPUT type="hidden" name="addUser">
<table border=0>
<tr align="center" bgcolor=#6fa6e6>
<td colspan="2" class=title><b>����������û�</b></td>
</tr>
<tr align="center" >
	<td colspan=2><textarea name="data" ></textarea>
	</td>
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
