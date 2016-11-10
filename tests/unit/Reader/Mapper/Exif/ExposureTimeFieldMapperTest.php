<?php

namespace Tests\PHPExif\Adapter\Native\Reader\Mapper\Exif;

use Mockery as m;
use PHPExif\Adapter\Native\Reader\Mapper\Exif\ExposureTimeFieldMapper;
use PHPExif\Common\Data\Exif;
use PHPExif\Common\Data\ValueObject\ExposureTime;

/**
 * Class: ExposureTimeFieldMapperTest
 *
 * @see \PHPUnit_Framework_TestCase
 * @coversDefaultClass \PHPExif\Adapter\Native\Reader\Mapper\Exif\ExposureTimeFieldMapper
 * @covers ::<!public>
 */
class ExposureTimeFieldMapperTest extends BaseFieldMapperTest
{
    /**
     * FQCN of the fieldmapper being tested
     *
     * @var mixed
     */
    protected $fieldMapperClass = ExposureTimeFieldMapper::class;

    /**
     * List of supported fields
     *
     * @var array
     */
    protected $supportedFields = [
        ExposureTime::class,
    ];

    /**
     * Valid input data
     *
     * @var array
     */
    protected $validInput = [
        'ExposureTime' => '10/300',
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

        $originalData = $output->getExposureTime();
        $mapper->mapField($field, $this->validInput, $output);
        $newData = $output->getExposureTime();

        $this->assertNotSame($originalData, $newData);

        $this->assertInstanceOf(
            ExposureTime::class,
            $newData
        );

        $this->assertEquals(
            '1/30',
            (string) $newData
        );
    }
}
