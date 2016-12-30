<?php

namespace Tests\PHPExif\Adapter\Native\Reader\Mapper\Exif;

use Mockery as m;
use PHPExif\Adapter\Native\Reader\Mapper\Exif\IsoFieldMapper;
use PHPExif\Common\Data\Exif;
use PHPExif\Common\Data\ValueObject\IsoSpeed;

/**
 * Class: IsoFieldMapperTest
 *
 * @see \PHPUnit_Framework_TestCase
 * @coversDefaultClass \PHPExif\Adapter\Native\Reader\Mapper\Exif\IsoFieldMapper
 * @covers ::<!public>
 */
class IsoFieldMapperTest extends BaseFieldMapperTest
{
    /**
     * FQCN of the fieldmapper being tested
     *
     * @var mixed
     */
    protected $fieldMapperClass = IsoFieldMapper::class;

    /**
     * List of supported fields
     *
     * @var array
     */
    protected $supportedFields = [
        IsoSpeed::class,
    ];

    /**
     * Valid input data
     *
     * @var array
     */
    protected $validInput = [
        'isospeedratings' => 200,
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

        $originalData = $output->getIsoSpeed();
        $mapper->mapField($field, $this->validInput, $output);
        $newData = $output->getIsoSpeed();

        $this->assertNotSame($originalData, $newData);

        $this->assertInstanceOf(
            IsoSpeed::class,
            $newData
        );

        $this->assertEquals(
            $this->validInput['isospeedratings'],
            $newData->getValue()
        );
    }
}
