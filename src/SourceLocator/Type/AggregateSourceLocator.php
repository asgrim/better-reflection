<?php

declare(strict_types=1);

namespace Roave\BetterReflection\SourceLocator\Type;

use Generator;
use Roave\BetterReflection\Identifier\Identifier;
use Roave\BetterReflection\Identifier\IdentifierType;
use Roave\BetterReflection\Reflection\Reflection;
use Roave\BetterReflection\Reflector\Reflector;
use Roave\BetterReflection\SourceLocator\Type\SourceFilter\SourceFilter;

use function array_map;
use function array_merge;

class AggregateSourceLocator implements SourceLocator
{
    /** @param list<SourceLocator> $sourceLocators */
    public function __construct(private array $sourceLocators = [])
    {
    }

    public function locateIdentifier(Reflector $reflector, Identifier $identifier): Reflection|null
    {
        foreach ($this->sourceLocators as $sourceLocator) {
            $located = $sourceLocator->locateIdentifier($reflector, $identifier);

            if ($located) {
                return $located;
            }
        }

        return null;
    }

    /**
     * {@inheritDoc}
     */
    public function locateIdentifiersByType(Reflector $reflector, IdentifierType $identifierType): array
    {
        return array_merge(
            [],
            ...array_map(static fn (SourceLocator $sourceLocator): array => $sourceLocator->locateIdentifiersByType($reflector, $identifierType), $this->sourceLocators),
        );
    }

    /**
     * {@inheritDoc}
     */
    public function iterateIdentifiersByType(
        Reflector $reflector,
        IdentifierType $identifierType,
        ?SourceFilter $sourceFilter,
    ): Generator
    {
        foreach ($this->sourceLocators as $sourceLocator) {
            yield from $sourceLocator->iterateIdentifiersByType($reflector, $identifierType, $sourceFilter);
        }
    }
}
