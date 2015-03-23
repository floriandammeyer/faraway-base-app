<?php
namespace Application\Event;

use Zend\EventManager\SharedEventManagerInterface;
use Zend\EventManager\SharedListenerAggregateInterface;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Class AbstractSharedListenerAggregate
 *
 * Basic implementation of a shared listener aggregate which attaches
 * and detaches listeners for a specific event identifier.
 *
 * @package Sales\Event
 */
abstract class AbstractSharedListenerAggregate
	implements SharedListenerAggregateInterface, ServiceLocatorAwareInterface
{
	protected $service_locator = null;
	private $event_identifier = '';
	private $listeners = [];

	/**
	 * Set service locator
	 *
	 * @param ServiceLocatorInterface $service_locator
	 * @return AbstractSharedListenerAggregate
	 */
	public function setServiceLocator(ServiceLocatorInterface $service_locator)
	{
		$this->service_locator = $service_locator;
		return $this;
	}
	/**
	 * Get service locator
	 *
	 * @return ServiceLocatorInterface
	 */
	public function getServiceLocator()
	{
		return $this->service_locator;
	}

	/**
	 * @return array An associative array assigning callbacks to their respective event names ('event_name' => 'callback').
	 */
	abstract public function getEvents();

	public function setEventIdentifier($id)
	{
		$this->event_identifier = $id;
		return $this;
	}

	public function getEventIdentifier()
	{
		return $this->event_identifier;
	}

	public function attachShared(SharedEventManagerInterface $event_manager)
	{
		foreach($this->getEvents() as $event => $callback)
		{
			$this->listeners[] = $event_manager->attach(
				$this->getEventIdentifier(),
				$event,
				$callback
			);
		}
	}
	public function detachShared(SharedEventManagerInterface $event_manager)
	{
		foreach($this->listeners as $listener)
		{
            // TODO korrekt umsetzen!
			$event_manager->detach(self::EVENT_IDENTIFIER, $listener);
		}
	}
}