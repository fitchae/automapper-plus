<?php

namespace AutoMapperPlus\MappingOperation;

use AutoMapperPlus\Configuration\Options;
use AutoMapperPlus\NameConverter\NamingConvention\CamelCaseNamingConvention;
use AutoMapperPlus\NameConverter\NamingConvention\SnakeCaseNamingConvention;
use PHPUnit\Framework\TestCase;
use Test\Models\NamingConventions\CamelCaseSource;
use Test\Models\NamingConventions\SnakeCaseSource;
use Test\Models\SimpleProperties\Destination;
use Test\Models\SimpleProperties\Source;

/**
 * Class DefaultMappingOperationTest
 *
 * @package AutoMapperPlus\MappingOperation
 * @group mappingOperations
 */
class DefaultMappingOperationTest extends TestCase
{
    /**
     * @var DefaultMappingOperation
     */
    protected $operation;

    public function setUp()
    {
        $this->operation = new DefaultMappingOperation();
        $this->operation->setOptions(Options::default());
    }

    public function testItMapsAProperty()
    {
        $source = new Source();
        $source->name = 'Hello, world';
        $destination = new Destination();

        $this->operation->mapProperty('name', $source, $destination);

        $this->assertEquals('Hello, world', $destination->name);
    }

    public function testItCanResolveNamingConventions()
    {
        $options = Options::default();
        $options->setSourceMemberNamingConvention(new CamelCaseNamingConvention());
        $options->setDestinationMemberNamingConvention(new SnakeCaseNamingConvention());
        $this->operation->setOptions($options);

        $source = new CamelCaseSource();
        $source->propertyName = 'ima property';
        $destination = new SnakeCaseSource();
        $this->operation->mapProperty('property_name', $source, $destination);

        $this->assertEquals('ima property', $destination->property_name);
    }
}
