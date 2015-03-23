<?php
namespace Application;

use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
use Zend\ModuleManager\Feature\ConfigProviderInterface;

/**
 * Class AbstractModule
 *
 * Pre-configures common module settings, so that
 * these methods do not need to be rewritten for each module.
 *
 * @package Application
 */
abstract class AbstractModule
    implements ConfigProviderInterface, AutoloaderProviderInterface
{
    /**
     * By convention, the configuration for each module
     * resides in MODULE_DIR/config/module.config.php
     *
     * @return array
     */
    public function getConfig()
    {
        $reflector = $this->getReflector();

        return include dirname($reflector->getFileName()) . '/config/module.config.php';
    }

    /**
     * By convention, the source code of each module resides
     * ins the 'src' directory inside the module's root directory.
     *
     * @return array
     */
    public function getAutoloaderConfig()
    {
        $reflector = $this->getReflector();

        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    $reflector->getNamespaceName() => dirname($reflector->getFileName()) . '/src/' . $reflector->getNamespaceName()
                )
            )
        );
    }

    /**
     * Helper method.
     *
     * Instantiate a ReflectionClass object for this instance and return it.
     *
     * @return \ReflectionClass
     */
    protected function getReflector()
    {
        // We only need one instance of the ReflectionClass,
        // therefore we cache the instance in a static variable
        // after it has been created for the first time
        static $reflector = null;

        if(is_null($reflector))
        {
            $reflector = new \ReflectionClass( get_class($this) );
        }

        return $reflector;
    }
}