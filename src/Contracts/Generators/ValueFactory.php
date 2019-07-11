<?php

declare(strict_types=1);

namespace PhpUnitGen\Core\Contracts\Generators;

use PhpUnitGen\Core\Models\TestClass;
use Roave\BetterReflection\Reflection\ReflectionType;

/**
 * Interface ValueFactory.
 *
 * A factory to create values as PHP string.
 *
 * @author  Paul Thébaud <paul.thebaud29@gmail.com>
 * @author  Killian Hascoët <killianh@live.fr>
 * @license MIT
 */
interface ValueFactory
{
    /**
     * Generate a PHP value for the given type.
     *
     * @param TestClass           $class
     * @param ReflectionType|null $reflectionType
     *
     * @return string
     */
    public function make(TestClass $class, ?ReflectionType $reflectionType): string;
}
