<?php

namespace Dwo\FlaggingManager\Tests\Cache;

use Doctrine\Common\Cache\Cache;
use Dwo\FlaggingManager\Cache\ConfigPrototypeManager;
use Dwo\FlaggingManager\Handler\FeatureHandler;

class FeatureHandlerTest extends \PHPUnit_Framework_TestCase
{
    public function testSaveConfigPrototype()
    {
        $cpManager = $this->mockConfigPrototypeManager();
        $cpManager->expects(self::once())
            ->method('saveConfigPrototype');

        $manager = new FeatureHandler($cpManager);
        $manager->saveFeature('foo', ['bar']);
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject|Cache
     */
    protected function mockConfigPrototypeManager()
    {
        return $this->getMockBuilder('Dwo\ConfigPrototype\Model\ConfigPrototypeManagerInterface')
            ->disableOriginalConstructor()
            ->getMock();
    }
}
