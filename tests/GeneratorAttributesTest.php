<?php

namespace romanzipp\ModelDoc\Tests;

use romanzipp\ModelDoc\Services\DocumentationGenerator;
use romanzipp\ModelDoc\Services\Objects\Model;

class GeneratorAttributesTest extends TestCase
{
    public function testBasicAttributes()
    {
        $doc = (new DocumentationGenerator())->generateDocBlock(new Model(
            $this->getFile(__DIR__ . '/Support/ModelBasic.php')
        ));

        self::assertDocBlock([
            '/**',
            ' * @property int $column_integer',
            ' * @property int|null $column_integer_nullable',
            ' * @property string $column_string',
            ' * @property string|null $column_string_nullable',
            ' * @property \DateTime|string $column_datetime',
            ' * @property \DateTime|string|null $column_datetime_nullable',
            ' * @property bool $column_boolean',
            ' * @property bool|null $column_boolean_nullable',
            ' */',
        ], $doc);
    }

    public function testAttributesDisabled()
    {
        config([
            'model-doc.attributes.enabled' => false,
        ]);

        $doc = (new DocumentationGenerator())->generateDocBlock(new Model(
            $this->getFile(__DIR__ . '/Support/ModelBasic.php')
        ));

        self::assertDocBlock([
            '/**',
            ' */',
        ], $doc);
    }

    public function testAttributesCasted()
    {
        $doc = (new DocumentationGenerator())->generateDocBlock(new Model(
            $this->getFile(__DIR__ . '/Support/ModelBasicWithCasts.php')
        ));

        self::assertDocBlock([
            '/**',
            ' * @property string $column_integer',
            ' * @property string|null $column_integer_nullable',
            ' * @property string $column_string',
            ' * @property string|null $column_string_nullable',
            ' * @property \DateTime|string $column_datetime',
            ' * @property \DateTime|string|null $column_datetime_nullable',
            ' * @property bool $column_boolean',
            ' * @property bool|null $column_boolean_nullable',
            ' */',
        ], $doc);
    }

    public function testSpecialModelTypes()
    {
        $doc = (new DocumentationGenerator())->generateDocBlock(new Model(
            $this->getFile(__DIR__ . '/Support/ModelSpecialAttributes.php')
        ));

        self::assertDocBlock([
            '/**',
            ' * @property string $column_enum',
            ' */',
        ], $doc);
    }
}
