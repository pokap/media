<?php

/**
 * this file is part of the pok package.
 *
 * (c) florent denis <dflorent.pokap@gmail.com>
 *
 * for the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Reseau\Bridge\DoctrineMongoDB\Structure\Article\Media\Service;

use Reseau\Components\Media\Service\ServiceInterface;
use Reseau\Components\Uri\Uri;
use Reseau\Components\Uri\UriInterface;

/**
 * @author Florent Denis <dflorent.pokap@gmail.com>
 */
class Vimeo implements ServiceInterface
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
     * @param \Reseau\Components\Uri\UriInterface $uri
     */
    public function parse(UriInterface $uri)
    {
        $this->url = $uri->toString();

        $html = \OpenGraph::fetch($uri->toString());

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
     * @param \Reseau\Components\Uri\UriInterface $uri
     *
     * @return boolean|\Reseau\Components\Uri\Uri False if uri is not auhorized
     */
    public static function clearUri(UriInterface $uri)
    {
        if ($uri->getSchema() !== 'http') {
            return false;
        }

        $uri->setHost('www.vimeo.com');

        // clear
        $uri->setPort(null);
        $uri->setUsername(null);
        $uri->setPassword(null);
        $uri->setQuery(null);
        $uri->setFragment(null);

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