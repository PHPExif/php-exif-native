<?php

namespace Tests\PHPExif\Adapter\Native\Reader\Mapper\Iptc;

use Mockery as m;
use PHPExif\Common\Data\Iptc;
use PHPExif\Common\Exception\Mapper\UnsupportedFieldException;
use PHPExif\Common\Exception\Mapper\UnsupportedOutputException;

/**
 * Class: BaseFieldMapperTest
 *
 * @see \PHPUnit_Framework_TestCase
 */
abstract class BaseFieldMapperTest extends \PHPUnit_Framework_TestCase
{
    /**
     * FQCN of the fieldmapper being tested
     *
     * @var mixed
     */
    protected $fieldMapperClass;

    /**
     * List of supported fields
     *
     * @var array
     */
    protected $supportedFields = [];

    /**
     * Valid input data
     *
     * @var array
     */
    protected $validInput = [];

    /**
     * @covers ::getSupportedFields
     * @group mapper
     *
     * @return void
     */
    public function testGetSupportedFieldsReturnsExpectedArray()
    {
        $mapper = new $this->fieldMapperClass();
        $actual = $mapper->getSupportedFields();

        $this->assertInternalType('array', $actual);

        $this->assertEquals(array_keys($this->supportedFields), $actual);
    }

    /**
     * @covers ::mapField
     * @group mapper
     *
     * @return void
     */
    public function testMapFieldThrowsExceptionForUnsupportedField()
    {
        $this->setExpectedException(UnsupportedFieldException::class);

        $field = 'foo';
        $input = [];
        $output = new Iptc;
        $mapper = new $this->fieldMapperClass();

        $mapper->mapField($field, $input, $output);
    }

    /**
     * @covers ::mapField
     * @group mapper
     *
     * @return void
     */
    public function testMapFieldThrowsExceptionForUnsupportedOutput()
    {
        $this->setExpectedException(UnsupportedOutputException::class);

        $field = array_keys($this->supportedFields);
        $field = reset($field);
        $input = [];
        $output = new \stdClass;
        $mapper = new $this->fieldMapperClass();

        $mapper->mapField($field, $input, $output);
    }

    /**
     * @covers ::mapField
     * @group mapper
     *
     * @return void
     */
    public function testMapFieldYieldsNewOutputForValidInput()
    {
        $field = array_keys($this->supportedFields);
        $field = reset($field);
        $output = new Iptc;
        $mapper = new $this->fieldMapperClass();

        $originalHash = spl_object_hash($output);

        $mapper->mapField($field, $this->validInput, $output);

        $newHash = spl_object_hash($output);

        $this->assertNotEquals(
            $originalHash,
            $newHash
        );
    }

    /**
     * @covers ::mapField
     * @group mapper
     *
     * @return void
     */
    public function testMapFieldYieldsSameOutputForInvalidInput()
    {
        $field = array_keys($this->supportedFields);
        $field = reset($field);
        $output = new Iptc;
        $mapper = new $this->fieldMapperClass();

        $originalHash = spl_object_hash($output);

        $mapper->mapField($field, [], $output);

        $newHash = spl_object_hash($output);

        $this->assertEquals(
            $originalHash,
            $newHash
        );
    }
}
