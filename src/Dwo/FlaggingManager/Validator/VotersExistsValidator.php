<?php

namespace Dwo\FlaggingManager\Validator;

use Dwo\Flagging\Extractor\VoterExtractor;
use Dwo\Flagging\Model\VoterManagerInterface;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;

/**
 * Class VotersExistsValidator
 *
 * @author Dave Www <davewwwo@gmail.com>
 */
class VotersExistsValidator extends ConstraintValidator
{
    /**
     * @var VoterManagerInterface
     */
    protected $voterManager;

    /**
     * @param VoterManagerInterface $voterManager
     */
    public function __construct(VoterManagerInterface $voterManager)
    {
        $this->voterManager = $voterManager;
    }

    /**
     * @param mixed                   $value
     * @param VotersExists|Constraint $constraint
     */
    public function validate($value, Constraint $constraint)
    {
        if (!is_array($value)) {
            throw new UnexpectedTypeException($value, 'array');
        }

        $votersDiff = array_diff(
            VoterExtractor::extractFromArray($value),
            array_keys($this->voterManager->getAllVoters())
        );

        if (count($votersDiff)) {
            $this->context->addViolation(sprintf('unknown voter "%s"', implode(', ', $votersDiff)));
        }
    }

}
