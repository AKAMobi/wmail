<?php
require_once("vpopadm.inc.php");

	if (!adminPerm(PERM_ADMIN_ADMINCONTROL) ){
?>
		<br>
		��û�з��ʸ���ҳ��Ȩ�ޡ�<br>
<?php
		exit(0);
	}


?>
account,note,changePasswdURL,modifyPrivilidgeURL,deleteURL
<?php

		$id=getAdminID();
		$adminList=getAdminList();
		for( $i = 0 ; $i < count($adminList) ; $i++)
		{
			$adminID=$adminList[$i]['id'];
			$note=$adminList[$i]['note'];
			$changePasswdURL="changeAdminPasswd.php?id={$adminID}";
			$modifyPrivilidgeURL="modifyAdminPrivilidge.php?id={$adminID}";
			$deleteURL="deleteAdmin.php?id={$adminID}";
			echo "$adminID, $note, $changePasswdURL, $modifyPrivilidgeURL, $deleteURL"; 
			if ($i<count($adminList)-1) 
				echo "\n";
		}

?> 
