<?php
namespace api;

class PortfoliosController extends \Spark\BaseController {
public function create() {
    $portfolio = new \Portfolio();
    $params = json_decode($this->params);
    $x = $params->id;
    $this->render($x, ['content_type'=>'JSON', 'enable_cors'=>true]);
  }
}