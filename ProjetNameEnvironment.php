<?PHP
/*
* ProjetName
* Habbo R63 Post-Shuffle
* Based on the work of Burak and Jordan
*
* https://github.com/Cosmik/Projet_PHP
*/
namespace ProjetNameEnvironment;

function LoadEnvironment()
{
	try
	{
		$folders = array("NET");
		$fileIncluded = array();
		foreach($folders as $folderName)
		{
			foreach(glob($folderName . "/*.php") as $fileName)
			{
				if(in_array($fileName, $fileIncluded) || in_array(substr($fileName, 0, -4) . "Manager.php", $fileIncluded))
				{
					continue;
				}
				else
				{
					// Inclure les fichiers de gestion avant les fichiers initiaux
					if(file_exists(substr($fileName, 0, -4) . "Manager.php"))
					{
						require_once substr($fileName, 0, -4) . "Manager.php";
						array_push($fileIncluded, substr($fileName, 0, -4) . "Manager.php");
					}

					require_once $fileName;
					array_push($fileIncluded, $fileName);
				}
			}
		}
	}
	catch(Exception $e)
	{
		printf("[ERROR in %s] %s", __FUNCTION__, $e->getMessage());
	}
	finally
	{
		printf("[%s] > %s elements ont ete ajoute pour le lancement de l'emulateur..\n", __NAMESPACE__, count($fileIncluded));
	}
}
LoadEnvironment();

use ProjetNameEnvironment\NET\TCPConnectionManager\TCPConnectionManager as TCPConnectionManager;
use ProjetNameEnvironment\NET\TCPConnection\TCPConnection as TCPConnection;

$tcpConnection = new TCPConnection();
$tcpConnectionManager = new TCPConnectionManager();
$tcpConnection->InitializeSocket("127.0.0.1", 3001);

while(is_resource($tcpConnection->socketMaster))
{
	$tcpConnection->Listener();
}
?>