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

/**
 * @author Florent Denis <florentdenisp@gmail.com>
 */
interface CacheInterface
{
    /**
     * @param string $url
     * @param mixed  $service
     */
    function set($url, $service);

    /**
     * @param string $url
     *
     * @return mixed
     */
    function get($url);

    /**
     * @param string $url
     *
     * @return boolean
     */
    function has($url);
}
