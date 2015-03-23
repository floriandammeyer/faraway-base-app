<?php
namespace Application\View\Helper;

use Zend\View;

class Version
    extends View\Helper\AbstractHelper
{
    /** @var \Application\Service\VersionService $version_service */
    protected $version_service;

    public function __construct($version_service)
    {
        $this->version_service = $version_service;
    }

    /**
     * @return $this
     */
    public function __invoke()
    {
        return $this;
    }

    /**
     * Retrieve string representation
     *
     * @return string
     */
    public function __toString()
    {
        return $this->version_service->getVersion();
    }
}
