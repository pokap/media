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
 * @author Florent Denis <florentdenisp@gmail.com>
 */
class DailyMotion implements ServiceInterface
{
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

        $html = \OpenGraph::fetch($this->url);

        // open graph
        $this->id          = basename($uri->getPath());
        $this->title       = $html->title;
        $this->description = $html->description;
        $this->image       = urlencode($html->image);
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

        $uri->setHost('www.dailymotion.com');

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