<?PHP
/*
* 
* 
* 
*
* 
*
* 
*/
namespace ProjetNameEnvironment;

function LoadEnvironment()
{
	$folders = array("NET");
	foreach($folders as $folderName)
	{
		foreach(glob($folderName . "/*.php") as $fileName)
		{
			require $fileName;
		}
	}
}
LoadEnvironment();

use ProjetNameEnvironment\NET\TCPConnection\TCPConnection as TCPConnection;

$tcpConnection = new TCPConnection();
$tcpConnection->TEST();
?>