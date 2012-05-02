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

use Reseau\Components\Uri\UriInterface;

/**
 * @author Florent Denis <dflorent.pokap@gmail.com>
 */
interface MediaInterface
{
    /**
     * @return \Reseau\Components\Media\ServiceManager
     */
    function getServiceManager();

    /**
     * @param \Reseau\Components\Uri\UriInterface $uri
     *
     * @return boolean|\Reseau\Components\Media\ServiceInterface False if service or namespace nofound
     */
    function analyse(UriInterface $uri);
}
