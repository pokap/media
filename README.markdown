Link Media
==========

A simple way to get metadata of media link.

**Requires** at least *PHP 5.3.3* because uses Zend Uri library. Compatible PHP 5.4 too.

This package uses unofficial Zend Uri (https://github.com/brikou/zend_uri), waiting out stable zf2
and OpenGraph (https://github.com/scottmac/opengraph) to get meta-data with open graph protocol (http://ogp.me/).

[![Build Status](https://secure.travis-ci.org/Pokap/media.png?branch=master)](http://travis-ci.org/Pokap/media)

Usage
-------------

``` php
<?php

$media = new \Pok\Media\Media();

// one service equal to one class
// several filters to find the service in relation to the links, be careful not to forget the scheme
$media->getServiceManager()->setService(
    'youtube',
    'Pok\\Media\\Service\\Youtube',
    array('http:\/\/(www\.)?youtube\.com')
);

$uri = new \Zend\Uri\Uri('http://www.youtube.com/watch?v=uh9oUHO2dxE&useless_data');

// get instance of \Pok\Media\Service\Youtube with id (uh9oUHO2dxE), title, description of video, etc.
// false if error.
$service = $media->analyse($uri);

echo $uri->toString(); // http://www.youtube.com/watch?v=uh9oUHO2dxE

?>
```