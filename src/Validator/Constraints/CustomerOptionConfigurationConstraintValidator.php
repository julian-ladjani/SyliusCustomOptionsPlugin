<?php

declare(strict_types=1);

namespace Brille24\CustomerOptionsPlugin\Validator\Constraints;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class CustomerOptionConfigurationConstraintValidator extends ConstraintValidator
{
    /**
     * {@inheritdoc}
     */
    public function validate($value, Constraint $constraint): void
    {
        if (!is_array($value)) {
            throw new \InvalidArgumentException('Can not validate configurations.');
        }

        if (count($value) === 0) {
            return;
        }

        // Get the array key that contains min and max
        $minKeys = array_filter(array_keys($value), function (string $key) { return is_int(strpos($key, 'min')); });
        $maxKeys = array_filter(array_keys($value), function (string $key) { return is_int(strpos($key, 'max')); });

        if (count($minKeys) === 0 || count($maxKeys) === 0) {
            return;
        }

        $minValue = $value[reset($minKeys)]['value'];
        $maxValue = $value[reset($maxKeys)]['value'];

        if ($minValue > $maxValue) {
            $this->context->addViolation($constraint->message);
        }
    }
}
