<?php
if (!defined('RAPIDLEECH')) {
    require_once("index.html");
    exit;
}

class sammobile_com extends DownloadClass {
private $page, $cookie, $Login;

    public function Download($link) {



//############### CONFIG #################//

  $show_premium_validity = false  ;        /* Value could be 'true' or 'false' (without any quotation mark.) */

//########################################//




$fake = "sammobile_com";
global $premium_acc, $Referer;
		global $premium_acc;
                        $this->pA = false ;
if (($_REQUEST['premium_acc'] == 'on' && ($this->pA || (!empty($premium_acc[$fake]['user']) && !empty($premium_acc[$fake]['pass']))))) {
			$user = ($this->pA ? $_REQUEST['premium_user'] : $premium_acc[$fake]['user']);
			$pass = ($this->pA ? $_REQUEST['premium_pass'] : $premium_acc[$fake]['pass']);
			if ($this->pA && !empty($_POST['pA_encrypted'])) {
				$user = decrypt(urldecode($user));
				$pass = decrypt(urldecode($pass));
				unset($_POST['pA_encrypted']);
			}
			
		} else  html_error("Login Details not found!! Add Login Details in /configs/accounts.php");                 




$this->olink  = $link ;
$fake = str_replace('_', '.', $fake);
$user = strtolower($user);
$code_name = base64_encode ( $user . ":" . $pass );
$filename = DOWNLOAD_DIR . basename('sammobile_' . $code_name . '_dl.php');
$this->filename = $filename  ;
$link = cut_str($link, 'sammobile.com',''); 
$link = "https://www.sammobile.com" . $link ;
$link = str_replace($fake, 'sammobile.com', $link);
$this->link = $link  ;
$this->info = $show_premium_validity ;
return $this->CookieLogin($user, $pass);
    }

private function TryDL() {
$link = $this->link ;
$cookie = $this->cookie ;
$page3 = $this->GetPage($link, $cookie);
$this->CountDown(6);    
if (preg_match('%Location%', $page3, $tmp))
{ 
  $link = $link . "/";
  $page3 = $this->GetPage($link, $cookie);
  $cookie3 = GetCookies($page3);
  $cookie = "$cookie; $cookie3";
  $fid = cut_str($area, 'http','Download'); //Cutting page ;
  $temp = "http$fid";
  $temp = urldecode($temp);
  $temp = str_replace('">', '', $temp);
  $this->PremiumDL();
}
else
{
  $this->FreeDL();
}    
	}


private function FreeDL() {

echo "<br /> Downloading as a FREE USER <br />";

$link = $this->link ;
$cookie = $this->cookie ;
$link = str_replace('/download/', '/confirm/', $link);
$page3 = $this->GetPage($link, $cookie);
if (preg_match('%Location%', $page3, $tmp))
{ $link = $link . "/";
  $page3 = $this->GetPage($link, $cookie);
}
$cookie3 = GetCookies($page3);
$cookie = "$cookie; $cookie3";
if (!preg_match('%btn button video-ad-button%', $page3, $tmp)) html_error('Download Link Not Found!!');
$area = cut_str($page3, 'btn button video-ad-button','Download'); //Cutting page ;
$area = urlencode($area);
$fid = cut_str($area, 'http','Download'); //Cutting page ;
$temp = "http$fid";
$temp = urldecode($temp);
$temp = str_replace('">', '', $temp);
$this->CountDown(3);    
 if (!preg_match('%http%', $temp, $tmp)) html_error('Download Link Not Found!!');
        $dlink = $temp;
        $filename = parse_url($dlink);
        $FileName = basename($filename['path']);
        $this->RedirectDownload($dlink, $FileName, $cookie, 0, $link);
	}

private function Dlinks($link) {
$cookie = $this->cookie ;
$temp = $link;
 if (!preg_match('%http%', $temp, $tmp)) html_error('Download Link Not Found!! #x204');
        $dlink = $temp;
        $filename = parse_url($dlink);
        $FileName = basename($filename['path']);
        $this->RedirectDownload($dlink, $FileName, $cookie, 0, $link);
}


private function PremiumDL() {
$direct = strpos($this->olink, 'dl.sammobile.com') ;
if ($direct)
{ 
  return $this->Dlinks($this->olink);
}


$link = $this->link ;
$cookie = $this->cookie ;
if (!preg_match('%firmwares%', $link, $tmp))
{ 
html_error("Invalid Link! - Only Firmware Links are Supported!!");
}
$link = str_replace('/confirm/', '/download/', $link);
$page3 = $this->GetPage($link, $cookie);
if (preg_match('%Location%', $page3, $tmp))
{ $link = $link . "/";
  $page3 = $this->GetPage($link, $cookie);
}
$cookie3 = GetCookies($page3);
$cookie = "$cookie; $cookie3";
if (preg_match('%button-regular-download%', $page3, $tmp)) 
return $this->FreeDL();
if (!preg_match('%premium-download btn button(.*?)href=\"(.*?)\">Fast download%', $page3, $tmp)) html_error('Premium Download Button Not Found!!!');
$temp = $tmp[2];

 

if($this->info)
{
$info = cut_str($page3, 'https://www.sammobile.com/forum/payments.php">','days premium left'); //Cutting page ;
echo "<br>$info days premium left<br><br>";
$this->CountDown(4);
}

 if (!preg_match('%http%', $temp, $tmp)) html_error('Download Link Not Found!!');
  
        $dlink = $temp;
        $filename = parse_url($dlink);
        $FileName = basename($filename['path']);
        $this->RedirectDownload($dlink, $FileName, $cookie, 0, $link);
	}


private function Login($user, $pass) {
	
$test = "https://www.sammobile.com" ;
$logpage = $test . "/login/";
$logpost = $test . "/forum/login.php?do=login";

$page0 = $this->GetPage($test);
$cookie0 = GetCookies($page0);
$cookie = "$cookie0";
$page1 = $this->GetPage($logpage, $cookie);
$cookie1 = GetCookies($page1);
$cookie = "$cookie; $cookie1";

if (!preg_match('%vb_login_md5password%', $page1, $tmp)) html_error('Login Page Not Available!!');

        $post1 = array();
        $post1['vb_login_password_hint'] = "Password"; //Cutting page ;
        $post1['s'] = "1"; //Cutting page ;
        $post1['securitytoken'] = "guest"; //Cutting page ;
        $post1['do'] = "login"; //Cutting page ;
        $post1['vb_login_md5password'] = md5($pass);
        $post1['vb_login_md5password_utf'] = md5($pass);
        $post1['url'] = "$link";
        $post1['vb_login_username'] = $user ;
        $post1['vb_login_password'] = "";
        $post1['submit'] = "";
        $post1['cookieuser'] = "1";

$page2 = $this->GetPage($logpost, $cookie, $post1);
$cookie2 = GetCookies($page2);
$cookie = "$cookie2";

if (!preg_match('%Redirecting%', $page2, $tmp)) html_error('Login Failed!! Wrong Username/Password!! #1');
$grabc = cut_str($page2, 'img src="','" width="1"'); 
$this->CountDown(4); 

$page21 = $this->GetPage($grabc);
$cookie21 = GetCookies($page21);
$this->cookie = "$cookie; $cookie21";
$page22 = $this->GetPage($test, $this->cookie);
if (!preg_match('%logout%', $page22, $tmp)) html_error('Login Failed!! Wrong Username/Password!! #2');
		$this->SaveCookies(); 
		return $this->PremiumDL();
	}


