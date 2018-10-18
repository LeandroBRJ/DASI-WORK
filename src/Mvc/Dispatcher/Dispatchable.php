<?php
namespace Mvc\Dispatcher;

use Mvc\Http\Request as Request;
use Mvc\Http\Response as Response;

/**
 *
 * @author juliencharpentier
 *
 */
interface Dispatchable
{
    /**
     * Distribue un couple controleur/action à partir de la requête
     * Puis, rempli l'objet Response à l'aide de la réponse de l'action
     *
     * @param  Request $request
     * @param  Response $response
     * @return void
     */
    function dispatch(Request $request, Response $response);
}
