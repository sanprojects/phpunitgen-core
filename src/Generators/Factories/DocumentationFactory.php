<?php

declare(strict_types=1);

namespace PhpUnitGen\Core\Generators\Factories;

use phpDocumentor\Reflection\DocBlock\Tag;
use PhpUnitGen\Core\Aware\ConfigAwareTrait;
use PhpUnitGen\Core\Contracts\Aware\ConfigAware;
use PhpUnitGen\Core\Contracts\Generators\Factories\DocumentationFactory as DocumentationFactoryContract;
use PhpUnitGen\Core\Helpers\Reflect;
use PhpUnitGen\Core\Models\TestClass;
use PhpUnitGen\Core\Models\TestDocumentation;
use PhpUnitGen\Core\Models\TestImport;
use PhpUnitGen\Core\Models\TestMethod;
use PhpUnitGen\Core\Models\TestProperty;
use Tightenco\Collect\Support\Collection;

/**
 * Class DocumentationFactory.
 *
 * @author  Paul Thébaud <paul.thebaud29@gmail.com>
 * @author  Killian Hascoët <killianh@live.fr>
 * @license MIT
 */
class DocumentationFactory implements DocumentationFactoryContract, ConfigAware
{
    use ConfigAwareTrait;

    /**
     * {@inheritdoc}
     */
    public function makeForClass(TestClass $class): TestDocumentation
    {
        $documentation = new TestDocumentation("Class {$class->getShortName()}.");
        $documentation->addLine();

        $hasDocumentation = $this->makeMergedDocLines($class)
            ->merge($this->config->phpDoc())
            ->unique()
            ->each(function ($line) use ($documentation) {
                $documentation->addLine($line);
            })
            ->isNotEmpty();

        if ($hasDocumentation) {
            $documentation->addLine();
        }

        return $documentation->addLine('@coversDefaultClass \\'.$class->getReflectionClass()->getName());
    }

    /**
     * {@inheritdoc}
     */
    public function makeForProperty(TestProperty $property, $types): TestDocumentation
    {
        // Here we will make a collection if $types is not one already, and map to
        // retrieve type as string format.
        $typesString = Collection::wrap($types)
            ->map(function ($import) {
                if ($import instanceof TestImport) {
                    return $import->getFinalName();
                }

                return $import;
            })
            ->implode('|');

        return new TestDocumentation('@var '.$typesString);
    }

    /**
     * {@inheritdoc}
     */
    public function makeForInheritedMethod(TestMethod $method): TestDocumentation
    {
        return new TestDocumentation('{@inheritdoc}');
    }

    /**
     * Retrieve the merged doc lines from tested class.
     *
     * @param TestClass $class
     *
     * @return Collection
     */
    protected function makeMergedDocLines(TestClass $class): Collection
    {
        return Reflect::docBlockTags($class->getReflectionClass())
            ->reject(function (Tag $tag) {
                return ! in_array($tag->getName(), $this->config->mergedPhpDoc());
            })
            ->map(function (Tag $tag) {
                return $tag->render();
            });
    }
}
