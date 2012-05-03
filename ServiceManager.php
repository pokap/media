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
    const SERVICE_FILTERS   = 0;

    const SERVICE_NAMESPACE = 1;

    /**
     * @var array
     */
    protected $services;

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
     * Setting service with namespace and filter(s), if don't exists, he created.
     *
     * @param string            $name
     * @param string            $namespace
     * @param null|string|array $filter
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
     * Adding filter(s) in the service, if don't exists, he created.
     *
     * @param string       $name
     * @param string|array $filter The pattern to search for url, as a regex
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
     * @param string $name
     *
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
     * @param string $name
     *
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
     * @param string       $name
     * @param string|array $filter
     *
     * @return boolean
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

        return true;
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
                if (preg_match(sprintf('/^%s/i', $filter), $likeFilter) === 1) {
                    return $name;
                }
            }
        }

        return false;
    }
}
