<?php
class RootController extends Spark\BaseController {
	public function index() {
		$this->render("index.php");
	}
}