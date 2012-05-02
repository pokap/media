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

use Pok\Media\ServiceInterface;
use Zend\Uri\Uri;

/**
 * @since 2.0
 * @author Florent Denis <florentdenisp@gmail.com>
 */
class Deezer implements ServiceInterface
{
    /**
     * @static
     * @var array
     */
    static public $typesAuthorized = array('track');

    /**
     * @var string
     */
    private $id;

    /**
     * @var string
     */
    private $url;

    /**
     * @var string
     */
    private $title;

    /**
     * @var string
     */
    private $description;

    /**
     * @var string
     */
    private $image;

    /**
     * @param \Zend\Uri\Uri $uri
     */
    public function parse(Uri $uri)
    {
        $this->url = $uri->toString();

        $paths = explode('/', $uri->getPath());
        $pathsCount = count($paths);

        $id = $paths[$pathsCount - 1];
        $type = $paths[$pathsCount - 2];

        $data = json_encode(file_get_contents('http://api.deezer.com/2.0/' . $type . '/' . $id));
        if (!isset($data['id'])) {
            return;
        }

        $this->id          = $data['id'];
        $this->title       = $data['title'];
        $this->description = $data['album']['link'];
        $this->image       = $data['album']['cover'];
    }

    /**
     * Get clear uri.
     *
     * @static
     *
     * @param \Zend\Uri\Uri $uri
     *
     * @return boolean|\Zend\Uri\Uri False if uri is not auhorized
     */
    public static function clearUri(Uri $uri)
    {
        if ($uri->getScheme() !== 'http') {
            return false;
        }

        $paths = explode('/', $uri->getPath());
        $pathsCount = count($paths);

        if ($pathsCount < 2) {
            return false;
        }

        $type = $paths[$pathsCount - 2];

        if (!in_array($type, self::$typesAuthorized)) {
            return false;
        }

        $uri->setHost('www.deezer.com');

        // clear
        $uri->setPort(0);
        $uri->setUserInfo('');
        $uri->setQuery('');
        $uri->setFragment('');

        return $uri;
    }

    /**
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @return string
     */
    public function getImage()
    {
        return $this->image;
    }
}