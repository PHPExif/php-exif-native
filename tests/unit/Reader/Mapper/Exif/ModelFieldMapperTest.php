<?php

namespace Tests\PHPExif\Adapter\Native\Reader\Mapper\Exif;

use Mockery as m;
use PHPExif\Adapter\Native\Reader\Mapper\Exif\ModelFieldMapper;
use PHPExif\Common\Data\Exif;
use PHPExif\Common\Data\ValueObject\Model;

/**
 * Class: ModelFieldMapperTest
 *
 * @see \PHPUnit_Framework_TestCase
 * @coversDefaultClass \PHPExif\Adapter\Native\Reader\Mapper\Exif\ModelFieldMapper
 * @covers ::<!public>
 */
class ModelFieldMapperTest extends BaseFieldMapperTest
{
    /**
     * FQCN of the fieldmapper being tested
     *
     * @var mixed
     */
    protected $fieldMapperClass = ModelFieldMapper::class;

    /**
     * List of supported fields
     *
     * @var array
     */
    protected $supportedFields = [
        Model::class,
    ];

    /**
     * Valid input data
     *
     * @var array
     */
    protected $validInput = [
        'model' => 'NIKON D90',
    ];

    /**
     * @covers ::mapField
     * @group mapper
     *
     * @return void
     */
    public function testMapFieldHasDataInOutput()
    {
        $field = reset($this->supportedFields);
        $output = new Exif;
        $mapper = new $this->fieldMapperClass();

        $originalData = $output->getModel();
        $mapper->mapField($field, $this->validInput, $output);
        $newData = $output->getModel();

        $this->assertNotSame($originalData, $newData);

        $this->assertInstanceOf(
            Model::class,
            $newData
        );

        $this->assertEquals(
            $this->validInput['model'],
            (string) $newData
        );
    }
}
