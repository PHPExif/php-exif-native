<?php

namespace Tests\PHPExif\Adapter\Native\Reader\Mapper\Exif;

use Mockery as m;
use PHPExif\Adapter\Native\Reader\Mapper\Exif\SoftwareFieldMapper;
use PHPExif\Common\Data\Exif;
use PHPExif\Common\Data\ValueObject\Software;

/**
 * Class: SoftwareFieldMapperTest
 *
 * @see \PHPUnit_Framework_TestCase
 * @coversDefaultClass \PHPExif\Adapter\Native\Reader\Mapper\Exif\SoftwareFieldMapper
 * @covers ::<!public>
 */
class SoftwareFieldMapperTest extends BaseFieldMapperTest
{
    /**
     * FQCN of the fieldmapper being tested
     *
     * @var mixed
     */
    protected $fieldMapperClass = SoftwareFieldMapper::class;

    /**
     * List of supported fields
     *
     * @var array
     */
    protected $supportedFields = [
        Software::class,
    ];

    /**
     * Valid input data
     *
     * @var array
     */
    protected $validInput = [
        'software' => 'Adobe Lightroom 6.0',
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

        $originalData = $output->getSoftware();
        $mapper->mapField($field, $this->validInput, $output);
        $newData = $output->getSoftware();

        $this->assertNotSame($originalData, $newData);

        $this->assertInstanceOf(
            Software::class,
            $newData
        );

        $this->assertEquals(
            $this->validInput['software'],
            (string) $newData
        );
    }
}
