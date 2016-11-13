<?php

namespace Tests\PHPExif\Adapter\Native\Reader\Mapper\Exif;

use Mockery as m;
use PHPExif\Adapter\Native\Reader\Mapper\Exif\FilenameFieldMapper;
use PHPExif\Common\Data\Exif;
use PHPExif\Common\Data\ValueObject\Filename;

/**
 * Class: FilenameFieldMapperTest
 *
 * @see \PHPUnit_Framework_TestCase
 * @coversDefaultClass \PHPExif\Adapter\Native\Reader\Mapper\Exif\FilenameFieldMapper
 * @covers ::<!public>
 */
class FilenameFieldMapperTest extends BaseFieldMapperTest
{
    /**
     * FQCN of the fieldmapper being tested
     *
     * @var mixed
     */
    protected $fieldMapperClass = FilenameFieldMapper::class;

    /**
     * List of supported fields
     *
     * @var array
     */
    protected $supportedFields = [
        Filename::class,
    ];

    /**
     * Valid input data
     *
     * @var array
     */
    protected $validInput = [
        'FileName' => 'IMG_01234.JPG',
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

        $originalData = $output->getFilename();
        $mapper->mapField($field, $this->validInput, $output);
        $newData = $output->getFilename();

        $this->assertNotSame($originalData, $newData);

        $this->assertInstanceOf(
            Filename::class,
            $newData
        );

        $this->assertEquals(
            $this->validInput['FileName'],
            (string) $newData
        );
    }
}
