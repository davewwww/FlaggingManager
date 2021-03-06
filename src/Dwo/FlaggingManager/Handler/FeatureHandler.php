<?php

namespace Dwo\FlaggingManager\Handler;

use Dwo\ConfigPrototype\Model\ConfigPrototype;
use Dwo\ConfigPrototype\Model\ConfigPrototypeManagerInterface;

/**
 * Class FeatureHandler
 *
 * @author Dave Www <davewwwo@gmail.com>
 */
class FeatureHandler
{
    /**
     * @var ConfigPrototypeManagerInterface
     */
    protected $manager;

    /**
     * @param ConfigPrototypeManagerInterface $manager
     */
    public function __construct(ConfigPrototypeManagerInterface $manager)
    {
        $this->manager = $manager;
    }

    /**
     * @param string $name
     * @param array  $content
     */
    public function saveFeature($name, array $content)
    {
        $configPrototype = new ConfigPrototype();
        $configPrototype->setType('feature');
        $configPrototype->setName($name);
        $configPrototype->setContent($content);

        $this->manager->saveConfigPrototype($configPrototype);
    }
}
