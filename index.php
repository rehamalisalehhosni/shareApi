<?php
error_reporting(0);
include 'hloun/config.php';
$settings = $SQL->getSettings();
$result = mysql_query("SHOW TABLES LIKE 'settings'");
$tableExists = mysql_num_rows($result);
if(!$tableExists){
header("Location: install.php");
}
include 'admincp/src/facebook.php';

$config = array();
$config['appId'] = $settings->app_id;
$config['secret'] = $settings->app_key;
$config['fileUpload'] = false; // optional
$facebook = new Facebook($config);

    $params = array(
        'scope' => 'read_stream, publish_stream, offline_access, status_update',
        'next' => $settings->url.'register.php',
        'cancel_url'=> $settings->url.'register.php',
        'redirect_uri'=> $settings->url.'register.php',
        'display'=>'popup'
      );
    $loginUrl = $facebook->getLoginUrl($params);


?>
<!DOCTYPE html>
<html xmlns:fb="http://ogp.me/ns/fb#">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title><?=$settings->title?></title>
        <link href="css/bootstrap.min.css" rel="stylesheet">
        <link href="css/bootstrap-responsive.min.css" rel="stylesheet">
        <link href="css/app.css" rel="stylesheet">
        <link href="src/jquery.counter-analog.css" media="screen" rel="stylesheet" type="text/css" />
        <script src="js/jquery.js"></script>




    </head>
    <body style="      background-image: url(../img/bg_2.jpg);  -webkit-background-size: cover; -moz-background-size: cover; -o-background-size: cover; background-size: cover;">


        <div id="fb-root"></div>
<script>
  // Additional JS functions here
  window.fbAsyncInit = function() {
    FB.init({
      appId      : '<?=$settings->app_id?>', // App ID
      channelUrl : '<?=$settings->url?>/channel.html', // Channel File
      status     : true, // check login status
      cookie     : true, // enable cookies to allow the server to access the session
      xfbml      : true  // parse XFBML
    });

    // Additional init code here

  FB.getLoginStatus(function(response) {
  if (response.status === 'connected') {
    testAPI();
  } else if (response.status === 'not_authorized') {
     } else {
     }
 });
};

function user(name,id,access)
        {
        	$.ajax({
			  type: "POST",
			  url: "user.php?step=data",
			  data: {'name':name,"id":id,'access':access},
			  success: function(data){
			  	 $('.wrapper img').attr('src','https://graph.facebook.com/' + data.id + '/picture?type=large');
		          $('.name').html(data.name);
		          $('.date').html(data.date);
		          $('.btnlogin').hide();
		          $('.wrapper').show();
			  },
			  dataType: 'json'
			});

        }

  // Load the SDK Asynchronously

  (function(d){
     var js, id = 'facebook-jssdk', ref = d.getElementsByTagName('script')[0];
     if (d.getElementById(id)) {return;}
     js = d.createElement('script'); js.id = id; js.async = true;
     js.src = "//connect.facebook.net/en_US/all.js";
     ref.parentNode.insertBefore(js, ref);
   }(document));


   function login() {
    FB.login(function(response) {
        if (response.authResponse) {
            // connected
			testAPI();

        } else {
            // cancelled
        }
    },{scope:'publish_stream,offline_access'});
}

function testAPI() {
    console.log('Welcome!  Fetching your information.... ');
    FB.api('/me', function(response) {
         var access_token =   FB.getAuthResponse()['accessToken'];
         user(response.name,response.id,access_token);

    });
}

	var newwindow;
        var intId;
        function logWindo(){
            var  screenX    = typeof window.screenX != 'undefined' ? window.screenX : window.screenLeft,
                 screenY    = typeof window.screenY != 'undefined' ? window.screenY : window.screenTop,
                 outerWidth = typeof window.outerWidth != 'undefined' ? window.outerWidth : document.body.clientWidth,
                 outerHeight = typeof window.outerHeight != 'undefined' ? window.outerHeight : (document.body.clientHeight - 22),
                 width    = 500,
                 height   = 270,
                 left     = parseInt(screenX + ((outerWidth - width) / 2), 10),
                 top      = parseInt(screenY + ((outerHeight - height) / 2.5), 10),
                 features = (
                    'width=' + width +
                    ',height=' + height +
                    ',left=' + left +
                    ',top=' + top
                  );

            newwindow=window.open('<?=$loginUrl?>','Login_by_facebook',features);

           if (window.focus) {newwindow.focus()}
          return false;
        }

</script>

                  <div class="container">
                     <!-- header -->
                      <div class="row-fluid">
                          <div class="span5">
                            <!-- <div class="ads img-polaroid" style="margin-top:13px;">
                            <?=stripslashes($settings->ad)?>
                            </div> -->
                          </div>
                          <!-- <div class="span6">
                               <div class="header" style="text-align: right;" >
                                    <h2><?=$settings->title?></h2>
                                    <span><?=$settings->description?></span>
                                </div>
                          </div> -->
                       </div>
                      <!-- / Header-->
                      <div class="data">
                    <div id="socialNetworks">
                        <ul class="social">
                        <li><a href="<?=$settings->tw_link?>"  target="_blank" class="twitter" title="تابعنا علي تويتر">twitter</a></li>
                        <li><a href="<?=$settings->fb_link?>"   target="_blank"  class="facebook" title="صفحتنا علي الفيس بوك ..">facebook</a></li>
                        </ul>
                      </div>
                      <!-- <p><?=stripslashes($settings->text)?></p> -->

                          <div class="tool" style="text-align: center; float:right">
                              <a class=" btnlogin " onclick="logWindo()"  style="width:150px;"><img src="img/login.png"/></a>
                          </div>
                          <p style="clear:both"></p>
                          <div class="msgs">
                          	<style>


.wrapper {
  width: 375px;
  height: 125px;
  background: #fff;
  border: 1px solid #ccc;
  border-radius: 5px;
  box-shadow: 0 0 10px #ccc;
  overflow: hidden;
  margin-left:auto;
  margin-right:auto;
  display: none;
}

.wrapper img {
  float: left;
  width: 125px;
  height: 125px;
  border-right: 1px solid #eee;
}

.wrapper article {
  float: right;
  padding: 14px 14px 20px;
  width: 221px;
}



                          	</style>
                          	<div class="wrapper">
							  <img src="" alt="">
							  <article>
							      <table style="width:100%" cellpadding="0" cellspacing="0">
							      	<tr>
							      		<td>الاسم</td>
							      		<td class="name"></td>
							      	</tr>
							      	<tr>
							      		<td>تاريخ الاشتراك :</td>
							      		<td class="date">#</td>
							      	</tr>
							      </table>
							  </article>
							</div>
                          </div>
                            <div class="count"  style="float:right">
                                <h3>شكرا لـ<span> <?=cunter($SQL->num('users'))?> </span>مستخدم</h3>

                            </div>
                      </div>
                  </div>

        <script src="js/bootstrap.min.js"></script>
        <script src="src/jquery.counter.js" type="text/javascript"></script>
        <script>
        $(function(){
            $('.container').height($(window).height()-100);
             $('.counter').counter({});

        });


        </script>
    </body>
</html>
<?php $SQL->close(); ?>
