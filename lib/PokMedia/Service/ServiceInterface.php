<?php

/**
 * this file is part of the pok package.
 *
 * (c) florent denis <dflorent.pokap@gmail.com>
 *
 * for the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Reseau\Components\Media\Service;

use Reseau\Components\Uri\UriInterface;

/**
 * @author Florent Denis <dflorent.pokap@gmail.com>
 */
interface ServiceInterface
{
    /**
     * @param \Reseau\Components\Uri\UriInterface $uri
     */
    function parse(UriInterface $uri);

    /**
     * Get clear uri.
     *
     * @static
     *
     * @param \Reseau\Components\Uri\UriInterface $uri
     *
     * @return boolean|\Reseau\Components\Uri\Uri False if uri is not auhorized
     */
    static function clearUri(UriInterface $uri);

    /**
     * @return string
     */
    function getId();

    /**
     * @return string
     */
    function getUrl();

    /**
     * @return string
     */
    function getTitle();

    /**
     * @return string
     */
    function getDescription();

    /**
     * @return string
     */
    function getImage();
}
