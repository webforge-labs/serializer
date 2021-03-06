<?php
/**
 * BootPackage for the very basic bootstrapping
 *
 * Psc\Boot\BootLoader
 */

namespace Psc\Boot;

class Exception extends \Exception {}

/**
 * A Class to reduce rendudant code for bootstrapping the main application container
 * 
 * autoloading is handled by composer
 * 
 */
class BootLoader {

  protected $ds = DIRECTORY_SEPARATOR;

  protected $containerClass;
  
  /**
   * Ein Pfad wird relativ zum Verzeichnis des BootLoaders betrachtet
   */
  const RELATIVE     = 0x000001;

  /**
   * Ein Pfad soll als absolut angesehen werden
   */
  const ABSOLUTE     = 0x000002;
  
  /**
   * Validiert den Pfad und schmeisst eine Exception, wenn er nicht existiert
   */
  const VALIDATE     = 0x000004;
  
  /**
   * The bootloadingDirectory
   *
   * to this directory all paths are relative resolved to
   * @var string with trailingslash
   */
  protected $dir;
  
  /**
   * @var {$this->containerClass}
   */
  protected $container;

  /**
   * @var Composer\AutoLoad\ClassLoader
   */
  protected $autoLoader;
  
  /**
   * Init the BootPackage with the bootloadDirectory
   *
   * all referenced files are relative to this directory
   *
   * e.g.
   * new BootLoader(__DIR__)
   */
  public function __construct($bootloadDirectory = NULL, $containerClass = 'Psc\CMS\Container') {
    $this->dir = $this->ts($bootloadDirectory ?: __DIR__);
    $this->containerClass = $containerClass;
  }
  
  /**
   * @param string $relative der Relativer Pfad von dieser Datei zum Hauptverzeichnis
   *
   * self::createRelative('../bin/');
   */
  public static function createRelative($relative) {
    return new static(realpath(__DIR__.DIRECTORY_SEPARATOR.str_replace(array('/','\\'), DIRECTORY_SEPARATOR, $relative)));
  }
  
  /**
   * requires the Autoload from composer
   *
   * per default the vendor directory is next to the bootload-directory
   */
  public function loadComposer() {
    if ($ownVendor = $this->tryPath('vendor/', BootLoader::RELATIVE | BootLoader::VALIDATE)) {
      $this->autoLoader = require $ownVendor.'autoload.php';
    } else {
      // when bootstrapping is inside a dependency of another project
      $this->autoLoader = require $this->getPath('../../', BootLoader::RELATIVE | BootLoader::VALIDATE).'autoload.php';
    }
  }
  
  /**
   * @discouraged use getContainer() instead
   * @return {$this->containerClass}
   */
  public function getCMSContainer() {
    return $this->getContainer();
  }

  /**
   * @return {$this->containerClass}
   */
  public function getContainer() {
    if (!isset($this->container)) {
      $container = $this->containerClass;
      $this->container = new $container($this->dir);
      $this->container->setAutoLoader($this->getAutoLoader());
      $this->container->init();
    }
    
    return $this->container;

  }

  /**
   * @discouraged use registerContainer()
   * @return {$this->containerClass}
   */
  public function registerCMSContainer() {
    return $this->registerContainer();
  }

  /**
   * Registers the Container as a global object
   *
   * You need this gloabal object to run PHPUnit-tests with webforge or psc-cms
   * 
   * @discouraged use registerContainer()
   * @return {$this->containerClass}
   */
  public function registerContainer() {
    return $GLOBALS['env']['container'] = $this->getContainer();
  }

  /**
   * Registers a reference to the root directory of the package in GLOBALS['env']['root']
   * 
   * if Webforge\Comon is loaded this will be an instance, otherwise a string
   */
  public function registerPackageRoot() {
    if (!isset($GLOBALS['env']) || !array_key_exists('root', $GLOBALS['env'])) {
      return $GLOBALS['env']['root'] = class_exists('Webforge\Common\System\Dir') ? new \Webforge\Common\System\Dir($this->dir) : $this->dir;
    }
  }

  public function registerRootDirectory() {
    return $this->registerPackageRoot();
  }


  public function getAutoLoader() {
    return $this->autoLoader;
  }

  /**
   * resolves a path to a full path
   * 
   * @return string voller Pfad zum Verzeichnis mit DIRECTORY_SEPARATOR hinten dran
   */
  public function getPath($path, $flags = 0x000000) {
    if (($flags & self::RELATIVE) === self::RELATIVE) {
      $path = $this->dir.ltrim($path,'\\/');
    }
    
    if (($flags & self::VALIDATE) === self::VALIDATE) {
      if (($rPath = realpath($path)) !== FALSE) {
        $path = $rPath;
      } else {
        throw new Exception('Pfad: '.$path.' konnte nicht gefunden werden',self::VALIDATE);
      }
    }
    
    return $this->ts($path);
  }
  
  /**
   * tries to resolve a path
   *
   * @return FALSE when the path cannot be found
   */
  public function tryPath($path, $flags = 0x000000) {
    $flags |= self::VALIDATE;
    try {
      return $this->getPath($path, $flags);
    } catch (Exception $e) {
      if ($e->getCode() === self::VALIDATE) {
        return FALSE;
// @codeCoverageIgnoreStart
      } else {
        throw $e;
      }
// @codeCoverageIgnoreEnd
    }
  }
  
  protected function ts($path) {
    return rtrim($path,'/\\').$this->ds;
  }
}
