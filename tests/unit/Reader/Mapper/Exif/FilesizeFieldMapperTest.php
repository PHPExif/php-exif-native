<?php

namespace Tests\PHPExif\Adapter\Native\Reader\Mapper\Exif;

use Mockery as m;
use PHPExif\Adapter\Native\Reader\Mapper\Exif\FilesizeFieldMapper;
use PHPExif\Common\Data\Exif;
use PHPExif\Common\Data\ValueObject\Filesize;

/**
 * Class: FilesizeFieldMapperTest
 *
 * @see \PHPUnit_Framework_TestCase
 * @coversDefaultClass \PHPExif\Adapter\Native\Reader\Mapper\Exif\FilesizeFieldMapper
 * @covers ::<!public>
 */
class FilesizeFieldMapperTest extends BaseFieldMapperTest
{
    /**
     * FQCN of the fieldmapper being tested
     *
     * @var mixed
     */
    protected $fieldMapperClass = FilesizeFieldMapper::class;

    /**
     * List of supported fields
     *
     * @var array
     */
    protected $supportedFields = [
        Filesize::class,
    ];

    /**
     * Valid input data
     *
     * @var array
     */
    protected $validInput = [
        'filesize' => 5345678,
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

        $originalData = $output->getFilesize();
        $mapper->mapField($field, $this->validInput, $output);
        $newData = $output->getFilesize();

        $this->assertNotSame($originalData, $newData);

        $this->assertInstanceOf(
            Filesize::class,
            $newData
        );

        $this->assertEquals(
            $this->validInput['filesize'],
            (string) $newData
        );
    }
}
