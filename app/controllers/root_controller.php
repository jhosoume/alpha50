<?php
class RootController extends Spark\BaseController {
	public function index() {
		Spark\TemplateEngine::set_layout('/layouts/landing.php');
		$this->render("index.php");
	}
}