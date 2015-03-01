<?PHP
/*
* ProjetName
* Habbo R63 Post-Shuffle
* Based on the work of Burak and Jordan
*
* https://github.com/Cosmik/Projet_PHP
*/
namespace ProjetNameEnvironment\HabboHotel\Game;

class Game extends \Worker
{
	private $gameLoopSleepTime = 25; // 25 ms
	private $gameLoopActive = false;
	private $gameLoopEnded  = false;

	public function __construct()
	{
		\ProjetNameEnvironment\Logging\Logging::WriteLine("[Game %s] > Initialisation des classes en cours..", array(__FUNCTION__));
		//$this->gameLoopActive = true;
		//$this->start();
	}

	public function run()
	{
		while($this->gameLoopActive)
		{
			try
			{
				usleep($this->gameLoopSleepTime);
			}
			catch(Exception $e)
			{
				\ProjetNameEnvironment\Logging\Logging::WriteError($e->getMessage());
			}
		}
	}
}