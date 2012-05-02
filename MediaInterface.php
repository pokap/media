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

use Zend\Uri\Uri;

/**
 * @author Florent Denis <florentdenisp@gmail.com>
 */
interface MediaInterface
{
    /**
     * @return \Pok\Media\ServiceManager
     */
    function getServiceManager();

    /**
     * @param \Zend\Uri\Uri $uri
     *
     * @return boolean|\Pok\Media\ServiceInterface False if service or namespace nofound
     */
    function analyse(Uri $uri);
}
