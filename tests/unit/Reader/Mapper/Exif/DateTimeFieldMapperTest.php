<?php

namespace Tests\PHPExif\Adapter\Native\Reader\Mapper\Exif;

use Mockery as m;
use PHPExif\Adapter\Native\Reader\Mapper\Exif\DateTimeFieldMapper;
use PHPExif\Common\Data\Exif;
use \DateTimeImmutable;

/**
 * Class: DateTimeFieldMapperTest
 *
 * @see \PHPUnit_Framework_TestCase
 * @coversDefaultClass \PHPExif\Adapter\Native\Reader\Mapper\Exif\DateTimeFieldMapper
 * @covers ::<!public>
 */
class DateTimeFieldMapperTest extends BaseFieldMapperTest
{
    /**
     * FQCN of the fieldmapper being tested
     *
     * @var mixed
     */
    protected $fieldMapperClass = DateTimeFieldMapper::class;

    /**
     * List of supported fields
     *
     * @var array
     */
    protected $supportedFields = [
        DateTimeImmutable::class,
    ];

    /**
     * Valid input data
     *
     * @var array
     */
    protected $validInput = [
        'datetimeoriginal' => '2016-11-17 20:00:00',
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

        $originalData = $output->getCreationDate();
        $mapper->mapField($field, $this->validInput, $output);
        $newData = $output->getCreationDate();

        $this->assertNotSame($originalData, $newData);

        $this->assertInstanceOf(
            DateTimeImmutable::class,
            $newData
        );

        $this->assertEquals(
            $this->validInput['datetimeoriginal'],
            $newData->format('Y-m-d H:i:s')
        );
    }
}
