<?php

namespace Roave\BetterReflectionTest\Fixture;

class StringCastConstants
{
    public const PUBLIC_CONSTANT = true;
    protected const PROTECTED_CONSTANT = 0;
    private const PRIVATE_CONSTANT = 'string';
    const NO_VISIBILITY_CONSTANT = [];
    final public const FINAL_CONSTANT = 'final';

    /**
     * @var string
     */
    const WITH_DOC_COMMENT_CONSTANT = 'string';
}
