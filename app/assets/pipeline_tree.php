<?php
namespace Spark;
class PipelineTree extends PipelineTreeBase {

	function import_js() {
		$this->import_file(__DIR__ . '/vendor/js/jquery-2.2.4.min.js');
		$this->import_dir(__DIR__ . '/vendor/js/');
		$this->import_dir(__DIR__);
	}

	function import_css() {
		$this->import_file(__DIR__ . '/vendor/css/materialize.min.css');
		$this->import_dir(__DIR__ . '/vendor/css/');
		$this->import_dir(__DIR__);
	}

}