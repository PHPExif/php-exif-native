<?php

namespace Tests\PHPExif\Adapter\Native\Reader\Mapper\Exif;

use Mockery as m;
use PHPExif\Adapter\Native\Reader\Mapper\Exif\WidthFieldMapper;
use PHPExif\Common\Data\Exif;
use PHPExif\Common\Data\ValueObject\Width;

/**
 * Class: WidthFieldMapperTest
 *
 * @see \PHPUnit_Framework_TestCase
 * @coversDefaultClass \PHPExif\Adapter\Native\Reader\Mapper\Exif\WidthFieldMapper
 * @covers ::<!public>
 */
class WidthFieldMapperTest extends BaseFieldMapperTest
{
    /**
     * FQCN of the fieldmapper being tested
     *
     * @var mixed
     */
    protected $fieldMapperClass = WidthFieldMapper::class;

    /**
     * List of supported fields
     *
     * @var array
     */
    protected $supportedFields = [
        Width::class,
    ];

    /**
     * Valid input data
     *
     * @var array
     */
    protected $validInput = [
        'COMPUTED' => [
            'Width' => 1024,
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
}
