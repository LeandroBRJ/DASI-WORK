<?php
/**
 * Created by PhpStorm.
 * User: leandro_da_silva
 * Date: 24/10/18
 * Time: 09:44
 */
namespace Mvc\Http\Reponse;

trait AwareTrait
{
    protected $_reponse;

    /**
     * @return mixed
     */
    public function getReponse($create = false)
    {
        if(is_null($this->_reponse)&& true===$create ){
            $this->setReponse(new Mvc\Http\Reponse);
        }
        return $this->_reponse;
    }

    /**
     * @param mixed $request
     */
    public function setReponse(Mvc\Http\Reponse $reponse)
    {
        $this->_reponse = $reponse;
    }
}

?>