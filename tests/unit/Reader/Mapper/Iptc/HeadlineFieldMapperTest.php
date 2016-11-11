<?php

namespace Tests\PHPExif\Adapter\Native\Reader\Mapper\Iptc;

use Mockery as m;
use PHPExif\Adapter\Native\Reader\Mapper\Iptc\HeadlineFieldMapper;
use PHPExif\Common\Data\Iptc;
use PHPExif\Common\Data\ValueObject\Headline;

/**
 * Class: HeadlineFieldMapperTest
 *
 * @see \PHPUnit_Framework_TestCase
 * @coversDefaultClass \PHPExif\Adapter\Native\Reader\Mapper\Iptc\HeadlineFieldMapper
 * @covers ::<!public>
 */
class HeadlineFieldMapperTest extends BaseFieldMapperTest
{
    /**
     * FQCN of the fieldmapper being tested
     *
     * @var mixed
     */
    protected $fieldMapperClass = HeadlineFieldMapper::class;

    /**
     * List of supported fields
     *
     * @var array
     */
    protected $supportedFields = [
        Headline::class,
    ];

    /**
     * Valid input data
     *
     * @var array
     */
    protected $validInput = [
        '2#105' => 'Just a headline',
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

        $originalData = $output->getHeadline();
        $mapper->mapField($field, $this->validInput, $output);
        $newData = $output->getHeadline();

        $this->assertNotSame($originalData, $newData);

        $this->assertInstanceOf(
            Headline::class,
            $newData
        );

        $this->assertEquals(
            $this->validInput['2#105'],
            (string) $newData
        );
    }
}
