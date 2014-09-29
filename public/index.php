<?php

require_once __DIR__.'/../vendor/autoload.php';

function dd()
{
	array_map('var_dump', func_get_args()); die;
}

(new Deployer\Deployer)->goDoYourThang();
