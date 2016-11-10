<?php

namespace Tests\PHPExif\Adapter\Native\Reader\Mapper\Exif;

use Mockery as m;
use PHPExif\Adapter\Native\Reader\Mapper\Exif\ResolutionFieldMapper;
use PHPExif\Common\Data\Exif;
use PHPExif\Common\Data\ValueObject\HorizontalResolution;
use PHPExif\Common\Data\ValueObject\VerticalResolution;

/**
 * Class: ResolutionFieldMapperTest
 *
 * @see \PHPUnit_Framework_TestCase
 * @coversDefaultClass \PHPExif\Adapter\Native\Reader\Mapper\Exif\ResolutionFieldMapper
 * @covers ::<!public>
 */
class ResolutionFieldMapperTest extends BaseFieldMapperTest
{
    /**
     * FQCN of the fieldmapper being tested
     *
     * @var mixed
     */
    protected $fieldMapperClass = ResolutionFieldMapper::class;

    /**
     * List of supported fields
     *
     * @var array
     */
    protected $supportedFields = [
        HorizontalResolution::class,
        VerticalResolution::class,
    ];

    /**
     * Valid input data
     *
     * @var array
     */
    protected $validInput = [
        'XResolution' => '300/1',
        'YResolution' => '300/1',
    ];

    /**
     * @covers ::mapField
     * @group mapper
     *
     * @return void
     */
    public function testMapFieldHasHorizontalResolutionDataInOutput()
    {
        $field = reset($this->supportedFields);
        $output = new Exif;
        $mapper = new $this->fieldMapperClass();

        $originalData = $output->getHorizontalResolution();
        $mapper->mapField($field, $this->validInput, $output);
        $newData = $output->getHorizontalResolution();

        $this->assertNotSame($originalData, $newData);

        $this->assertInstanceOf(
            HorizontalResolution::class,
            $newData
        );

        $this->assertEquals(
            300,
            $newData->getValue()
        );
    }

    /**
     * @covers ::mapField
     * @group mapper
     *
     * @return void
     */
    public function testMapFieldHasVerticalResolutionDataInOutput()
    {
        $field = end($this->supportedFields);
        $output = new Exif;
        $mapper = new $this->fieldMapperClass();

        $originalData = $output->getVerticalResolution();
        $mapper->mapField($field, $this->validInput, $output);
        $newData = $output->getVerticalResolution();

        $this->assertNotSame($originalData, $newData);

        $this->assertInstanceOf(
            VerticalResolution::class,
            $newData
        );

        $this->assertEquals(
            300,
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

        $originalVerticalResolution = $output->getVerticalResolution();
        $originalHorizontalResolution = $output->getHorizontalResolution();

        foreach ($this->supportedFields as $field) {
            $mapper->mapField($field, $this->validInput, $output);
        }
        $newVerticalResolution = $output->getVerticalResolution();
        $newHorizontalResolution = $output->getHorizontalResolution();

        $this->assertNotSame($originalVerticalResolution, $newVerticalResolution);
        $this->assertNotSame($originalHorizontalResolution, $newHorizontalResolution);

        $this->assertInstanceOf(
            VerticalResolution::class,
            $newVerticalResolution
        );
        $this->assertInstanceOf(
            HorizontalResolution::class,
            $newHorizontalResolution
        );

        $this->assertEquals(
            300,
            $newVerticalResolution->getValue()
        );
        $this->assertEquals(
            300,
            $newHorizontalResolution->getValue()
        );
    }
}
