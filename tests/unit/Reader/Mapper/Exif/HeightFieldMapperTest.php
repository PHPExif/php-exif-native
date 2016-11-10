<?php

namespace Tests\PHPExif\Adapter\Native\Reader\Mapper\Exif;

use Mockery as m;
use PHPExif\Adapter\Native\Reader\Mapper\Exif\HeightFieldMapper;
use PHPExif\Common\Data\Exif;
use PHPExif\Common\Data\ValueObject\Height;

/**
 * Class: HeightFieldMapperTest
 *
 * @see \PHPUnit_Framework_TestCase
 * @coversDefaultClass \PHPExif\Adapter\Native\Reader\Mapper\Exif\HeightFieldMapper
 * @covers ::<!public>
 */
class HeightFieldMapperTest extends BaseFieldMapperTest
{
    /**
     * FQCN of the fieldmapper being tested
     *
     * @var mixed
     */
    protected $fieldMapperClass = HeightFieldMapper::class;

    /**
     * List of supported fields
     *
     * @var array
     */
    protected $supportedFields = [
        Height::class,
    ];

    /**
     * Valid input data
     *
     * @var array
     */
    protected $validInput = [
        'COMPUTED' => [
            'Height' => 1024,
        ],
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

        $originalData = $output->getHeight();
        $mapper->mapField($field, $this->validInput, $output);
        $newData = $output->getHeight();

        $this->assertNotSame($originalData, $newData);

        $this->assertInstanceOf(
            Height::class,
            $newData
        );

        $this->assertEquals(
            $this->validInput['COMPUTED']['Height'],
            $newData->getValue()
        );
    }
}
