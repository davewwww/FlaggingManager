<?php

namespace Dwo\FlaggingManager\Tests\Validator;

use Dwo\Flagging\Model\VoterManagerInterface;
use Dwo\FlaggingManager\Validator\VotersExists;
use Dwo\FlaggingManager\Validator\VotersExistsValidator;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

class VotersExistsValidatorTest extends \PHPUnit_Framework_TestCase
{
    public function testValid()
    {
        $manager = $this->getVoterManager();
        $manager->expects($this->once())
            ->method('getAllVoters')
            ->willReturn(array(
                'foo' => []
            ));

        $context = $this->getContext();
        $context->expects($this->never())
            ->method('addViolation');

        $value = array(
            'filters' => array(
                array('foo' => [])
            )
        );

        $validator = new VotersExistsValidator($manager);
        $validator->initialize($context);
        $validator->validate($value, $constraint = new VotersExists());
    }

    public function testInvalid()
    {
        $manager = $this->getVoterManager();
        $manager->expects($this->once())
            ->method('getAllVoters')
            ->willReturn(array(
                'foo' => []
            ));

        $context = $this->getContext();
        $context->expects($this->once())
            ->method('addViolation')
            ->with($this->stringContains('unknown voter "fooXX"'));

        $value = array(
            'filters' => array(
                array('fooXX' => [])
            )
        );

        $validator = new VotersExistsValidator($manager);
        $validator->initialize($context);
        $validator->validate($value, $constraint = new VotersExists());
    }

    /**
     * @expectedException \Symfony\Component\Validator\Exception\UnexpectedTypeException
     * @expectedExceptionMessageRegExp /array/
     */
    public function testInvalidArgument()
    {
        $validator = new VotersExistsValidator($this->getVoterManager());
        $validator->validate('foo', $constraint = new VotersExists());
    }


    /**
     * @return \PHPUnit_Framework_MockObject_MockObject|VoterManagerInterface
     */
    private function getVoterManager()
    {
        $manager = $this->getMockBuilder('Dwo\Flagging\Model\VoterManagerInterface')
            ->disableOriginalConstructor()
            ->getMock();

        return $manager;
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject|ExecutionContextInterface
     */
    private function getContext()
    {
        $context = $this->getMockBuilder('Symfony\Component\Validator\Context\ExecutionContextInterface')
            ->getMock();

        return $context;
    }
}