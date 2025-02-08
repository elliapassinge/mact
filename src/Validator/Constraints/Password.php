<?php

namespace Mact\Validator\Constraints;

use Mact\Exception\MinMaxException;
use Symfony\Component\Validator\Constraint;

class Password extends Constraint
{
    public string $lowerMessage   = 'mact.form._error.lower';
    public string $maxCharMessage = 'mact.form._error.maxChar';
    public string $minCharMessage = 'mact.form._error.minChar';
    public string $nbDigitMessage = 'mact.form._error.nbDigit';
    public string $nullMessage    = 'mact.form._error.null';
    public string $spaceMessage   = 'mact.form._error.space';
    public string $upperMessage   = 'mact.form._error.upper';

    public int $maxChar;
    public int $minChar;

    public function __construct(
        int $minChar = 8,
        int $maxChar = 25,
        public int $nbDigit = 1,
        public bool $hasLower = true,
        public bool $hasUpper = true,
        public bool $hasSpace = false,
        ?array $options = null,
        ?array $groups = null,
        mixed $payload = null,
    ) {
        if ($minChar > $maxChar) {
            throw new MinMaxException(\sprintf('You must be check min and max values.. Min : %d, Max : %d', $minChar, $maxChar));
        }

        parent::__construct($options, $groups, $payload);

        $this->maxChar = $maxChar;
        $this->minChar = $minChar;
    }
}
