<?php

namespace Tests\PHPExif\Adapter\Native\Reader\Mapper;

use Mockery as m;
use PHPExif\Adapter\Native\Reader\Mapper\ExifMapper;
use PHPExif\Common\Data\Exif;
use PHPExif\Common\Data\Iptc;
use PHPExif\Common\Data\Metadata;
use PHPExif\Common\Exception\Mapper\UnsupportedFieldException;
use PHPExif\Common\Exception\Mapper\UnsupportedOutputException;
use PHPExif\Common\Mapper\FieldMapper;

/**
 * Class: ExifMapperTest
 *
 * @see \PHPUnit_Framework_TestCase
 * @coversDefaultClass \PHPExif\Adapter\Native\Reader\Mapper\ExifMapper
 * @covers ::<!public>
 */
class ExifMapperTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @covers ::getSupportedFields
     * @group mapper
     *
     * @return void
     */
    public function testGetSupportedFieldsReturnsExpectedArray()
    {
        $exifMapper = new ExifMapper();
        $actual = $exifMapper->getSupportedFields();

        $this->assertInternalType('array', $actual);

        $expected = [
            Exif::class,
        ];

        $this->assertEquals($expected, $actual);
    }

    /**
     * @covers ::mapArray
     * @group mapper
     *
     * @return void
     */
    public function testMapArrayThrowsExceptionForWrongOutput()
    {
        $this->setExpectedException(UnsupportedOutputException::class);

        $input= [];
        $output = new \stdClass;

        $exifMapper = new ExifMapper();

        $exifMapper->mapArray($input, $output);
    }

    /**
     * @covers ::mapArray
     * @group mapper
     *
     * @return void
     */
    public function testMapArrayAcceptsExifClass()
    {
        $input= [];
        $output = new Exif;
        $exifMapper = new ExifMapper();
        try {
            $exifMapper->mapArray($input, $output);
        } catch (\Exception $e) {
            $this->fail('Should not throw exception');
        }
    }

    /**
     * @covers ::mapArray
     * @group mapper
     *
     * @return void
     */
    public function testMapArrayForwardsCall()
    {
        $input = [];
        $output = new Exif;
        $mapper = new ExifMapper;

        foreach (array('foo', 'bar') as $field) {
            $fieldMapper = m::mock(FieldMapper::class . '[getSupportedFields,mapField]');
            $fieldMapper->shouldReceive('getSupportedFields')
                ->once()
                ->andReturn(array($field));
            $fieldMapper->shouldReceive('mapField')
                ->once()
                ->with(
                    $field,
                    $input,
                    m::type(Exif::class)
                )
                ->andReturnNull();

            $mapper->registerFieldMapper($fieldMapper);
        }

        $mapper->mapArray($input, $output);
    }

    /**
     * @covers ::mapField
     * @group mapper
     *
     * @return void
     */
    public function testMapFieldThrowsExceptionForUnsupportedField()
    {
        $this->setExpectedException(UnsupportedFieldException::class);

        $field = 'foo';
        $input = [];
        $output = new Metadata(new Exif, new Iptc);
        $mapper = new ExifMapper;

        $mapper->mapField($field, $input, $output);
    }

    /**
     * @covers ::mapField
     * @group mapper
     *
     * @return void
     */
    public function testMapFieldThrowsExceptionForUnsupportedOutput()
    {
        $this->setExpectedException(UnsupportedOutputException::class);

        $field = Exif::class;
        $input = [];
        $output = new \stdClass;
        $mapper = new ExifMapper;

        $mapper->mapField($field, $input, $output);
    }

    /**
     * @covers ::mapField
     * @group mapper
     *
     * @return void
     */
    public function testMapFieldForwardsToMapArray()
    {
        $field = Exif::class;
        $input = [];
        $output = new Metadata(new Exif, new Iptc);
        $mapper = m::mock(ExifMapper::class . '[mapArray]');
        $mapper->shouldReceive('mapArray')
            ->once()
            ->with(
                $input,
                m::type(Exif::class)
            )
            ->andReturnNull();
        $mapper->mapField($field, $input, $output);
    }
}
