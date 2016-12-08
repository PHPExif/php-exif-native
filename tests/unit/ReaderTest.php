<?php

namespace
{
    $mockExifReadData = null;
}

namespace PHPExif\Adapter\Native
{
    use Mockery as m;
    use PHPExif\Adapter\Native\Reader;
    use PHPExif\Common\Adapter\MapperInterface;
    use PHPExif\Common\Data\Metadata;
    use PHPExif\Common\Exception\Reader\NoExifDataException;
    use \ReflectionProperty;

    // stub the function
    function exif_read_data($filename, $sections = null, $arrays = false, $thumbnail = false)
    {
        global $mockExifReadData;

        if (null === $mockExifReadData) {
            return \exif_read_data(
                $filename,
                $sections,
                $arrays,
                $thumbnail
            );
        }

        return $mockExifReadData;
    }


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
         * @covers ::__construct
         * @dataProvider defaultPropertyValues
         * @group reader
         *
         * @return void
         */
        public function testConstructorSetsDefaultConfiguration($propertyName, $expectedValue)
        {
            $mapper = m::mock(MapperInterface::class);
            $reader = new Reader($mapper);

            $reflProp = new ReflectionProperty(Reader::class, $propertyName);
            $reflProp->setAccessible(true);

            $this->assertEquals(
                $expectedValue,
                $reflProp->getValue($reader)
            );
        }

        /**
         * @return array
         */
        public function defaultPropertyValues()
        {
            return [
                [
                    'sections',
                    null
                ],
                [
                    'asArrays',
                    false
                ],
                [
                    'thumbnailInfo',
                    false
                ],
                [
                    'withIptc',
                    true
                ],
            ];
        }

        /**
         * @covers ::__construct
         * @dataProvider overrideDefaultPropertyValues
         * @group reader
         *
         * @return void
         */
        public function testConstructorCanOverrideDefaultConfiguration($propertyName, $defaultValue, $key, $newValue)
        {
            $mapper = m::mock(MapperInterface::class);
            $reader = new Reader($mapper);

            $reflProp = new ReflectionProperty(Reader::class, $propertyName);
            $reflProp->setAccessible(true);

            $this->assertEquals(
                $defaultValue,
                $reflProp->getValue($reader)
            );

            $reader = new Reader($mapper, [$key => $newValue]);
        }

        /**
         * @return array
         */
        public function overrideDefaultPropertyValues()
        {
            return [
                [
                    'sections',
                    null,
                    Reader::SECTIONS,
                    'IPTC',
                ],
                [
                    'asArrays',
                    false,
                    Reader::ARRAYS,
                    true,
                ],
                [
                    'thumbnailInfo',
                    false,
                    Reader::THUMBNAILINFO,
                    true,
                ],
                [
                    'withIptc',
                    true,
                    Reader::WITHIPTC,
                    false,
                ],
            ];
        }

        /**
         * @covers ::getMapper
         * @group reader
         *
         * @return void
         */
        public function testGetMapperReturnsMapper()
        {
            $mapper = m::mock(MapperInterface::class);
            $reader = new Reader($mapper);

            $this->assertSame(
                $mapper,
                $reader->getMapper()
            );
        }

        /**
         * @covers ::getMetadataFromFile
         * @group reader
         *
         * @return void
         */
        public function testGetMetadataFromFileThrowsExceptionWhenNoData()
        {
            global $mockExifReadData;
            $mockExifReadData = false;

            $this->setExpectedException(NoExifDataException::class);
            $mapper = m::mock(MapperInterface::class);
            $reader = new Reader($mapper);
            $reader = m::mock($reader);

            $reader->getMetadataFromFile('/dev/null');
        }

        /**
         * @covers ::getMetadataFromFile
         * @group reader
         *
         * @return void
         */
        public function testGetMetadataFromFileReturnsMetadataObject()
        {
            global $mockExifReadData;
            $mockExifReadData = [];

            $mapper = m::mock(MapperInterface::class);
            $mapper->shouldReceive('map')
                ->andReturnNull();
            $reader = new Reader($mapper, [Reader::WITHIPTC => false]);
            $result = $reader->getMetadataFromFile('/dev/null');

            $this->assertInstanceOf(
                Metadata::class,
                $result
            );
        }
    }
}
