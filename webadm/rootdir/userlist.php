<?
require_once("mailadm/vpopadm.inc.php");

$passwd_file = VPOPMAILHOME . 'domains/' . DOMAIN . '/vpasswd';

$user_profile = VPOPMAILHOME . 'domains/' . DOMAIN . '/' . USERPROFILE;

    $h_user_profile = fopen ($user_profile,"a+");
   
    if ($h_user_profile == NULL ){
        echo "�����û������ļ��޷��򿪡�<br>";
		exit(-1);
    }
   
    flock($h_user_profile, LOCK_SH);
    
    fseek($h_user_profile,0, SEEK_SET);

	$userinfo_list=array();

   	while (!feof($h_user_profile)){
	    $userinfo = fgets($h_user_profile); 
	    list ($id, $unit, $department, $station, $id_code, $create_time, $is_public, $note) = explode( ':', $userinfo);
		$isPublic=$is_public?'Y':'N';

	    array_push($userinfo_list,array("id" => $id,
	    								"unit" => $unit,
	    								"department" => $department,
	    								"station" => $station,
	    								"id_code" => $id_code,
	    								"create_time" => $create_time,
										"is_public" => $isPublic,
										"note" => $note)
	    );
	}

   	flock($h_user_profile, LOCK_UN);
   	
   	fclose($h_user_profile);
    

	$user_list = file( $passwd_file );
 	
    $mail_count=count($user_list);

?>
account,name,unit,department,station,idCode,createTime,quota,isPublic,note
<?
		for( $i = 0 ; $i < $mail_count ; $i++)
		{
			list( $user_account, $xxx, $xxx, $xxx, $user_name, $xxx, $user_quota )  = explode( ':', $user_list[$i] );
			$user_quota_num=$user_quota/1000000+0.5;
			list($unit, $department, $station, $id_code, $create_time,$is_public,$note)=array("","","","","","N","");
			for ($t=0; $t<count($userinfo_list); $t++){
				if (!strcmp($user_account, $userinfo_list[$t]['id'])) {
					break;
				} 
			}
			if ($t<count($userinfo_list)){
				$unit=rtrim($userinfo_list[$t]['unit']);
				$department=rtrim($userinfo_list[$t]['department']);
				$station=rtrim($userinfo_list[$t]['station']);
				$id_code=rtrim($userinfo_list[$t]['id_code']);
				$create_time=rtrim($userinfo_list[$t]['create_time']);
				$is_public=rtrim($userinfo_list[$t]['is_public']);
				$note=rtrim($userinfo_list[$t]['note']);
			}
			if ($is_public=='Y' ) {
				$account=$user_account . '@' . DOMAIN;
				echo "{$account},{$user_name},{$unit},{$department} \n";
			}
		}



