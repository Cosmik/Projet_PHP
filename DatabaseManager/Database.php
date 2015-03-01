<?PHP
/*
* ProjetName
* Habbo R63 Post-Shuffle
* Based on the work of Burak and Jordan
*
* https://github.com/Cosmik/Projet_PHP
*/
namespace ProjetNameEnvironment\DatabaseManager\Database;

class Database extends \Thread
{
	public function run()
	{
		\ProjetNameEnvironment\Logging\Logging::WriteLine("Thread running..", array());
	}
}