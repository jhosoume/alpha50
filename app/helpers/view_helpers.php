<?php 
use Spark\TemplateEngine AS renderer; 

function render_file($path){
  renderer::render_file($path);
}

function load_template($path) {
	echo(file_get_contents(Spark\get_root_dir() . '/app/views/templates' . $path));
}
