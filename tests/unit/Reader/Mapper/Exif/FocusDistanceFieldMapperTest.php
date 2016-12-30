<?php

namespace Tests\PHPExif\Adapter\Native\Reader\Mapper\Exif;

use Mockery as m;
use PHPExif\Adapter\Native\Reader\Mapper\Exif\FocusDistanceFieldMapper;
use PHPExif\Common\Data\Exif;
use PHPExif\Common\Data\ValueObject\FocusDistance;

/**
 * Class: FocusDistanceFieldMapperTest
 *
 * @see \PHPUnit_Framework_TestCase
 * @coversDefaultClass \PHPExif\Adapter\Native\Reader\Mapper\Exif\FocusDistanceFieldMapper
 * @covers ::<!public>
 */
class FocusDistanceFieldMapperTest extends BaseFieldMapperTest
{
    /**
     * FQCN of the fieldmapper being tested
     *
     * @var mixed
     */
    protected $fieldMapperClass = FocusDistanceFieldMapper::class;

    /**
     * List of supported fields
     *
     * @var array
     */
    protected $supportedFields = [
        FocusDistance::class,
    ];

    /**
     * Valid input data
     *
     * @var array
     */
    protected $validInput = [
        'computed' => [
            'focusdistance' => '7.98m',
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

        $originalData = $output->getFocusDistance();
        $mapper->mapField($field, $this->validInput, $output);
        $newData = $output->getFocusDistance();

        $this->assertNotSame($originalData, $newData);

        $this->assertInstanceOf(
            FocusDistance::class,
            $newData
        );

        $this->assertEquals(
            $this->validInput['computed']['focusdistance'],
            (string) $newData
        );
    }
}
