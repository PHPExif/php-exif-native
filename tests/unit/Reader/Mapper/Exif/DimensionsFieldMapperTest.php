<?php

namespace Tests\PHPExif\Adapter\Native\Reader\Mapper\Exif;

use Mockery as m;
use PHPExif\Adapter\Native\Reader\Mapper\Exif\DimensionsFieldMapper;
use PHPExif\Common\Data\Exif;
use PHPExif\Common\Data\ValueObject\Dimensions;
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
        Dimensions::class,
    ];

    /**
     * Valid input data
     *
     * @var array
     */
    protected $validInput = [
        'computed' => [
            'height' => 1024,
            'width' => 2048,
        ],
    ];

    /**
     * @covers ::mapField
     * @group mapper
     *
     * @return void
     */
    public function testMapFieldHasDimensionsDataInOutput()
    {
        $field = reset($this->supportedFields);
        $output = new Exif;
        $mapper = new $this->fieldMapperClass();

        $originalData = $output->getDimensions();
        $mapper->mapField($field, $this->validInput, $output);
        $newData = $output->getDimensions();

        $this->assertNotSame($originalData, $newData);

        $this->assertInstanceOf(
            Dimensions::class,
            $newData
        );
    }

    /**
     * @covers ::mapField
     * @group mapper
     *
     * @return void
     */
    public function testMapFieldAbortsWhenNotCorrectDataInInput()
    {
        $field = reset($this->supportedFields);
        $output = new Exif;
        $mapper = new $this->fieldMapperClass();

        $mapper->mapField($field, ['computed' => ['foo' => 'bar',]], $output);
        $dimensions = $output->getDimensions();

        $this->assertNull($dimensions);
    }

    /**
     * @covers ::mapField
     * @group mapper
     *
     * @return void
     */
    public function testDimensionsHasCorrectData()
    {
        $field = reset($this->supportedFields);
        $output = new Exif;
        $mapper = new $this->fieldMapperClass();

        $mapper->mapField($field, $this->validInput, $output);
        $dimensions = $output->getDimensions();

        $width = $dimensions->getWidth();
        $this->assertInstanceOf(
            Width::class,
            $width
        );
        $this->assertEquals(
            $width->getValue(),
            2048
        );

        $height = $dimensions->getHeight();
        $this->assertInstanceOf(
            Height::class,
            $height
        );
        $this->assertEquals(
            $height->getValue(),
            1024
        );
    }
}
