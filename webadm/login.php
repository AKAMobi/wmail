<?php

require_once('vpopadm.inc.php');


if ((!isset($_REQUEST['adminID'])) || (!isset($_REQUEST['password'])) ){
?>
	<p>������<A HREF="index.php">��¼</a>��</p>
<?php
	exit();
}


$id=$_REQUEST['adminID'];
$passwd=$_REQUEST['password'];
$result=isPasswordRight($id,$passwd);


if ( ($result==ERR_FORMAT_PASSWORD) || ($result==ERR_WRONGPASSWORD) ){
	errorReturn("�������,����������","index.php");
}

$isSYSOPFirstLogin=false;
if ( ($result==ERR_FORMAT_ID) || ($result==ERR_NOSUCHID) ){
	if ($id!=SYSOPID) {
		errorReturn("�޴˹���Ա�˺�,����������","index.php");
	} else {
		$isSYSOPFirstLogin=true;
	}
}


if ($isSYSOPFirstLogin){
	$_SESSION['SYSOPFirstLogin']='TRUE';
	header("Refresh: 0;URL=SYSOPFirstLogin.php");
} else {
	if ($id==SYSOPID) {
		$_SESSION['Privilidge']=PERM_ADMIN_MAX;
	} else {
		$result=getAdminInfo($id);
		if ($result['$returnCode']!=OK){
			errorReturn("�޴˹���Ա�˺�,����������","index.php");
		}else {
			$_SESSION['Privilidge']=$result['privilidge'];
		}
	}

	$_SESSION['AdminID']=$id;
	header("Refresh: 0;URL=frames.php");
}
exit();

?>