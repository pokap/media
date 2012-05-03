<?php

namespace Pok\Media\Tests\Units;

require_once __DIR__ . '/../bootstrap.php';

use \mageekguy\atoum;

class ServiceManager extends atoum\test
{
    public function testService()
    {
        $service = new \Pok\Media\ServiceManager();

        $filters = array(
            'https?:\/\/(www\.)?myservice\.com',
            'ssh:\/\/[a-z]+:[a-z]+@myservice\.com'
        );

        $service->setService('myservice', 'Path\\To\\MyServiceClass', $filters[0]);
        $service->addServiceFilter('myservice', array($filters[1]));

        $this->assert
            ->array($service->getServiceFilters('myservice'))
                ->isEqualTo($filters)
            ->boolean($service->removeServiceFilter('myservice', $filters[1]))
                ->isEqualTo(true)
        ;
    }

    public function testSearchService()
    {
        $service = new \Pok\Media\ServiceManager();

        $filters = array(
            'https?:\/\/(www\.)?myservice\.com',
            'ssh:\/\/[a-z]+:[a-z]+@myservice\.com'
        );

        $service->setService('myservice', 'Path\\To\\MyServiceClass', $filters);

        $this->assert
            ->boolean($service->searchService('http://api.myservice.com'))
                ->isEqualTo(false)
            ->boolean($service->searchService('ssh://user:p[SsW0rD@myservice.com'))
                ->isEqualTo(false)
            ->string($service->searchService('ssh://user:password@myservice.com'))
                ->isEqualTo('myservice')
            ->string($service->searchService('http://myservice.com'))
                ->isEqualTo('myservice')
        ;
    }
}
