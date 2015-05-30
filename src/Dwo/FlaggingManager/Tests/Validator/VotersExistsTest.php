<?php

namespace Dwo\FlaggingManager\Tests\Validator;

use Dwo\FlaggingManager\Validator\VotersExists;

/**
 * @author Dave Www <davewwwo@gmail.com>
 */
class VotersExistsTest extends \PHPUnit_Framework_TestCase
{
    public function test()
    {
        $constraint = new VotersExists();

        $this->assertEquals('voters_exists', $constraint->validatedBy());
        $this->assertEquals('property', $constraint->getTargets());
    }
}