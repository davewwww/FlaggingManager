<?php

namespace Dwo\FlaggingManager\Validator;

use Symfony\Component\Validator\Constraint;

/**
 * Class VotersExists
 *
 * @author Dave Www <davewwwo@gmail.com>
 */
class VotersExists extends Constraint
{
    /**
     * @return string
     */
    public function validatedBy()
    {
        return 'voters_exists';
    }

    /**
     * @return string
     */
    public function getTargets()
    {
        return self::PROPERTY_CONSTRAINT;
    }
}
