<?php

namespace Tests\PHPExif\Adapter\Native\Reader\Mapper;

use Mockery as m;
use PHPExif\Adapter\Native\Reader\Mapper\IptcMapper;
use PHPExif\Common\Data\Exif;
use PHPExif\Common\Data\Iptc;
use PHPExif\Common\Data\Metadata;
use PHPExif\Common\Exception\Mapper\UnsupportedFieldException;
use PHPExif\Common\Exception\Mapper\UnsupportedOutputException;
use PHPExif\Common\Mapper\FieldMapper;

/**
 * Class: IptcMapperTest
 *
 * @see \PHPUnit_Framework_TestCase
 * @coversDefaultClass \PHPExif\Adapter\Native\Reader\Mapper\IptcMapper
 * @covers ::<!public>
 */
class IptcMapperTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @covers ::getSupportedFields
     * @group mapper
     *
     * @return void
     */
    public function testGetSupportedFieldsReturnsExpectedArray()
    {
        $iptcMapper = new IptcMapper();
        $actual = $iptcMapper->getSupportedFields();

        $this->assertInternalType('array', $actual);

        $expected = [
            Iptc::class,
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

        $iptcMapper = new IptcMapper();

        $iptcMapper->mapArray($input, $output);
    }

    /**
     * @covers ::mapArray
     * @group mapper
     *
     * @return void
     */
    public function testMapArrayAcceptsIptcClass()
    {
        $input= [];
        $output = new Iptc;
        $iptcMapper = new IptcMapper();
        try {
            $iptcMapper->mapArray($input, $output);
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
        $output = new Iptc;
        $mapper = new IptcMapper;

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
                    m::type(Iptc::class)
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
        $mapper = new IptcMapper;

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

        $field = Iptc::class;
        $input = [];
        $output = new \stdClass;
        $mapper = new IptcMapper;

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
        $field = Iptc::class;
        $input = [];
        $output = new Metadata(new Exif, new Iptc);
        $mapper = m::mock(IptcMapper::class . '[mapArray]');
        $mapper->shouldReceive('mapArray')
            ->once()
            ->with(
                $input,
                m::type(Iptc::class)
            )
            ->andReturnNull();
        $mapper->mapField($field, $input, $output);
    }
}
