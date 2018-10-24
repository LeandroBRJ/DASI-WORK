<?php
/**
 * Created by PhpStorm.
 * User: leandro_da_silva
 * Date: 24/10/18
 * Time: 11:29
 */
    namespace Mvc\Router;

    interface RoutableInterface{
        public function route(\Mvc\Http\Request $route);
    }

?>