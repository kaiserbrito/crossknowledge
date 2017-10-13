<?php
class ErrorController extends Controller {
	function __construct() {
		parent::__construct();
	}
	
	function index() {
		$this->view->msg = 'Esta página não existe.';
		$this->view->render('error/index');
	}
}