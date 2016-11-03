<?php

namespace Tests\PHPExif\Adapter\Native\Reader\Mapper\Exif;

use Mockery as m;
use PHPExif\Adapter\Native\Reader\Mapper\Exif\ApertureFieldMapper;
use PHPExif\Common\Data\ValueObject\Exif\Aperture;

/**
 * Class: ApertureFieldMapperTest
 *
 * @see \PHPUnit_Framework_TestCase
 * @coversDefaultClass \PHPExif\Adapter\Native\Reader\Mapper\Exif\ApertureFieldMapper
 * @covers ::<!public>
 */
class ApertureFieldMapperTest extends BaseFieldMapperTest
{
    /**
     * FQCN of the fieldmapper being tested
     *
     * @var mixed
     */
    protected $fieldMapperClass = ApertureFieldMapper::class;

    /**
     * List of supported fields
     *
     * @var array
     */
    protected $supportedFields = [
        Aperture::class,
    ];

    /**
     * Valid input data
     *
     * @var array
     */
    protected $validInput = [
        'COMPUTED' => [
            'ApertureFNumber' => 'f/5.6',
        ],
    ];
}
