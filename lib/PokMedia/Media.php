<?php

/**
 * this file is part of the pok package.
 *
 * (c) florent denis <dflorent.pokap@gmail.com>
 *
 * for the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Reseau\Components\Media;

use Reseau\Components\Media\Cache\CacheInterface;
use Reseau\Components\Media\Cache\ArrayCache;
use Reseau\Components\Media\Service\ServiceManager;
use Reseau\Components\Media\MediaInterface;
use Reseau\Components\Uri\UriInterface;

/**
 * @author Florent Denis <dflorent.pokap@gmail.com>
 */
class Media implements MediaInterface
{
    /**
     * @var \Reseau\Components\Media\ServiceManager
     */
    private $serviceManager;

    /**
     * @var \Reseau\Components\Media\Cache\CacheInterface
     */
    private $cache;

    /**
     * Constructor.
     *
     * @param null|\Reseau\Components\Media\Cache\CacheInterface $cache
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
     * @return \Reseau\Components\Media\ServiceManager
     */
    public function getServiceManager()
    {
        return $this->serviceManager;
    }

    /**
     * @param \Reseau\Components\Media\Cache\CacheInterface $cache
     */
    public function setCache(CacheInterface $cache)
    {
        $this->cache = $cache;
    }

    /**
     * @return \Reseau\Components\Media\Cache\CacheInterface
     */
    public function getCache()
    {
        return $this->cache;
    }

    /**
     * @param \Reseau\Components\Uri\UriInterface $uri
     *
     * @return boolean|\Reseau\Components\Media\ServiceInterface False if service or namespace nofound
     */
    public function analyse(UriInterface $uri)
    {
        $service = $this->serviceManager->searchService($uri->toString());
        if (false === $service) {
            return false;
        }

        $namespace = $this->serviceManager->getServiceNamespace($service);
        if ($namespace === '') {
            return false;
        }

        $clear = $namespace::clearUri($uri);
        if (false !== $uri) {
            return false;
        }

        // clear current uri
        $uri = $clear;
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
