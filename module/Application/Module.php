<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application;

use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;

// The autoloader for this module has not been initialized,
// so we have to manually include the AbstractModule
require_once(__DIR__ . '/src/Application/AbstractModule.php');

class Module
    extends AbstractModule
{
    public function onBootstrap(MvcEvent $e)
    {
        $eventManager        = $e->getApplication()->getEventManager();
        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);

	    /**
	     * Log any Uncaught Exceptions, including all Exceptions in the stack.
	     * @see http://stackoverflow.com/questions/15271250/how-to-log-zf2-controller-exceptions
	     */
	    $sharedManager = $eventManager->getSharedManager();
	    $sm            = $e->getApplication()->getServiceManager();
	    $error_logger  = $sm->get('ErrorLogger');

	    $sharedManager->attach(
		    'Zend\Mvc\Application',
		    'dispatch.error',
		    function($e) use($sm, $error_logger)
		    {
			    if($e->getParam('exception'))
			    {
				    $ex = $e->getParam('exception');
				    do
				    {
					    $error_logger->crit(
						    sprintf(
							    "%s:%d %s (%d) [%s]\n",
							    $ex->getFile(),
							    $ex->getLine(),
							    $ex->getMessage(),
							    $ex->getCode(),
							    get_class($ex)
						    )
					    );
				    }
				    while($ex = $ex->getPrevious());
			    }
		    }
	    );
    }
}
