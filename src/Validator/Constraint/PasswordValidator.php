<?php

namespace Mact\Validator\Constraint;

use Symfony\Component\Form\Exception\UnexpectedTypeException;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedValueException;

class PasswordValidator extends ConstraintValidator
{
    public function validate(mixed $value, Constraint $constraint): void
    {
        if (!$constraint instanceof Password) {
            throw new UnexpectedTypeException($constraint, Password::class);
        }

        if (null === $value) {
            $this->context
                ->buildViolation($constraint->nullMessage)
                ->setTranslationDomain('mact')
                ->addViolation();

            return;
        }

        if (!\is_scalar($value) && !$value instanceof \Stringable) {
            throw new UnexpectedValueException($value, 'string');
        }

        if (strlen($value) < $constraint->minChar) {
            $this->context
                ->buildViolation($constraint->minCharMessage)
                ->setParameter('{{ minChar }}', $constraint->minChar)
                ->setTranslationDomain('mact')
                ->addViolation();
        }

        if (strlen($value) > $constraint->maxChar) {
            $this->context
                ->buildViolation($constraint->maxCharMessage)
                ->setParameter('{{ minChar }}', $constraint->maxChar)
                ->setTranslationDomain('mact')
                ->addViolation();
        }

        if (!$constraint->hasSpace && preg_match('/\\s/', $value)) {
            $this->context
                ->buildViolation($constraint->spaceMessage)
                ->setTranslationDomain('mact')
                ->addViolation();
        }

        if (preg_match('/[0-9]{'.$constraint->nbDigit.'}/', $value)) {
            $this->context
                ->buildViolation($constraint->spaceMessage)
                ->setTranslationDomain('mact')
                ->addViolation();
        }

        if ($constraint->hasLower && !preg_match('/[a-z]/', $value)) {
            $this->context
                ->buildViolation($constraint->lowerMessage)
                ->setTranslationDomain('mact')
                ->addViolation();
        }

        if ($constraint->hasUpper && !preg_match('/[A-Z]/', $value)) {
            $this->context
                ->buildViolation($constraint->upperMessage)
                ->setTranslationDomain('mact')
                ->addViolation();
        }

        if (!preg_match('/[`~\!@#\$%\^\&\*\(\)\-_\=\+\[\{\}\]\\\|;:\'",<.>\/\?€£¥₹]+/u', $value)) {
            $this->context
                ->buildViolation($constraint->upperMessage)
                ->setTranslationDomain('mact')
                ->addViolation();
        }
    }
}
