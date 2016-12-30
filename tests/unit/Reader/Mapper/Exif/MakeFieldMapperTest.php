<?php

namespace Tests\PHPExif\Adapter\Native\Reader\Mapper\Exif;

use Mockery as m;
use PHPExif\Adapter\Native\Reader\Mapper\Exif\MakeFieldMapper;
use PHPExif\Common\Data\Exif;
use PHPExif\Common\Data\ValueObject\Make;

/**
 * Class: MakeFieldMapperTest
 *
 * @see \PHPUnit_Framework_TestCase
 * @coversDefaultClass \PHPExif\Adapter\Native\Reader\Mapper\Exif\MakeFieldMapper
 * @covers ::<!public>
 */
class MakeFieldMapperTest extends BaseFieldMapperTest
{
    /**
     * FQCN of the fieldmapper being tested
     *
     * @var mixed
     */
    protected $fieldMapperClass = MakeFieldMapper::class;

    /**
     * List of supported fields
     *
     * @var array
     */
    protected $supportedFields = [
        Make::class,
    ];

    /**
     * Valid input data
     *
     * @var array
     */
    protected $validInput = [
        'make' => 'Canon',
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

        $originalData = $output->getMake();
        $mapper->mapField($field, $this->validInput, $output);
        $newData = $output->getMake();

        $this->assertNotSame($originalData, $newData);

        $this->assertInstanceOf(
            Make::class,
            $newData
        );

        $this->assertEquals(
            $this->validInput['make'],
            (string) $newData
        );
    }
}
