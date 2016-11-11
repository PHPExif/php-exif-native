<?php

namespace Tests\PHPExif\Adapter\Native\Reader\Mapper\Iptc;

use Mockery as m;
use PHPExif\Adapter\Native\Reader\Mapper\Iptc\CopyrightFieldMapper;
use PHPExif\Common\Data\Iptc;
use PHPExif\Common\Data\ValueObject\Copyright;

/**
 * Class: CopyrightFieldMapperTest
 *
 * @see \PHPUnit_Framework_TestCase
 * @coversDefaultClass \PHPExif\Adapter\Native\Reader\Mapper\Iptc\CopyrightFieldMapper
 * @covers ::<!public>
 */
class CopyrightFieldMapperTest extends BaseFieldMapperTest
{
    /**
     * FQCN of the fieldmapper being tested
     *
     * @var mixed
     */
    protected $fieldMapperClass = CopyrightFieldMapper::class;

    /**
     * List of supported fields
     *
     * @var array
     */
    protected $supportedFields = [
        Copyright::class,
    ];

    /**
     * Valid input data
     *
     * @var array
     */
    protected $validInput = [
        '2#116' => 'Just a copyright',
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

        $originalData = $output->getCopyright();
        $mapper->mapField($field, $this->validInput, $output);
        $newData = $output->getCopyright();

        $this->assertNotSame($originalData, $newData);

        $this->assertInstanceOf(
            Copyright::class,
            $newData
        );

        $this->assertEquals(
            $this->validInput['2#116'],
            (string) $newData
        );
    }
}
