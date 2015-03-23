<?php
namespace Application\View\Helper;

use Zend\View;
use Zend\View\Exception;

class RequireJs
    extends View\Helper\AbstractHelper
//    extends View\Helper\Placeholder\Container\AbstractStandalone
{
    protected $scripts = array();

    /**
     * @return RequireJs
     */
    public function __invoke($path = '')
    {
        if(!empty($path))
        {
            $this->add($path);
        }

        return $this;
    }

    public function add($path)
    {
        $this->scripts[] = $path;
        return $this;
    }

    /**
     * Retrieve string representation
     *
     * @return string
     */
    public function __toString()
    {
        if(0 == count($this->scripts))
        {
            return '';
        }

        return '"' . implode('","', $this->scripts) . '"';
    }
}