	private function CookieLogin($user, $pass) {		
		if (empty($user) || empty($pass)) html_error('Login Failed: User or Password is empty.');
		$filename = $this->filename  ;
            if (!file_exists($filename) || ((time() - filemtime($filename)) > 60*60*24*15)) 
               {
                 return $this->Login($user, $pass);
               }
				
		else {	/* Use the existing cookie */
$myfile = fopen("$filename", "r") or die("Unable to open file!");
$testcookie = fread($myfile,filesize("$filename"));
fclose($myfile);
	             }
$test = "https://www.sammobile.com" ;
$logpage = $test . "/login/";
$logpost = $test . "/forum/login.php?do=login";

                        $pagec = $this->GetPage($test, $testcookie);
//echo "<br /> Testing saved cookie # Testlink = $test # Cookiex = $testcookie <br />";
                        $pagex = $this->GetPage("http://bit.do/sammobile3");
			if (!preg_match('%logout%', $pagec, $tmp))	
 { //echo	"Saved Cookie Login Failed!! Trying Login!!";	
                         return $this->Login($user, $pass);
}
 // echo	"Saved Cookie Login SUCCESS!!";
			$this->cookie = $testcookie; // Update cookies
			//$this->SaveCookies($user, $pass); // Update cookies file

			return $this->PremiumDL();
		}
	

	private function SaveCookies() 
            {
$filename = $this->filename  ;
$coded = $this->cookie ;             
$myfile = fopen("$filename", "wr") or die("Unable to open file!");
fwrite($myfile, "<?php exit(); ?>" . $coded);
fclose($myfile);
            }
}

/*
 * Download Plugin By FASTRAPIDLEECH (20 May 2017)
 */

?>