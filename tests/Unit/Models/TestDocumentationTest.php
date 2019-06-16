<?php

declare(strict_types=1);

namespace Tests\PhpUnitGen\Core\Unit\Models;

use Mockery;
use PhpUnitGen\Core\Contracts\Renderers\Renderer;
use PhpUnitGen\Core\Models\TestDocumentation;
use Tests\PhpUnitGen\Core\TestCase;

/**
 * Class TestDocumentationTest.
 *
 * @covers \PhpUnitGen\Core\Models\TestDocumentation
 */
class TestDocumentationTest extends TestCase
{
    /**
     * @var TestDocumentation
     */
    protected $documentation;

    /**
     * {@inheritdoc}
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->documentation = new TestDocumentation('@covers Foo');
    }

    public function testItConstructs(): void
    {
        $this->assertSame([
            '@covers Foo',
        ], $this->documentation->getLines()->toArray());
    }

    public function testItAcceptsRenderer(): void
    {
        $renderer = Mockery::mock(Renderer::class);

        $renderer->shouldReceive('visitTestDocumentation')
            ->once()
            ->with($this->documentation);

        $this->documentation->accept($renderer);
    }

    public function testItAddsLine(): void
    {
        $this->assertSame(1, $this->documentation->getLines()->count());

        $this->documentation->addLine('@covers Bar');

        $this->assertSame(2, $this->documentation->getLines()->count());
        $this->assertSame('@covers Bar', $this->documentation->getLines()->last());
    }

    public function testItRemovesLine(): void
    {
        $this->assertSame(1, $this->documentation->getLines()->count());

        $this->documentation->removeLine();

        $this->assertSame(0, $this->documentation->getLines()->count());
    }

    public function testItPrepends(): void
    {
        $this->documentation->prepend('@author bar ');

        $this->assertSame('@author bar @covers Foo', $this->documentation->getLines()->last());
    }

    public function testItAppends(): void
    {
        $this->documentation->append(' @author bar');

        $this->assertSame('@covers Foo @author bar', $this->documentation->getLines()->last());
    }

    public function testItPrependsWhenCustomKey(): void
    {
        $this->documentation->addLine('new line which wont be updated');

        $this->documentation->prepend('@author bar ', 0);

        $this->assertSame('@author bar @covers Foo', $this->documentation->getLines()->first());
    }

    public function testItAppendsWhenCustomKey(): void
    {
        $this->documentation->addLine('new line which wont be updated');

        $this->documentation->append(' @author bar', 0);

        $this->assertSame('@covers Foo @author bar', $this->documentation->getLines()->first());
    }
}
