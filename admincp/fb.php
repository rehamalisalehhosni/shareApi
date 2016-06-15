<?php 
include '../hloun/config.php';
include 'src/facebook.php';
$settings = $SQL->getSettings();
$config = array();
$config['appId'] = $settings->app_id;
$config['secret'] = $settings->app_key;
$config['fileUpload'] = false; // optional
$facebook = new Facebook($config);
if(isLogin()){
    if(isset($_POST['id']) && $_POST['id'] !='')
    {
        $id = abs(intval($_POST['id']));
        $sql = mysql_query("select * from posts where id=".$id);
        $data = mysql_fetch_object($sql);
        $text = stripslashes($data->text);
        $idb   = $data->id;
        mysql_query("update posts set send='1' where id=".$idb);
        
        $users=  mysql_query("select * from users");
        if(mysql_num_rows($users)>=1)
        {   $send = false;  
            $post['message'] = $text;
            if($data->type==1)
            {
            $post['link'] = stripslashes($data->link);
            }
            $names = '';
            while($row=mysql_fetch_assoc($users))
            {
                $userid = $row['user_id'];
                $post['access_token'] = $row['access'];
                $name = $row['name'];
                try {
                $add= $facebook->api('/'.$userid.'/feed','post',$post);
                $send = true;
                $names .= $name."<br>";
             } catch (FacebookApiException $e) { 
                 error_log('Could not post image to Facebook.'); 
                 
                 }

                
            }
            if($send==true)
            {
            echo json_encode(array('st'=>'done','msg'=>'تم النشر بنجاح'.$names));    
            }else{
            echo json_encode(array('st'=>'error','msg'=>'يبدو ان السيرفر لديك لا يدعم الخواص المطلوبة'));
            }
            
        }else{
            echo json_encode(array('st'=>'error','msg'=>'لا يوجد لديك اعضاء !'));
        }
        
    }
}else{
    header("HTTP/1.0 404 Not Found");
}    
?>