<?PHP
/*
* ProjetName
* Habbo R63 Post-Shuffle
* Based on the work of Burak and Jordan
*
* https://github.com/Cosmik/Projet_PHP
*/
namespace ProjetNameEnvironment;

require_once 'Logging/Logging.php';
use ProjetNameEnvironment\Logging\Logging as Logging;

\ProjetNameEnvironment\Logging\Logging::WriteLine("Lancement de %s en cours..\n", array("ProjetName"));

function LoadEnvironment()
{
	\ProjetNameEnvironment\Logging\Logging::WriteLine("[%s] > Chargement de l'environnement..", array(__NAMESPACE__));
	try
	{
		$folders = array(
			"NET", 
			"DatabaseManager", 
			"HabboHotel"
						);

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

						\ProjetNameEnvironment\Logging\Logging::WriteLine("[%s] > Chargement du fichier %s..", array($folderName, substr($fileName, 0, -4) . "Manager.php"));
					}

					require_once $fileName;
					array_push($fileIncluded, $fileName);

					\ProjetNameEnvironment\Logging\Logging::WriteLine("[%s] > Chargement du fichier %s..", array($folderName, $fileName));
				}
			}
		}
	}
	catch(Exception $e)
	{
		\ProjetNameEnvironment\Logging\Logging::WriteError($e->getMessage());
	}
	finally
	{
		\ProjetNameEnvironment\Logging\Logging::WriteLine("[%s] > %s fichiers ont etaient ajoutes au serveur\n", array(__NAMESPACE__, count($fileIncluded)));
	}
}
LoadEnvironment();

use ProjetNameEnvironment\NET\TCPConnection\TCPConnection as TCPConnection;
use ProjetNameEnvironment\DatabaseManager\Database\Database as Database;
use ProjetNameEnvironment\HabboHotel\Game\Game as Game;

Logging::SetTitle("ProjetName est entrain de demarrer..");

$game = new Game();

$tcpConnection = new TCPConnection();
$tcpConnection->InitializeSocket("127.0.0.1", 3001);

while(is_resource($tcpConnection->socketMaster))
{
	$tcpConnection->Listener();
}
?>