<?php

namespace Tests\PHPExif\Adapter\Native\Reader\Mapper\Iptc;

use Mockery as m;
use PHPExif\Adapter\Native\Reader\Mapper\Iptc\CreditFieldMapper;
use PHPExif\Common\Data\Iptc;
use PHPExif\Common\Data\ValueObject\Credit;

/**
 * Class: CreditFieldMapperTest
 *
 * @see \PHPUnit_Framework_TestCase
 * @coversDefaultClass \PHPExif\Adapter\Native\Reader\Mapper\Iptc\CreditFieldMapper
 * @covers ::<!public>
 */
class CreditFieldMapperTest extends BaseFieldMapperTest
{
    /**
     * FQCN of the fieldmapper being tested
     *
     * @var mixed
     */
    protected $fieldMapperClass = CreditFieldMapper::class;

    /**
     * List of supported fields
     *
     * @var array
     */
    protected $supportedFields = [
        Credit::class,
    ];

    /**
     * Valid input data
     *
     * @var array
     */
    protected $validInput = [
        '2#110' => 'Just a credit',
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

        $originalData = $output->getCredit();
        $mapper->mapField($field, $this->validInput, $output);
        $newData = $output->getCredit();

        $this->assertNotSame($originalData, $newData);

        $this->assertInstanceOf(
            Credit::class,
            $newData
        );

        $this->assertEquals(
            $this->validInput['2#110'],
            (string) $newData
        );
    }
}
