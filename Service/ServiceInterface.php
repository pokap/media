<?php

/**
 * this file is part of the pok package.
 *
 * (c) florent denis <florentdenisp@gmail.com>
 *
 * for the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Pok\Media\Service;

use Zend\Uri\Uri;

/**
 * @author Florent Denis <florentdenisp@gmail.com>
 */
interface ServiceInterface
{
    /**
     * @param \Zend\Uri\Uri $uri
     */
    function parse(Uri $uri);

    /**
     * Get clear uri.
     *
     * @static
     *
     * @param \Zend\Uri\Uri $uri
     *
     * @return boolean|\Zend\Uri\Uri False if uri is not auhorized
     */
    static function clearUri(Uri $uri);

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
