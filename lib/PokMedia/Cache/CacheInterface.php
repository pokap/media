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

/**
 * @author Florent Denis <dflorent.pokap@gmail.com>
 */
interface CacheInterface
{
    /**
     * @param string $url
     * @param \Reseau\Components\Media\Service\ServiceInterface $service
     */
    function set($url, ServiceInterface $service);

    /**
     * @param string $url
     *
     * @return null|\Reseau\Components\Media\Service\ServiceInterface
     */
    function get($url);

    /**
     * @param string $url
     *
     * @return boolean
     */
    function has($url);
}
