/** 
*   api_vps_get_server_name  -  (c)2015 detain@interserver.net InterServer Hosting
*
* Get the name of the vps master/host server your giving the id for
*
* @param sid string the *Session ID* you get from the [api_login](#api_login) call
* @param id int id of the vps master
*/
ini_set("soap.wsdl_cache_enabled", "0");
$fields = array();
$cmdfields = array();
$values = array();
$show_help = false;
$cmdfields[] = 'username';
$cmdfields[] = 'password';
$cmdfields[] = 'id';
for ($x = 1; $x < $_SERVER['argc']; $x++) 

	if (in_array($_SERVER['argv'][$x], array('--help', '-h', 'help')))
	{
		$show_help = true;
		break;
	}
	else
		$values[$fields[$x - 1]] = $_SERVER['argv'][$x]; 

	if ($_SERVER['argc'] < 4)
		$show_help = true;
	if ($show_help == true)
		exit(<<<EOF
api_vps_get_server_name

Get the name of the vps master/host server your giving the id for

Correct Syntax: {$_SERVER["argv"][0]}  <username> <password> <id>

	<username>  Your Login name with the site
	<password>  Your password used to login with the site
	<id>  Must be a int

EOF
); 

try {
	$client = new SoapClient("https://my.interserver.net/api.php?wsdl"); 
	$sid = $client->api_login($values['username'], $values['password']);
	if (strlen($sid)  == 0) die("Got A Blank Sessoion");
	echo "Got Session ID $sid\n";
	$values['sid'] = $sid;
	$response = $client->api_vps_get_server_name($values['sid'], $values['id']);
	print_r($response);
	echo "Success\n";
 } catch (Exception $ex) {
	echo "Exception Occured!\n";
	echo "Code:{$ex->faultcode}\n";
	echo "String:{$ex->faultstring}\n";
}; 