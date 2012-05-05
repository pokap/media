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

/**
 * @author Florent Denis <florentdenisp@gmail.com>
 */
interface CacheInterface
{
    /**
     * @param string $url
     * @param \Pok\Media\Service\ServiceInterface $service
     */
    function set($url, ServiceInterface $service);

    /**
     * @param string $url
     *
     * @return null|\Pok\Media\Service\ServiceInterface
     */
    function get($url);

    /**
     * @param string $url
     *
     * @return boolean
     */
    function has($url);
}
