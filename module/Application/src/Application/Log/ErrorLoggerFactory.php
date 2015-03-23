<?php
namespace Application\Log;

use Zend\Log\Logger;
use Zend\Log\Writer\Stream;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class ErrorLoggerFactory
	implements FactoryInterface
{
	public function createService(ServiceLocatorInterface $service_locator)
	{
		$dir = getcwd() . '/data/log/errors';
		if(!is_dir($dir))
		{
			mkdir($dir, 0777, true);
		}
		$writer = new Stream($dir . '/' . date('Y-m-d') . '.txt');

		$logger = new Logger();
		$logger->addWriter($writer);

		Logger::registerErrorHandler($logger);
		Logger::registerExceptionHandler($logger);

		return $logger;
	}
}