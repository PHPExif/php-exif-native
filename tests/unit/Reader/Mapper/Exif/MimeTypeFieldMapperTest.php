<?php

namespace Tests\PHPExif\Adapter\Native\Reader\Mapper\Exif;

use Mockery as m;
use PHPExif\Adapter\Native\Reader\Mapper\Exif\MimeTypeFieldMapper;
use PHPExif\Common\Data\Exif;
use PHPExif\Common\Data\ValueObject\MimeType;

/**
 * Class: MimeTypeFieldMapperTest
 *
 * @see \PHPUnit_Framework_TestCase
 * @coversDefaultClass \PHPExif\Adapter\Native\Reader\Mapper\Exif\MimeTypeFieldMapper
 * @covers ::<!public>
 */
class MimeTypeFieldMapperTest extends BaseFieldMapperTest
{
    /**
     * FQCN of the fieldmapper being tested
     *
     * @var mixed
     */
    protected $fieldMapperClass = MimeTypeFieldMapper::class;

    /**
     * List of supported fields
     *
     * @var array
     */
    protected $supportedFields = [
        MimeType::class,
    ];

    /**
     * Valid input data
     *
     * @var array
     */
    protected $validInput = [
        'mimetype' => 'image/jpeg',
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

        $originalData = $output->getMimeType();
        $mapper->mapField($field, $this->validInput, $output);
        $newData = $output->getMimeType();

        $this->assertNotSame($originalData, $newData);

        $this->assertInstanceOf(
            MimeType::class,
            $newData
        );

        $this->assertEquals(
            $this->validInput['mimetype'],
            (string) $newData
        );
    }
}
