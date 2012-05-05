<?php

/**
 * this file is part of the pok package.
 *
 * (c) florent denis <florentdenisp@gmail.com>
 *
 * for the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Pok\Media\Cache;

use Pok\Media\Service\ServiceInterface;
use Pok\Media\Cache\CacheInterface;

/**
 * @author Florent Denis <florentdenisp@gmail.com>
 */
class ArrayCache implements CacheInterface
{
    /**
     * @var array<string, \Pok\Media\Service\ServiceInterface>
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
     * @param \Pok\Media\Service\ServiceInterface $service
     */
    public function set($url, ServiceInterface $service)
    {
        $this->medias[$url] = $service;
    }

    /**
     * @param string $url
     *
     * @return null|\Pok\Media\Service\ServiceInterface
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
