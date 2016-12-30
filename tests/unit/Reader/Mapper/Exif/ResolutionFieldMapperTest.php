<?php

namespace Tests\PHPExif\Adapter\Native\Reader\Mapper\Exif;

use Mockery as m;
use PHPExif\Adapter\Native\Reader\Mapper\Exif\ResolutionFieldMapper;
use PHPExif\Common\Data\Exif;
use PHPExif\Common\Data\ValueObject\LineResolution;
use PHPExif\Common\Data\ValueObject\Resolution;

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
        Resolution::class,
    ];

    /**
     * Valid input data
     *
     * @var array
     */
    protected $validInput = [
        'xresolution' => '300/1',
        'yresolution' => '300/1',
    ];

    /**
     * @covers ::mapField
     * @group mapper
     *
     * @return void
     */
    public function testMapFieldHasResolutionDataInOutput()
    {
        $field = reset($this->supportedFields);
        $output = new Exif;
        $mapper = new $this->fieldMapperClass();

        $originalData = $output->getResolution();
        $mapper->mapField($field, $this->validInput, $output);
        $newData = $output->getResolution();

        $this->assertNotSame($originalData, $newData);

        $this->assertInstanceOf(
            Resolution::class,
            $newData
        );
    }

    /**
     * @covers ::mapField
     * @group mapper
     *
     * @return void
     */
    public function testResolutionHasCorrectData()
    {
        $field = reset($this->supportedFields);
        $output = new Exif;
        $mapper = new $this->fieldMapperClass();

        $mapper->mapField($field, $this->validInput, $output);
        $resolution = $output->getResolution();

        $horizontal = $resolution->getHorizontalResolution();
        $this->assertInstanceOf(
            LineResolution::class,
            $horizontal
        );
        $this->assertEquals(
            $horizontal->getValue(),
            300
        );

        $vertical = $resolution->getVerticalResolution();
        $this->assertInstanceOf(
            LineResolution::class,
            $vertical
        );
        $this->assertEquals(
            $vertical->getValue(),
            300
        );
    }
}
