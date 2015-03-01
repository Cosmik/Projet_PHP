<?PHP
/*
* ProjetName
* Habbo R63 Post-Shuffle
* Based on the work of Burak and Jordan
*
* https://github.com/Cosmik/Projet_PHP
*/
namespace ProjetNameEnvironment\NET\TCPConnectionManager;

class TCPConnectionManager
{
	public $clients = array();

	public function AddClient($socketClient)
	{
		// On vérifie qu'il n'existe pas de ressource identique
		if(!in_array($socketClient, static::$socketListener))
			array_push(static::$socketListener, $socketClient);

		// On vérifie qu'il n'existe pas le même client
		if(!in_array($socketClient, $this->clients))
			array_push($this->clients, $socketClient);

		printf("[%s] >> Added user from %s\n", __FUNCTION__, $socketClient);
	}

	public function RemoveClient($socketClient)
	{
		// On vérifie que la ressource existe bien avant de la supprimer
		if(in_array($socketClient, static::$socketListener))
			array_splice(static::$socketListener, array_search($socketClient, static::$socketListener));

		// On vérifie que le client existe bien avant de le supprimer
		if(in_array($socketClient, $this->clients))
			array_splice($this->clients, array_search($socketClient, $this->clients));

		// On ferme la connexion aux serveurs
		socket_close($socketClient);

		printf("[%s] >> Removed user from %s\n", __FUNCTION__, $socketClient);
	}

	/* GETTERS // SETTERS */
	public function __get($var)
	{
		if(isset($this->$var))
			return $this->$var;
	}

	public function __set($var, $newValue)
	{
		if(isset($this->$var))
			$this->$var = $newValue;
	}
}