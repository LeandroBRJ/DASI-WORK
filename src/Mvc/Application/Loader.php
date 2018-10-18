<?php
namespace Mvc\Application;

/**
 * Classe gérant l'autoload au sein du système MVC
 * 
 * @author juliencharpentier
 */
class Loader
{
	/**
	 * Chemin de base du système MVC
	 * 
	 * @var string
	 */
	private static $_chemin;
	
	/**
	 * Constructeur
	 *
	 * Initialise le lazy-loading grâce à spl_autoload
	 *
	 * @return void
	 */
	public static function initAutoload($sChemin)
	{
		self::$_chemin = dirname($sChemin);
		spl_autoload_register(array(__CLASS__, 'autoload'));
	}
	
    /**
     * Charge en lazy-loading une classe demandée
     *
     * @param  string $class
     * @return bool
     */
    public static function autoload($class)
    {
    	$sCheminClasse = self::$_chemin . '/../' . str_replace('\\', '/', $class) . '.php';
        if (file_exists($sCheminClasse)) {
        	return include $sCheminClasse;
        }

        return false;
    }
}