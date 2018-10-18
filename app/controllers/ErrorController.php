<?php
/**
 * Controleur d'erreur
 *
 * @author juliencharpentier
 *
 */
class ErrorController extends \Mvc\Controller\Action
{
    public function ___404()
    {
    	$this->view->requestUri = htmlentities($_SERVER['REQUEST_URI']);
    }
}