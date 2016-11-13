<?php

namespace Tests\PHPExif\Adapter\Native\Reader\Mapper\Exif;

use Mockery as m;
use PHPExif\Adapter\Native\Reader\Mapper\Exif\DimensionsFieldMapper;
use PHPExif\Common\Data\Exif;
use PHPExif\Common\Data\ValueObject\Height;
use PHPExif\Common\Data\ValueObject\Width;

/**
 * Class: DimensionsFieldMapperTest
 *
 * @see \PHPUnit_Framework_TestCase
 * @coversDefaultClass \PHPExif\Adapter\Native\Reader\Mapper\Exif\DimensionsFieldMapper
 * @covers ::<!public>
 */
class DimensionsFieldMapperTest extends BaseFieldMapperTest
{
    /**
     * FQCN of the fieldmapper being tested
     *
     * @var mixed
     */
    protected $fieldMapperClass = DimensionsFieldMapper::class;

    /**
     * List of supported fields
     *
     * @var array
     */
    protected $supportedFields = [
        Height::class,
        Width::class,
    ];

    /**
     * Valid input data
     *
     * @var array
     */
    protected $validInput = [
        'COMPUTED' => [
            'Height' => 1024,
            'Width' => 2048,
        ],
    ];

    /**
     * @covers ::mapField
     * @group mapper
     *
     * @return void
     */
    public function testMapFieldHasHeightDataInOutput()
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

    /**
     * @covers ::mapField
     * @group mapper
     *
     * @return void
     */
    public function testMapFieldHasWidthDataInOutput()
    {
        $field = end($this->supportedFields);
        $output = new Exif;
        $mapper = new $this->fieldMapperClass();

        $originalData = $output->getWidth();
        $mapper->mapField($field, $this->validInput, $output);
        $newData = $output->getWidth();

        $this->assertNotSame($originalData, $newData);

        $this->assertInstanceOf(
            Width::class,
            $newData
        );

        $this->assertEquals(
            $this->validInput['COMPUTED']['Width'],
            $newData->getValue()
        );
    }

    /**
     * @covers ::mapField
     * @group mapper
     *
     * @return void
     */
    public function testMapFieldHasAllDataInOutput()
    {
        $output = new Exif;
        $mapper = new $this->fieldMapperClass();

        $originalWidth = $output->getWidth();
        $originalHeight = $output->getHeight();

        foreach ($this->supportedFields as $field) {
            $mapper->mapField($field, $this->validInput, $output);
        }
        $newWidth = $output->getWidth();
        $newHeight = $output->getHeight();

        $this->assertNotSame($originalWidth, $newWidth);
        $this->assertNotSame($originalHeight, $newHeight);

        $this->assertInstanceOf(
            Width::class,
            $newWidth
        );
        $this->assertInstanceOf(
            Height::class,
            $newHeight
        );

        $this->assertEquals(
            $this->validInput['COMPUTED']['Width'],
            $newWidth->getValue()
        );
        $this->assertEquals(
            $this->validInput['COMPUTED']['Height'],
            $newHeight->getValue()
        );
    }
}
