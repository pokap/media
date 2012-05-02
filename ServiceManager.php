<?php

/**
 * this file is part of the pok package.
 *
 * (c) florent denis <florentdenisp@gmail.com>
 *
 * for the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Pok\Media;

/**
 * @author Florent Denis <florentdenisp@gmail.com>
 */
class ServiceManager
{
    /**
     * @const integer
     */
    const
        SERVICE_FILTERS   = 0,
        SERVICE_NAMESPACE = 1;

    /**
     * @var array
     */
    private $services;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->services = array();
    }

    /**
     * @param string $name
     */
    protected function createService($name)
    {
        $this->services[$name] = array(
            self::SERVICE_FILTERS   => array(),
            self::SERVICE_NAMESPACE => ''
        );
    }

    /**
     * @param string      $name
     * @param string      $namespace
     * @param null|string $filter
     */
    public function setService($name, $namespace, $filter = null)
    {
        if (!$this->hasService($name)) {
            $this->createService($name);
        }

        $this->services[$name][self::SERVICE_NAMESPACE] = $namespace;

        if (null !== $filter) {
            if (is_array($filter)) {
                $this->services[$name][self::SERVICE_FILTERS] = array_merge($this->services[$name][self::SERVICE_FILTERS], $filter);
            } else {
                $this->services[$name][self::SERVICE_FILTERS][] = $filter;
            }
        }
    }

    /**
     * @param string $name
     * @param string $filter
     */
    public function addServiceFilter($name, $filter)
    {
        if (!$this->hasService($name)) {
            $this->createService($name);
        }

        if (is_array($filter)) {
            $this->services[$name][self::SERVICE_FILTERS] = array_merge($this->services[$name][self::SERVICE_FILTERS], $filter);
        } else {
            $this->services[$name][self::SERVICE_FILTERS][] = $filter;
        }
    }

    /**
     * @param string $name
     *
     * @return boolean
     */
    public function hasService($name)
    {
        return isset($this->services[$name]);
    }

    /**
     * @return null|string
     */
    public function getServiceNamespace($name)
    {
        if (!$this->hasService($name)) {
            return null;
        }

        return $this->services[$name][self::SERVICE_NAMESPACE];
    }

    /**
     * @return null|array
     */
    public function getServiceFilters($name)
    {
        if (!$this->hasService($name)) {
            return null;
        }

        return $this->services[$name][self::SERVICE_FILTERS];
    }

    /**
     * @return array
     */
    public function getServices()
    {
        return array_keys($this->services);
    }

    /**
     * @param string $name
     *
     * @return boolean
     */
    public function removeService($name)
    {
        if (!$this->hasService($name)) {
            return false;
        }

        unset($this->services[$name]);
        return true;
    }

    /**
     * @param string $name
     * @param string $filter
     */
    public function removeServiceFilter($name, $filters)
    {
        if (!$this->hasService($name)) {
            return false;
        }

        if (!is_array($filters)) {
            $filters = (array) $filters;
        }

        foreach ($filters as $filter) {
            $position = array_search($filter, $this->services[$name]);
            if (false !== $position) {
                unset($this->services[$name][$position]);
            }
        }
    }

    /**
     * @param string $likeFilter
     *
     * @return boolean|string False if the needle like filter was not found
     */
    public function searchService($likeFilter)
    {
        foreach ($this->services as $name => $service) {
            foreach ($service[self::SERVICE_FILTERS] as $filter) {
                if (strpos($likeFilter, $filter) === 0) {
                    return $name;
                }
            }
        }

        return false;
    }
}
