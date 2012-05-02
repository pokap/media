<?php

/**
 * this file is part of the pok package.
 *
 * (c) florent denis <dflorent.pokap@gmail.com>
 *
 * for the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Reseau\Components\Media\Cache;

use Reseau\Components\Media\Service\ServiceInterface;
use Reseau\Components\Media\Cache\CacheInterface;

/**
 * @author Florent Denis <dflorent.pokap@gmail.com>
 */
class ArrayCache implements CacheInterface
{
    /**
     * @var array<string, \Reseau\Components\Media\Service\ServiceInterface>
     */
    private $medias;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->medias = array();
    }

    /**
     * @param string $url
     * @param \Reseau\Components\Media\Service\ServiceInterface $service
     */
    public function set($url, ServiceInterface $service)
    {
        $this->medias[$url] = $service;
    }

    /**
     * @param string $url
     *
     * @return null|\Reseau\Components\Media\Service\ServiceInterface
     */
    function get($url)
    {
        if (!$this->has($url)) {
            return null;
        }

        return $this->medias[$url];
    }

    /**
     * @param string $url
     *
     * @return boolean
     */
    public function has($url)
    {
        return isset($this->medias[$url]);
    }
}
