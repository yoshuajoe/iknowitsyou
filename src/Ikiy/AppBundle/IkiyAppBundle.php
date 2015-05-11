<?php

namespace Ikiy\AppBundle;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class IkiyAppBundle extends Bundle {
	public function __construct()
	{
		if(!defined('BUNDLE_SEPARATOR')) define('BUNDLE_SEPARATOR', ':');    
	}

    public function build(ContainerBuilder $container) {
        parent::build($container);
    }
}
