<?php

namespace Tests\PHPExif\Adapter\Native\Reader;

use Mockery as m;
use PHPExif\Adapter\Native\Reader\Mapper;
use PHPExif\Common\Data\Exif;
use PHPExif\Common\Data\Iptc;
use PHPExif\Common\Data\Metadata;
use PHPExif\Common\Mapper\FieldMapper;

/**
 * Class: MapperTest
 *
 * @see \PHPUnit_Framework_TestCase
 * @coversDefaultClass \PHPExif\Adapter\Native\Reader\Mapper
 * @covers ::<!public>
 */
class MapperTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @covers ::map
     * @group mapper
     *
     * @return void
     */
    public function testMapForwardsCall()
    {
        $input = [];
        $output = new Metadata(new Exif, new Iptc);

        $mock = m::mock(Mapper::class . '[mapArray]')->makePartial();
        $mock->shouldReceive('mapArray')
            ->once()
            ->with(
                $input,
                m::type(Metadata::class)
            )
            ->andReturnNull();

        $mock->map($input, $output);
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
        $output = new Metadata(
            new Exif,
            new Iptc
        );

        $mapper = new Mapper;

        foreach (array(Exif::class, Iptc::class) as $field) {
            $fieldMapper = m::mock(FieldMapper::class . '[getSupportedFields,mapField]');
            $fieldMapper->shouldReceive('getSupportedFields')
                ->once()
                ->andReturn(array($field));
            $fieldMapper->shouldReceive('mapField')
                ->once()
                ->with(
                    $field,
                    $input,
                    m::type(Metadata::class)
                )
                ->andReturnNull();

            $mapper->registerFieldMapper($fieldMapper);
        }

        $mapper->mapArray($input, $output);
    }
}
