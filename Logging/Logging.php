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

	/*
	 * Modifie le nom de l'application
	 *
	 * @params string @newName nouveau nom de l'application en cour
	 *
	 */
	public static function SetTitle($newName)
	{
		system("title " . $newName);
	}

	/*
	 * Permet de logger les erreurs dans un fichier
	*/
	public static function WriteError($string)
	{
		$errorLog = fopen('./error_log.txt', 'a+');
		$string .= "\n";
		fwrite($errorLog, $string);
		fclose($errorLog);

		self::WriteLine("[%s] Une erreur a ete enregistre dans les logs.", array(__FUNCTION__));
	}
}