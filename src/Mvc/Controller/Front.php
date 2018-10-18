<?php
namespace Mvc\Controller;

use \Mvc\Http\Request as Request;
use \Mvc\Http\Response as Response;
use \Mvc\Router as Router;
use \Mvc\Dispatcher as Dispatcher;

/**
 * Classe représentant le contrôleur frontal
 *
 * @uses Singleton
 * @uses Trait
 * @uses methode magique __clone
 *
 * @author juliencharpentier
 */
class Front
{
    /**
     * Utilisation d'un trait permettant la gestion de la requête
     */
    use Request\AwareTrait;

    /**
     * Utilisation d'un trait permettant la gestion de la réponse
     */
    use Response\AwareTrait;

    /**
     * Routeur
     *
     * @var Router
     */
    protected $_router = null;

    /**
     * Distributeur
     *
     * @var Dispatcher
     */
    protected $_dispatcher = null;

    /**
     * Tableau des paramètres propagés dans le MVC
     *
     * @var array
     */
    protected $_mvcParams = array();

    /**
     * Ajoute ou modifie un paramètre
     *
     * @param string $name
     * @param mixed $value
     *
     * @return mixed objet utilisant le trait
    */
    public function setParam($name, $value)
    {
        $name = (string) $name;
        $this->_mvcParams[$name] = $value;

        return $this;
    }

    /**
     * Ajout des paramètres
     *
     * @param array $parametres
     *
     * @return mixed objet utilisant le trait
     */
    public function setParams(array $parametres)
    {
        $this->_mvcParams = array_merge($this->_mvcParams, $parametres);

        return $this;
    }

    /**
     * Récupère un paramètre
     *
     * @param string $name
     *
     * @return mixed valeur du parametre ou NULL
     */
    public function getParam($name)
    {
        if (isset($this->_mvcParams[$name])) {
            return $this->_mvcParams[$name];
        }

        return null;
    }

    /**
     * Récupère tous les paramètres
     *
     * @return array
     */
    public function getParams()
    {
        return $this->_mvcParams;
    }

    /**
     * Distribue la requête HTTP à un couple controleur/action
     *
     * @return Response
     */
    public function run()
    {
        /*
         * Initialise les composants
         */

        //---- initialise l'objet requête
        $this->getRequest(true)
             ->setBaseUrl(\Mvc\Application::getBaseUrl());

        //---- initialise l'objet routeur
        $this->_router = new Router();

        //---- initialise l'objet réponse
        $this->getResponse(true);

        //---- initialise l'objet distributeur
        $this->_dispatcher = new Dispatcher();
        $this->_dispatcher->setResponse($this->_response);

        /*
         * Distribue
         */

        //---- effectue le routage
        $this->_router->route($this->_request);

        try {
            //---- distribue la requête
            $this->_dispatcher->dispatch($this->_request, $this->_response);

        } catch (Exception $e) {
            echo $e;
        }

        //---- envoi la réponse HTTP
        $this->_response->send();
    }
}