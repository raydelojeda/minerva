<?php


function sess_open($sess_path, $session_name){
global $_SEC_SESSION;
$sess_sec=ini_get('session.name')."_sec";

# Apart from the session cookie we set another one, with the same name plus
# '_sec' at the end
# On that cookie, we set a random 32byte string (I'll refer to this string 
# as 'key')

if (!isset($_COOKIE[$sess_sec])){
$md5=md5(uniqid(''));
setcookie($sess_sec,$md5,ini_get('session.cookie_lifetime'),
ini_get('session.cookie_path'),
ini_get('session.cookie_domain'));
$_SEC_SESSION['int']['key']=$_COOKIE[$sess_sec]=$md5;
$_SEC_SESSION['data']=serialize(array());
$empty=1;
}else{
$_SEC_SESSION['int']['key']=$md5=$_COOKIE[$sess_sec];
}

# The name of the file that contains the session info,
# starts with 'sec_sess_' and it's followed by the md5 string of the
# session_id concatenated with the previous key.
# This avoids people of reading the ID of the session from the session files 
# (to hijack the session)

$_SEC_SESSION['int']['filename']=$filename_sec="$sess_path/sec_sess_".md5(session_id().$md5);
if (isset($empty)){
return 1;
}
if (!file_exists($filename_sec)){
fclose(fopen($filename_sec,'w'));
}
if (!$_SEC_SESSION['int']['fd']=fopen($filename_sec,'r')){
$_SEC_SESSION['data']=serialize(array());
return 0;
}

# The data on that file is dedrypted using the previous key

$data_enc=fread($_SEC_SESSION['int']['fd'],filesize($filename_sec));
fclose($_SEC_SESSION['int']['fd']);
if ($data_enc!=''){
$cipher=MCRYPT_DES;
$data=@mcrypt_ecb($cipher,$_SEC_SESSION['int']['key'],$data_enc,MCRYPT_DECRYPT);
}else{$data='';}
$_SEC_SESSION['data']=$data;
$_SEC_SESSION['int']['hash']=md5($_SEC_SESSION['data']);
return 1;
}
function sess_close(){
return true;
}
function sess_read($key){
return $GLOBALS['_SEC_SESSION']['data'];
}
function sess_write($id,$data){
global $_SEC_SESSION;
$sd=$data;
if ($_SEC_SESSION['int']['hash'] != md5($sd)){
$fd=fopen($_SEC_SESSION['int']['filename'],'w');
$cipher=MCRYPT_DES;
# Here we crypt the data with our key...
$data=@mcrypt_ecb($cipher,$_SEC_SESSION['int']['key'],$sd,MCRYPT_ENCRYPT);
fputs($fd,$data);
fclose($fd);
chmod($_SEC_SESSION['int']['filename'],0600);
}

}
function sess_destroy($key){
return(@unlink($GLOBALS['_SEC_SESSION']['int']['filename']));
}
function sess_gc($maxlifetime){}

session_set_save_handler('sess_open','sess_close','sess_read','sess_write','sess_destroy','sess_gc');
//session_start();
if (!isset($_SESSION['times'])){
$_SESSION['times']=0;
}
$_SESSION['times']++;
print "This session ID is: ".session_id().
" but the name of the file that contains the data is <br><br><br>".
$_SEC_SESSION['int']['filename']."n";

print "Btw, this is the ".$_SESSION['times']." you see this page ;) (it works!)n<br><br><br>";



foreach ($_SESSION as $index => $value) {
    echo __FILE__ . __LINE__ . " $index: $value<br>";
}

?>