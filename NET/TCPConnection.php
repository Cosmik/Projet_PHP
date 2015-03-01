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

	/*
	* Démarre une instance socket pour intercepter les connexions entrantes.
	*
	* @params: string $adressIP
	* @params: int $port
	*
	* @return Affection de l'instance socket dans la variable $socketMaster
	*/
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
			\ProjetNameEnvironment\Logging\Logging::WriteError($error->getMessage());
		}
		finally
		{
			if($this->socketMaster != null)
			{
				\ProjetNameEnvironment\Logging\Logging::WriteLine("[%s] > Le serveur ecoute sur le port %s:%s", array(__FUNCTION__, $addressIP, $port));
				array_push(self::$socketListener, $this->socketMaster);
			}
			else
				\ProjetNameEnvironment\Logging\Logging::WriteLine("[%s] Le serveur n'a pas pu demarrer, merci de verifier les logs d'erreurs", array( __FUNCTION__));

		}
	}

	/*
	* Ecoute et traite les sockets entrantes
	*
	* @return Traitement des packets
	*/
	public function Listener()
	{
		$read = self::$socketListener;
		socket_select($read, $write = null, $except = null, null);

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
		        	\ProjetNameEnvironment\Logging\Logging::WriteLine("[%s] >> %s", array(__FUNCTION__, $buffer));

		        	if(substr($buffer, 0, 22) == "<policy-file-request/>")
		        	{
		        		$buff = '<?xml version="1.0"?>
								<!DOCTYPE cross-domain-policy SYSTEM "/xml/dtds/cross-domain-policy.dtd">
								<cross-domain-policy>
								<allow-access-from domain="*" to-ports="1-31111" />
								</cross-domain-policy>'.chr(0);
		        		socket_write($socketIncoming, $buff, strlen($buff));
		        	}
		        	else if(substr($buffer, 0, 4) == "@MUS")
		        	{
		        		
		        	}
		        }
	    	}
	    }
	}
}
