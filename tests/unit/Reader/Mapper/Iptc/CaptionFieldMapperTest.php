<?php

namespace Tests\PHPExif\Adapter\Native\Reader\Mapper\Iptc;

use Mockery as m;
use PHPExif\Adapter\Native\Reader\Mapper\Iptc\CaptionFieldMapper;
use PHPExif\Common\Data\Iptc;
use PHPExif\Common\Data\ValueObject\Caption;

/**
 * Class: CaptionFieldMapperTest
 *
 * @see \PHPUnit_Framework_TestCase
 * @coversDefaultClass \PHPExif\Adapter\Native\Reader\Mapper\Iptc\CaptionFieldMapper
 * @covers ::<!public>
 */
class CaptionFieldMapperTest extends BaseFieldMapperTest
{
    /**
     * FQCN of the fieldmapper being tested
     *
     * @var mixed
     */
    protected $fieldMapperClass = CaptionFieldMapper::class;

    /**
     * List of supported fields
     *
     * @var array
     */
    protected $supportedFields = [
        Caption::class,
    ];

    /**
     * Valid input data
     *
     * @var array
     */
    protected $validInput = [
        '2#120' => 'Just a caption',
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
        $output = new Iptc;
        $mapper = new $this->fieldMapperClass();

        $originalData = $output->getCaption();
        $mapper->mapField($field, $this->validInput, $output);
        $newData = $output->getCaption();

        $this->assertNotSame($originalData, $newData);

        $this->assertInstanceOf(
            Caption::class,
            $newData
        );

        $this->assertEquals(
            $this->validInput['2#120'],
            (string) $newData
        );
    }
}
