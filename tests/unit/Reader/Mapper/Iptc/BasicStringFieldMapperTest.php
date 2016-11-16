<?php

namespace Tests\PHPExif\Adapter\Native\Reader\Mapper\Iptc;

use Mockery as m;
use PHPExif\Adapter\Native\Reader\Mapper\Iptc\BasicStringFieldMapper;
use PHPExif\Common\Data\Iptc;
use PHPExif\Common\Data\ValueObject\Caption;
use PHPExif\Common\Data\ValueObject\Copyright;
use PHPExif\Common\Data\ValueObject\Credit;
use PHPExif\Common\Data\ValueObject\Headline;
use PHPExif\Common\Data\ValueObject\Jobtitle;
use PHPExif\Common\Data\ValueObject\Source;
use PHPExif\Common\Data\ValueObject\Title;

/**
 * Class: BasicStringFieldMapperTest
 *
 * @see \PHPUnit_Framework_TestCase
 * @coversDefaultClass \PHPExif\Adapter\Native\Reader\Mapper\Iptc\BasicStringFieldMapper
 * @covers ::<!public>
 */
class BasicStringFieldMapperTest extends BaseFieldMapperTest
{
    /**
     * FQCN of the fieldmapper being tested
     *
     * @var mixed
     */
    protected $fieldMapperClass = BasicStringFieldMapper::class;

    /**
     * List of supported fields
     *
     * @var array
     */
    protected $supportedFields = [
        Caption::class => [
            'getter' => 'getCaption',
            'input' => '2#120',
        ],
        Copyright::class => [
            'getter' => 'getCopyright',
            'input' => '2#116',
        ],
        Credit::class => [
            'getter' => 'getCredit',
            'input' => '2#110',
        ],
        Headline::class => [
            'getter' => 'getHeadline',
            'input' => '2#105',
        ],
        Jobtitle::class => [
            'getter' => 'getJobtitle',
            'input' => '2#085',
        ],
        Source::class => [
            'getter' => 'getSource',
            'input' => '2#115',
        ],
        Title::class => [
            'getter' => 'getTitle',
            'input' => '2#005',
        ],
    ];

    /**
     * Valid input data
     *
     * @var array
     */
    protected $validInput = [
        '2#120' => 'Some Caption data',
        '2#116' => 'Some Copyright data',
        '2#110' => 'Some Credit data',
        '2#105' => 'Some Headline data',
        '2#005' => 'Some Title data',
        '2#085' => 'Some Jobtitle data',
        '2#115' => 'Some Source data',
    ];

    /**
     * @covers ::mapField
     * @group mapper
     *
     * @return void
     */
    public function testMapFieldHasCorrectDataInOutput()
    {
        foreach ($this->supportedFields as $field => $fieldData) {
            $output = new Iptc;
            $mapper = new $this->fieldMapperClass();

            $originalData = $output->{$fieldData['getter']}();
            $mapper->mapField($field, $this->validInput, $output);
            $newData = $output->{$fieldData['getter']}();

            $this->assertNotSame($originalData, $newData);

            $this->assertInstanceOf(
                $field,
                $newData
            );

            $this->assertEquals(
                $this->validInput[$fieldData['input']],
                (string) $newData
            );
        }
    }

    /**
     * @covers ::mapField
     * @group mapper
     *
     * @return void
     */
    public function testMapFieldDoesNotMapNullData()
    {
        foreach ($this->supportedFields as $field => $fieldData) {
            $output = new Iptc;
            $mapper = new $this->fieldMapperClass();

            $input = [
                $fieldData['input'] => null,
            ];
            $mapper->mapField($field, $input, $output);
            $newData = $output->{$fieldData['getter']}();

            $this->assertNull($newData);
        }
    }
}
