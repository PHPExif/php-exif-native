<?php
/**
 * Mapper for mapping data between raw input and a HorizontalResolution VO
 *
 * @link        http://github.com/PHPExif/php-exif-native for the canonical source repository
 * @copyright   Copyright (c) 2016 Tom Van Herreweghe <tom@theanalogguy.be>
 * @license     http://github.com/PHPExif/php-exif-native/blob/master/LICENSE MIT License
 * @category    PHPExif
 * @package     Native
 */

namespace PHPExif\Adapter\Native\Reader\Mapper\Exif;

use PHPExif\Common\Data\ExifInterface;
use PHPExif\Common\Data\ValueObject\HorizontalResolution;
use PHPExif\Common\Data\ValueObject\VerticalResolution;
use PHPExif\Common\Mapper\FieldMapper;

/**
 * Mapper
 *
 * @category    PHPExif
 * @package     Native
 */
class ResolutionFieldMapper implements FieldMapper
{
    /**
     * @var array
     */
    protected $map = [
        HorizontalResolution::class => [
            'dataField' => 'XResolution',
            'method' => 'withHorizontalResolution',
        ],
        VerticalResolution::class => [
            'dataField' => 'YResolution',
            'method' => 'withVerticalResolution',
        ],
    ];

    use GuardInvalidArgumentsTrait;

    /**
     * {@inheritDoc}
     */
    public function getSupportedFields()
    {
        return array(
            HorizontalResolution::class,
            VerticalResolution::class,
        );
    }

    /**
     * {@inheritDoc}
     */
    public function mapField($field, array $input, &$output)
    {
        $this->guardInvalidArguments($field, $input, $output);

        $inputField = $this->map[$field]['dataField'];

        if (!array_key_exists($inputField, $input)) {
            return;
        }

        $valueObject = new $field(
            $input[$inputField]
        );

        $output = $output->{$this->map[$field]['method']}($valueObject);
    }
}
