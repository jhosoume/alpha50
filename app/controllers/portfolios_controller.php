<?php
class PortfoliosController extends Spark\BaseController {
public function index() {
  // array below is dummy data for test purposes
    $stocks = json_encode(array(
      array(
        'tic' => 'GOOG',
        'name' => "Google",
        'industry' => "Tech",
        'price' => "500.10"
        ),
      array(
        'tic' => 'TCK.B',
        'name' => "Teck",
        'industry' => 'materials',
        'price' => '10.00'
        ),
      array(
        'tic' => 'POT.',
        'name' => "Potash",
        'industry' => 'materials',
        'price' => '20.01')
      )
      );
    $this->locals = array(
      'stocks'=>$stocks,
    );
    $this->render("portfolios/index.php");
  }
}