<?php 
include 'hloun/config.php';
$settings = $SQL->getSettings();
include 'admincp/src/facebook.php';
$config = array();
$config['appId'] = $settings->app_id;
$config['secret'] = $settings->app_key;
$config['fileUpload'] = false; // optional
$facebook = new Facebook($config);
$user = $facebook->getUser();
if($user)
{
      $user_profile = $facebook->api('/me');
      $access = $facebook->getAccessToken();
      $id   =  $user_profile['id'];	
      $name= mysql_escape_string(htmlspecialchars($user_profile['name']));
      $date   = time();
      $sql = mysql_query("select * from users where user_id='$id'");
	if(mysql_num_rows($sql))
		{
                 mysql_query("update users set access='$access',date='$date' where user_id='$id'");
		}else{
		 mysql_query("insert into users (name,user_id,access,date) values ('$name','$id','$access','$date')");
		}
		
      
      
}else{
    
}

?>
<script>
            window.close();
            window.opener.location.reload();
            </script> 