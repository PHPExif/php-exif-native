<?php

namespace Tests\PHPExif\Adapter\Native\Reader\Mapper\Exif;

use Mockery as m;
use PHPExif\Adapter\Native\Reader\Mapper\Exif\CoordinatesFieldMapper;
use PHPExif\Common\Data\Exif;
use PHPExif\Common\Data\ValueObject\Coordinates;
use PHPExif\Common\Data\ValueObject\DigitalDegrees;

/**
 * Class: CoordinatesFieldMapperTest
 *
 * @see \PHPUnit_Framework_TestCase
 * @coversDefaultClass \PHPExif\Adapter\Native\Reader\Mapper\Exif\CoordinatesFieldMapper
 * @covers ::<!public>
 */
class CoordinatesFieldMapperTest extends BaseFieldMapperTest
{
    /**
     * FQCN of the fieldmapper being tested
     *
     * @var mixed
     */
    protected $fieldMapperClass = CoordinatesFieldMapper::class;

    /**
     * List of supported fields
     *
     * @var array
     */
    protected $supportedFields = [
        Coordinates::class,
    ];

    /**
     * Valid input data
     *
     * @var array
     */
    protected $validInput = [
        'GPSLatitude' => ['4000/100', '4400/100', '30822/1000'],
        'GPSLongitude' => [73, 59, 21.508],
        'GPSLatitudeRef' => 'N',
        'GPSLongitudeRef' => 'W',
    ];

    /**
     * @covers ::mapField
     * @group mapper
     *
     * @return void
     */
    public function testMapFieldHasCoordinatesDataInOutput()
    {
        $field = reset($this->supportedFields);
        $output = new Exif;
        $mapper = new $this->fieldMapperClass();

        $originalData = $output->getCoordinates();
        $mapper->mapField($field, $this->validInput, $output);
        $newData = $output->getCoordinates();

        $this->assertNotSame($originalData, $newData);

        $this->assertInstanceOf(
            Coordinates::class,
            $newData
        );
    }

    /**
     * @covers ::mapField
     * @group mapper
     *
     * @return void
     */
    public function testCoordinatesHasCorrectData()
    {
        $field = reset($this->supportedFields);
        $output = new Exif;
        $mapper = new $this->fieldMapperClass();

        $mapper->mapField($field, $this->validInput, $output);
        $coordinates = $output->getCoordinates();

        $latitude = $coordinates->getLatitude();
        $this->assertInstanceOf(
            DigitalDegrees::class,
            $latitude
        );
        $this->assertEquals(
            40.741895,
            $latitude->getValue()
        );

        $longitude = $coordinates->getLongitude();
        $this->assertInstanceOf(
            DigitalDegrees::class,
            $longitude
        );
        $this->assertEquals(
            -73.989308,
            $longitude->getValue()
        );
    }
}
