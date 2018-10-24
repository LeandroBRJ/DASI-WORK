<?php
/**
 * Created by PhpStorm.
 * User: leandro_da_silva
 * Date: 24/10/18
 * Time: 09:44
 */
    namespace Mvc\Http\Request;

    trait AwareTrait
    {
        protected $_request;

        /**
         * @return mixed
         */
        public function getRequest($create = false)
        {
            if(is_null($this->_request)&& true===$create ){
                $this->setRequest(new Mvc\Http\Request);
            }
            return $this->_request;
        }

        /**
         * @param mixed $request
         */
        public function setRequest(Mvc\Http\Request $request)
        {
            $this->_request = $request;
        }

    }

?>


