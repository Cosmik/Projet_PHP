<?PHP
/*
* ProjetName
* Habbo R63 Post-Shuffle
* Based on the work of Burak and Jordan
*
* https://github.com/Cosmik/Projet_PHP
*/
namespace ProjetNameEnvironment\NET\TCPConnection;

class TCPConnection extends \ProjetNameEnvironment\NET\TCPConnectionManager\TCPConnectionManager
{
	public $socketMaster = null;
	public static $socketListener = array();

	public function InitializeSocket($addressIP, $port)
	{
		try
		{
			$this->socketMaster = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
			socket_set_option($this->socketMaster, SOL_SOCKET, SO_REUSEADDR, 1);
			socket_bind($this->socketMaster, $addressIP, $port);
			socket_listen($this->socketMaster, 20);
		}
		catch(Exception $error)
		{

		}
		finally
		{
			if($this->socketMaster != null)
			{
				printf("[%s] > Le serveur ecoute sur le port %s:%s\n", __FUNCTION__, $addressIP, $port);
				array_push(self::$socketListener, $this->socketMaster);
			}
			else
				printf("[%s] Le serveur n'a pas pu demarrer, merci de verifier les logs d'erreurs\n", __FUNCTION__);

		}
	}

	public function Listener()
	{
		$read = self::$socketListener;

		if (socket_select($read, $write = NULL, $except = NULL, 0) >= 1)
		{
			foreach($read as $socketIncoming)
			{
		        if(in_array($this->socketMaster, $read))
		        {
		        	$newClient = socket_accept($this->socketMaster);

		        	if(is_resource($newClient) && $newClient > 0)
		        		parent::AddClient($newClient);
		        	else
		        		continue;
		       	}
		        else
		        {
		        	if(socket_recv($socketIncoming, $buffer, 2048, 0) <= 0)
		        		parent::RemoveClient($socketIncoming);
		        	else
		        	{
		        		printf("[INCOMING PACKET] %s\n", $buffer);
		        	}
		        }
	    	}
	    }
	}
}
