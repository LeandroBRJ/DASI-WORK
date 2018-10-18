<?php
/**
 * Controleur d'index
 *
 * @author juliencharpentier
 *
 */
class IndexController extends \Mvc\Controller\Action
{
	/**
	 * Action index
	 */
	public function ___index()
	{
		//---- message à afficher dans la vue
		$this->view->message = 'Méthode : ' . __METHOD__ . '<br />';

		/*
		 * Si le formulaire a été posté, affichage de la valeur
		 */
		if ($this->getRequest()->isPost()) {
			$this->view->message .= 'Paramètres POST (age) : ' . $this->getRequest()->getPost('age') . '<br />';
		}
	}

	/**
	 * Action index
	 */
	public function ___info()
	{
		//---- closure gérant un print_r dans un heredoc
		$fPrintR = function ($var) {
			return print_r($var, true);
		};

		//---- message à afficher dans la vue
		$this->view->message = <<<MSG
Méthode : {$fPrintR(__METHOD__)}<br />
Paramètres MVC : {$fPrintR($this->getMvcParams())}<br />
Paramètres MVC (mvc_param1) : {$this->getMvcParams('mvc_param1')}<br />
Paramètres GET : {$fPrintR($this->getRequest()->getGet())}<br />
Paramètres GET (http_param1) : {$this->getRequest()->getGet('http_param1')}<br/>
MSG;
	}
}