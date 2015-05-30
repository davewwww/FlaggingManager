<?php

namespace Dwo\FlaggingManager\Tests\Cache;

use Doctrine\Common\Cache\Cache;
use Dwo\FlaggingManager\Cache\ConfigPrototypeManager;

class ConfigPrototypeManagerTest extends \PHPUnit_Framework_TestCase
{
    public function testFindConfigPrototypeByNameAndType()
    {
        $cache = $this->mockCache();
        $cache->expects(self::once())
            ->method('contains')
            ->willReturn(true);
        $cache->expects(self::once())
            ->method('fetch')
            ->with(self::stringContains('foo'))
            ->willReturn(['lorem']);

        $manager = new ConfigPrototypeManager($cache);
        $configPrototype = $manager->findConfigPrototypeByNameAndType('foo', 'bar');

        self::isInstanceOf('Dwo\ConfigPrototype\Model\ConfigPrototypeInterface', $configPrototype);
        self::assertEquals($configPrototype->getName(), 'foo');
        self::assertEquals($configPrototype->getType(), 'bar');
        self::assertEquals($configPrototype->getContent(), ['lorem']);
    }

    public function testFindConfigPrototypeByNameAndTypeNull()
    {
        $cache = $this->mockCache();
        $cache->expects(self::once())
            ->method('contains')
            ->willReturn(false);

        $manager = new ConfigPrototypeManager($cache);
        $result = $manager->findConfigPrototypeByNameAndType('foo', 'bar');

        self::assertNull($result);
    }

    public function testSaveConfigPrototype()
    {
        $cache = $this->mockCache();
        $cache->expects(self::once())
            ->method('save');

        $cp = $this->getMockBuilder('Dwo\ConfigPrototype\Model\ConfigPrototypeInterface')->getMock();

        $manager = new ConfigPrototypeManager($cache);
        $manager->saveConfigPrototype($cp);
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject|Cache
     */
    protected function mockCache()
    {
        return $this->getMockBuilder('Doctrine\Common\Cache\Cache')
            ->disableOriginalConstructor()
            ->getMock();
    }
}
