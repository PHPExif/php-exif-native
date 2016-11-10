<?php

namespace Tests\PHPExif\Adapter\Native;

use Mockery as m;
use PHPExif\Adapter\Native\Reader;
use PHPExif\Adapter\Native\Reader\MapperFactory;

/**
 * Class: ReaderTest
 *
 * @see \PHPUnit_Framework_TestCase
 * @coversDefaultClass \PHPExif\Adapter\Native\Reader
 * @covers ::<!public>
 */
class ReaderTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @covers ::getMetadataFromFile
     * @group functional
     *
     * @return void
     */
    public function testGetMetadataFromFile()
    {
        $mapper = MapperFactory::getMapper();
        $reader = new Reader($mapper);

        $metadata = $reader->getMetadataFromFile(
            __DIR__ . '/../fixtures/morning_glory_pool_500.jpg'
        );

        $this->assertEquals(
            'f/8',
            (string) $metadata->getExif()->getAperture()
        );
    }
}
