<?php

namespace Tests\PHPExif\Adapter\Native\Reader;

use Mockery as m;
use PHPExif\Adapter\Native\Reader\Mapper;
use PHPExif\Adapter\Native\Reader\MapperFactory;
use PHPExif\Adapter\Native\Reader\Mapper\ExifMapper;
use PHPExif\Adapter\Native\Reader\Mapper\IptcMapper;
use PHPExif\Common\Data\Exif;
use PHPExif\Common\Data\Iptc;
use PHPExif\Common\Data\Metadata;

/**
 * Class: MapperFactoryTest
 *
 * @see \PHPUnit_Framework_TestCase
 * @coversDefaultClass \PHPExif\Adapter\Native\Reader\MapperFactory
 * @covers ::<!public>
 */
class MapperFactoryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @covers ::getMapper
     * @group functional
     *
     * @return void
     */
    public function testGetMapperReturnsMapper()
    {
        $mapper = MapperFactory::getMapper();

        $this->assertInstanceOf(
            Mapper::class,
            $mapper
        );

        $exifMapper = $mapper->getFieldMapper(Exif::class);

        $this->assertInstanceOf(
            ExifMapper::class,
            $exifMapper
        );

        $exifFieldMappers = $exifMapper->getFieldMappers();
        $this->assertGreaterThan(
            0,
            count($exifFieldMappers)
        );

        $iptcMapper = $mapper->getFieldMapper(Iptc::class);

        $this->assertInstanceOf(
            IptcMapper::class,
            $iptcMapper
        );

        $iptcFieldMappers = $iptcMapper->getFieldMappers();
        $this->assertGreaterThan(
            0,
            count($iptcFieldMappers)
        );
    }
}
