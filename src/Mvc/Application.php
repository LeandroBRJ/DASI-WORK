<?php
namespace Mvc;

/**
 * Classe représentant l'application
 *
 * @author juliencharpentier
 *
 * @uses methode magique __callStatic
 * @uses constantes
 * @uses propriété static
 * @uses self
 */
class Application
{
	/**
	 * Clés des options de l'application
	 *
	 * @var string
	 */
	const OPTION_APPLICATION_DIRECTORY = 'APPLICATION_DIRECTORY';
	const OPTION_CONTROLLERS_DIRECTORY = 'CONTROLLERS_DIRECTORY';
	const OPTION_VIEWS_DIRECTORY = 'VIEWS_DIRECTORY';
	const OPTION_PATH_CONTROLLERS = 'PATH_CONTROLLERS';
	const OPTION_PATH_VIEWS = 'PATH_VIEWS';
	const OPTION_DEFAULT_CONTROLLER = 'DEFAULT_CONTROLLER';
	const OPTION_DEFAULT_ACTION = 'DEFAULT_ACTION';
	const OPTION_BASE_URL = 'BASE_URL';

	/**
	 * Controleur frontal
	 *
	 * @var Controller\Frontal
	 */
	protected $_frontController;

	/**
	 * Options
	 *
	 * @var array
	 */
	protected static $_aOptions = array(
		self::OPTION_APPLICATION_DIRECTORY => 'application',
		self::OPTION_CONTROLLERS_DIRECTORY => 'controllers',
		self::OPTION_VIEWS_DIRECTORY => 'views',
		self::OPTION_DEFAULT_CONTROLLER => 'index',
		self::OPTION_DEFAULT_ACTION => 'index',
		self::OPTION_BASE_URL => '/',
	);

	/**
	 * Constructeur
	 *
	 * Initialise l'application
	 *
	 * @return void
	 */
	public function __construct($options = null)
	{
		require_once 'Mvc/Application/Loader.php';
		Application\Loader::initAutoload(__FILE__);

		$this->setOptions($options);
	}

	/**
	 * Défini les options de l'application
	 *
	 * @param  array $options
	 *
	 * @return Application
	 */
	public function setOptions(array $options)
	{
		if (is_array($options)) {
			$options = array_change_key_case($options, CASE_UPPER);
			self::$_aOptions = array_merge(self::$_aOptions, $options);
		}

		if (!array_key_exists(self::OPTION_PATH_CONTROLLERS, self::$_aOptions)) {
			$sChemin =
				self::$_aOptions[self::OPTION_APPLICATION_DIRECTORY] . DIRECTORY_SEPARATOR .
				self::$_aOptions[self::OPTION_CONTROLLERS_DIRECTORY] . DIRECTORY_SEPARATOR
			;
			self::$_aOptions[self::OPTION_PATH_CONTROLLERS] = str_replace(DIRECTORY_SEPARATOR . DIRECTORY_SEPARATOR, DIRECTORY_SEPARATOR, $sChemin);
		}

		if (!array_key_exists(self::OPTION_PATH_VIEWS, self::$_aOptions)) {
			$sChemin =
				self::$_aOptions[self::OPTION_APPLICATION_DIRECTORY] . DIRECTORY_SEPARATOR .
				self::$_aOptions[self::OPTION_VIEWS_DIRECTORY] . DIRECTORY_SEPARATOR
			;
			self::$_aOptions[self::OPTION_PATH_VIEWS] = str_replace(DIRECTORY_SEPARATOR . DIRECTORY_SEPARATOR, DIRECTORY_SEPARATOR, $sChemin);
		}

		if (!array_key_exists(self::OPTION_BASE_URL, $options)) {
			$url = explode('/', trim($_SERVER['PHP_SELF'], '/'));
			$chemin = explode('/', (isset($_SERVER['SCRIPT_FILENAME']) ? dirname($_SERVER['SCRIPT_FILENAME']) : ''));
			$sBaseUrl = '/' . implode('/', array_intersect($url, $chemin));
			self::$_aOptions[self::OPTION_BASE_URL] = $sBaseUrl;
		}

		return $this;
	}

	/**
	 * Lance l'application
	 *
	 * @param array $aParams
     *
     * @throws Application\Exception
	 */
	public function run(array $aParams = null)
	{
		/* @var $frontController Controller\Front */
		$frontController = $this->getFrontController();
        if (null === $frontController) {
            throw new Application\Exception('Erreur lors du chargement du controleur frontal');
        }
        if (is_array($aParams)) {
	        $frontController->setParams($aParams);
        }
        $frontController->run();
	}

	/**
	 * Retourne l'objet Controleur Frontal
	 *
	 * @return Controller\Frontal
	 */
	public function getFrontController()
	{
		if (null === $this->_frontController) {
			$this->_frontController = Controller\Front::getInstance();
		}

		return $this->_frontController;
	}

	/**
	 * Proxy vers le tableau d'option
	 *
	 * Méthode magique proxiant tout appel de propriété non existant
	 * vers l'array d'options qu'il contient.
	 *
	 * @param string $sMethod
	 * @param array $aArgs
	 *
	 * @throws Application\Exception
	 * @return mixed Tableau entier ou clé spécifique
	 */
	public static function __callStatic($sMethod, array $aArgs)
	{
		/*
		 * Récupère la bonne option
		 * si méthode = getApplicationRepertoire
		 * alors clé = APPLICATION_REPERTOIRE
		 */
		if ('get' !== substr($sMethod, 0, 3)) {
			throw new Application\Exception('Méthode inconnue');
		}
		$sKey = strtoupper(
			preg_replace(
				array('#(?<=(?:[[:upper:]]))([[:upper:]]+)([[:alpha:]])#', '#(?<=(?:[a-z0-9]))([[:upper:]])#'),
				array('\1_\2', '_\1'),
				substr($sMethod, 3)
			)
		);

		return self::$_aOptions[$sKey];
	}
}