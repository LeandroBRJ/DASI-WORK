<?php
namespace Mvc\Http;

use \Mvc\Dispatcher\Dispatchable;
use \Mvc\Http\Request as Request;
use \Mvc\Http\Response as Response;

/**
 * Classe représentant le distributeur
 *
 * @uses Trait
 * @uses class_exists
 * @uses instanceof
 *
 * @author juliencharpentier
 */
class Dispatcher implements Dispatchable
{
    /**
     * Utilisation d'un trait permettant la gestion de la réponse
     */
    use Response\AwareTrait;

    /**
     * Distribue un couple contrôleur/action
     *
     * @param \Mvc\Controller\Request $request
     * @param \Mvc\Controller\Response $response
     *
     * @throws \Mvc\Controller\Dispatcher\Exception
     */
    public function dispatch(Request $request, Response $response)
    {
        //---- stocke l'objet réponse
        $this->setResponse($response);

        /*
         * Si la classe n'existe pas, redirection vers le controleur d'erreur
         */
        if (!$this->_isDeliverable($request)) {
            $request->setController('error');
            $request->setAction('404');
            $response->setHttpCode(404);
        }

        /*
         * Charge le controleur
         */
        $controller = $this->_loadController($request, $response);

        /*
         * Récupère le nom de la méhode
         */
        $action = $this->_getActionMethod($request);

        /*
         * Appel de la méthode
         */
        try {
            ob_start();
            $controller->run($action);
            $content = ob_get_clean();
        } catch (Dispatcher\Exception $e) {
            ob_get_clean();
            throw $e;
        }

        /*
         * Ajout du contenu au corps de la réponse
         */
        $response->setBody($content);
    }

    /**
     * Vérifie qu'une requête est distribuable
     * Ssi : la nom de la classe est valide et elle existe
     *
     * @param Request $action
     *
     * @return boolean
     */
    protected function _isDeliverable(Request $request)
    {
       /*
        * Récupère la classe du contrôleur à instancier
        */
        $sClassName = $this->_getControllerClass($request);

        /*
         * Teste si le fichier correspondant à déjà été inclus
         */
        if (class_exists($sClassName, false)) {
            return true;
        }

        /*
         * Teste l'existence du fichier
         */
        $sFile = Application::getPathControllers() . $sClassName . '.php';

        return file_exists($sFile);
    }

    /**
     * Determine la méthode de l'action
     *
     * @param Request $request
     *
     * @return string|false
     */
    protected function _getControllerClass(Request $request)
    {
        $sControllerName = $request->getController();
        if (empty($sControllerName)) {
            $sControllerName = Application::getDefaultController();
            $request->setController($sControllerName);
        }

        $sControllerName = strtolower($sControllerName) . 'Controller';

        return $sControllerName;
    }

    /**
     * Charge une classe de contrôleur
     *
     * @param Request $request
     * @param Response $response
     *
     * @return string
     *
     * @throws Dispatcher\Exception
     */
    protected function _loadController(Request $request, Response $response)
    {
        /*
         * Récupère la classe du contrôleur à instancier
         */
        $sClassName = $this->_getControllerClass($request);

        /*
         * Teste l'existence du fichier si la classe n'a été chargée précédemment
        */
        if (!class_exists($sClassName, false)) {

            $sFile = Application::getPathControllers() . $sClassName . '.php';

            if (file_exists($sFile)) {
                include_once $sFile;
            } else {
                throw new Dispatcher\Exception("$sFile n'est pas lisible");
            }
            if (!class_exists($sClassName, false)) {
                throw new Dispatcher\Exception("$sClassName n'est pas un controleur valide");
            }
        }

        /*
         * Instancie le controleur
         */
        $controller = new $sClassName($request, $response);
        if (!($controller instanceof Controller\Action)) {
            throw new Dispatcher\Exception("$sClassName : ce controleur est incorrect");
        }

        return $controller;
    }

    /**
     * Determine la méthode de l'action
     *
     * @param Request $request
     *
     * @return string
     */
    protected function _getActionMethod(Request $request)
    {
        $action = $request->getAction();
        if (empty($action)) {
            $action = Application::getDefaultAction();
            $request->setAction($action);
        }

        return '___' . strtolower($action);
    }
}