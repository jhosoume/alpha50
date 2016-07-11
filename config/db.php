<?php

ActiveRecord\Config::initialize(function($cfg)
{
    $cfg->set_model_directory(Spark\get_root_dir() . '/app/models');
    $cfg->set_connections(array(
        'development' => 'mysql://root:@localhost/development_db',
		'production' => 'mysql://root:@localhost/production_db',
	));
    	
	$cfg->set_default_connection(Spark\get_environment());
});