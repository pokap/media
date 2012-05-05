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

use Pok\Media\Cache\CacheInterface;
use Pok\Media\Cache\ArrayCache;
use Pok\Media\ServiceManager;
use Pok\Media\MediaInterface;
use Zend\Uri\Uri;

/**
 * @author Florent Denis <florentdenisp@gmail.com>
 */
class Media implements MediaInterface
{
    /**
     * @var \Pok\Media\ServiceManager
     */
    private $serviceManager;

    /**
     * @var \Pok\Media\Cache\CacheInterface
     */
    private $cache;

    /**
     * Constructor.
     *
     * @param null|\Pok\Media\Cache\CacheInterface $cache
     */
    public function __construct(CacheInterface $cache = null)
    {
        $this->serviceManager = new ServiceManager();

        if (null === $cache) {
            $cache = new ArrayCache();
        }

        $this->cache = $cache;
    }

    /**
     * @return \Pok\Media\ServiceManager
     */
    public function getServiceManager()
    {
        return $this->serviceManager;
    }

    /**
     * @param \Pok\Media\Cache\CacheInterface $cache
     */
    public function setCache(CacheInterface $cache)
    {
        $this->cache = $cache;
    }

    /**
     * @return \Pok\Media\Cache\CacheInterface
     */
    public function getCache()
    {
        return $this->cache;
    }

    /**
     * @param \Zend\Uri\Uri $uri
     *
     * @return boolean|\Pok\Media\Service\ServiceInterface False if service or namespace nofound
     */
    public function analyse(Uri $uri)
    {
        $service = $this->serviceManager->searchService($uri->toString());
        if (false === $service) {
            return false;
        }

        $namespace = $this->serviceManager->getServiceNamespace($service);
        if (null === $namespace || $namespace === '') {
            return false;
        }

        $clear = $namespace::clearUri($uri);
        if (false === $clear) {
            return false;
        }

        $keyCache = $uri->toString();

        // cache because the analyse process requires a lot of resources
        $analyser = $this->cache->get($keyCache);
        if (null !== $analyser) {
            return $analyser;
        }

        // analyse process
        $analyser = new $namespace();
        $analyser->parse($uri);

        $this->cache->set($keyCache, $analyser);

        if (!$analyser->getId()) {
            return false;
        }

        return $analyser;
    }
}
