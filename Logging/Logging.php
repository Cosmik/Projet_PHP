<?PHP
/*
* ProjetName
* Habbo R63 Post-Shuffle
* Based on the work of Burak and Jordan
*
* https://github.com/Cosmik/Projet_PHP
*/
namespace ProjetNameEnvironment\Logging;

class Logging
{
	/*
	* Affiche sur console un message
	*
	* @params string $string message à formater
	* @params array $params élément à formater dans la chaine
	*
	* @return Affichage sur console du message formaté
	*/
	public static function WriteLine($string, $params)
	{
		$string .= "\n";
		return call_user_func_array('printf', array_merge((array)$string, $params));
	}
}