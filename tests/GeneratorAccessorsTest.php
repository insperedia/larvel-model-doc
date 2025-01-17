<?php

namespace romanzipp\ModelDoc\Tests;

use romanzipp\ModelDoc\Services\DocumentationGenerator;
use romanzipp\ModelDoc\Services\Objects\Model;

class GeneratorAccessorsTest extends TestCase
{
    public function testGeneratesAccessorProperties()
    {
        config([
            'model-doc.relations.enabled' => false,
            'model-doc.attributes.enabled' => false,
            'model-doc.accessors.enabled' => true,
        ]);

        $doc = (new DocumentationGenerator())->generateDocBlock(new Model(
            $this->getFile(__DIR__ . '/Support/ModelAccessors.php')
        ));

        self::assertDocBlock([
            '/**',
            ' * @property mixed $untyped',
            ' * @property string $some_string',
            ' * @property int $some_int',
            ' * @property array $some_array',
            ' * @property \romanzipp\ModelDoc\Tests\Support\ClassNotExtendingIlluminateModel $some_instance',
            ' */',
        ], $doc);
    }

    public function testDontGenerateAttributeTagIfAccessorExists()
    {
        config([
            'model-doc.relations.enabled' => false,
            'model-doc.attributes.enabled' => true,
            'model-doc.accessors.enabled' => true,
        ]);

        $doc = (new DocumentationGenerator())->generateDocBlock(new Model(
            $this->getFile(__DIR__ . '/Support/ModelAccessorsDuplicateAttribute.php')
        ));

        self::assertDocBlock([
            '/**',
            ' * @property int $column_integer',
            ' * @property int|null $column_integer_nullable',
            ' * @property string|null $column_string_nullable',
            ' * @property \DateTime|string $column_datetime',
            ' * @property \DateTime|string|null $column_datetime_nullable',
            ' * @property bool $column_boolean',
            ' * @property bool|null $column_boolean_nullable',
            ' * @property int $column_string',
            ' */',
        ], $doc);
    }
}
