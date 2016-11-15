<?php

namespace Tests\PHPExif\Adapter\Native\Reader\Mapper\Iptc;

use Mockery as m;
use PHPExif\Adapter\Native\Reader\Mapper\Iptc\KeywordsFieldMapper;
use PHPExif\Common\Collection\ArrayCollection;
use PHPExif\Common\Collection\Collection;
use PHPExif\Common\Data\Iptc;
use PHPExif\Common\Data\ValueObject\Keyword;

/**
 * Class: KeywordsFieldMapperTest
 *
 * @see \PHPUnit_Framework_TestCase
 * @coversDefaultClass \PHPExif\Adapter\Native\Reader\Mapper\Iptc\KeywordsFieldMapper
 * @covers ::<!public>
 */
class KeywordsFieldMapperTest extends BaseFieldMapperTest
{
    /**
     * FQCN of the fieldmapper being tested
     *
     * @var mixed
     */
    protected $fieldMapperClass = KeywordsFieldMapper::class;

    /**
     * List of supported fields
     *
     * @var array
     */
    protected $supportedFields = [
        Keyword::class => [

        ],
    ];

    /**
     * Valid input data
     *
     * @var array
     */
    protected $validInput = [
        '2#025' => [
            'foo',
            'bar baz',
            'QuuX',
        ],
    ];

    /**
     * @covers ::mapField
     * @group mapper
     *
     * @return void
     */
    public function testMapFieldHasDataInOutput()
    {
        $field = array_keys($this->supportedFields);
        $field = reset($field);
        $output = new Iptc;
        $mapper = new $this->fieldMapperClass();

        $originalData = $output->getKeywords();
        $mapper->mapField($field, $this->validInput, $output);
        $newData = $output->getKeywords();

        $this->assertNotSame($originalData, $newData);

        $this->assertInstanceOf(
            Collection::class,
            $newData
        );

        foreach ($this->validInput['2#025'] as $key => $kw) {
            $keyword = $newData->get($key);
            $this->assertInstanceOf(
                Keyword::class,
                $keyword
            );

            $this->assertEquals(
                $kw,
                (string) $keyword
            );
        }
    }
}
