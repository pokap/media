<?php

namespace Pok\Media\Tests\Units;

require_once __DIR__ . '/../bootstrap.php';

use \mageekguy\atoum;
use Zend\Uri\Uri;

class Media extends atoum\test
{
    public function test__construct()
    {
        $media = new \Pok\Media\Media();

        $this->assert
            ->object($media->getServiceManager())
                ->isInstanceOf('Pok\\Media\\ServiceManager')
            ->object($media->getCache())
                ->isInstanceOf('Pok\\Media\\Cache\\ArrayCache')
        ;
    }

    public function testAnalyse()
    {
        $youtube_namespace = 'Pok\\Media\\Service\\Youtube';

        $media = new \Pok\Media\Media();
        $media->getServiceManager()->setService('youtube', $youtube_namespace, 'http:\/\/(www\.)?youtube\.com');

        $url = 'http://www.youtube.com/watch?v=uh9oUHO2dxE';
        $uri = new Uri($url . '&_test=1');

        $service = $media->analyse($uri);

        $this->assert
            ->object($service)
                ->isInstanceOf($youtube_namespace)
            ->string($service->getId())
                ->isEqualTo('uh9oUHO2dxE')
            ->boolean($media->getCache()->has($url))
                ->isEqualTo(true)
        ;

        // hack cache
        $media->getCache()->set($url, new $youtube_namespace());
        // do believe that the link is dead
        $service = $media->analyse($uri);

        $this->assert
            ->variable($service->getId())
                ->isNull()
        ;
    }
}
