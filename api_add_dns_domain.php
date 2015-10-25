/** 
*   api_add_dns_domain  -  (c)2015 detain@interserver.net InterServer Hosting
*
* Adds a new domain into our system.  The status will be "ok" if it added, or
* "error" if there was any problems status_text will contain a description of the
* problem if any.
*
* @param sid string the *Session ID* you get from the [api_login](#api_login) call
* @param domain string domain name to host
* @param ip string ip address to assign it to.
*/
ini_set("soap.wsdl_cache_enabled", "0");
$fields = array();
$cmdfields = array();
$values = array();
$show_help = false;
$cmdfields[] = 'username';
$cmdfields[] = 'password';
$cmdfields[] = 'domain';
$cmdfields[] = 'ip';
for ($x = 1; $x < $_SERVER['argc']; $x++) 

	if (in_array($_SERVER['argv'][$x], array('--help', '-h', 'help')))
	{
		$show_help = true;
		break;
	}
	else
		$values[$fields[$x - 1]] = $_SERVER['argv'][$x]; 

	if ($_SERVER['argc'] < 5)
		$show_help = true;
	if ($show_help == true)
		exit(<<<EOF
api_add_dns_domain

Adds a new domain into our system.  The status will be "ok" if it added, or
* "error" if there was any problems status_text will contain a description of the
* problem if any.

Correct Syntax: {$_SERVER["argv"][0]}  <username> <password> <domain> <ip>

	<username>  Your Login name with the site
	<password>  Your password used to login with the site
	<domain>  Must be a string
	<ip>  Must be a string

EOF
); 

try {
	$client = new SoapClient("https://my.interserver.net/api.php?wsdl"); 
	$sid = $client->api_login($values['username'], $values['password']);
	if (strlen($sid)  == 0) die("Got A Blank Sessoion");
	echo "Got Session ID $sid\n";
	$values['sid'] = $sid;
	$response = $client->api_add_dns_domain($values['sid'], $values['domain'], $values['ip']);
	print_r($response);
	echo "Success\n";
 } catch (Exception $ex) {
	echo "Exception Occured!\n";
	echo "Code:{$ex->faultcode}\n";
	echo "String:{$ex->faultstring}\n";
}; 