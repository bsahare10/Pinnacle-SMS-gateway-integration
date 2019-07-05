<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Sms_api{
    
    protected $ci;

    private static $base_url = 'http://www.smsjust.com/sms/user/urlsms.php';		//base api uri
	private static $user = 'username';		//username
	private static $pass = 'password';	    //password
	private static $senderid = 'senderid';		//sender id
	private static $senderstring = 'www.sample.com';		//sender string
	

	public function __construct()
	{
		$this->ci =& get_instance();    
	}


	public static function send_sms($mobile,$message){
    
        $url = self::$base_url;
        $param = "username=".self::$user."&pass=".self::$pass."&senderid=".self::$senderid."&dest_mobileno=".$mobile."&message=".$message."&response=Y";
        
        $ch = curl_init();
        if (!$ch){
            die("Couldn't initialize a cURL handle");
        }
        
        $ret = curl_setopt($ch, CURLOPT_URL,$url);
        curl_setopt ($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        //curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
        curl_setopt ($ch, CURLOPT_POSTFIELDS,$param);
        $ret = curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
     
        $curlresponse = curl_exec($ch); // execute
        if(curl_errno($ch))
            echo 'curl error : '. curl_error($ch);
        if (empty($ret)) {
            die(curl_error($ch));
            curl_close($ch); // close cURL handler
        } else {
            $info = curl_getinfo($ch);
            curl_close($ch); // close cURL handler
            //echo $curlresponse; 
        }

    }

    public static function otp_sms($first_name = "Badal",$otp = "123456"){
        $encodeStr = urlencode('Dear '.$first_name.', '.$otp.' is your OTP code for MySampleTool Account. It is confidential, Please do not share this OTP with anyone. \ '.self::$senderstring);
        return $encodeStr;
    }

    //further custom msg template here
    
}

