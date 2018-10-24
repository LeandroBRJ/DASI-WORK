<?php
/**
 * Created by PhpStorm.
 * User: leandro_da_silva
 * Date: 24/10/18
 * Time: 13:52
 */

namespace Mvc\Controller\View;


interface ConfigurableInterface
{
    public function setVar($tab);
    public function getVars();
    public function clearVars();
}