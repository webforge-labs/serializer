<?php

use Psc\Boot\BootLoader;
use Doctrine\Common\Annotations\AnnotationRegistry;

/**
 * Bootstrap and Autoload whole application
 *
 * you can use this file to bootstrap for tests or bootstrap for scripts / others
 */
$ds = DIRECTORY_SEPARATOR;

require_once __DIR__.$ds.'lib'.$ds.'package.boot.php';
$bootLoader = new BootLoader(__DIR__);
$bootLoader->loadComposer();
//$bootLoader->registerContainer();
$bootLoader->registerPackageRoot();

// we don't want to have this in the autoloading section of the composer.json because we only use this in tests
$bootLoader->getAutoLoader()->add('ACME', 'lib', $prepend = TRUE);
AnnotationRegistry::registerLoader(array($bootLoader->getAutoLoader(), 'loadClass'));