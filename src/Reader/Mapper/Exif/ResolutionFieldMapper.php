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
use PHPExif\Common\Data\ValueObject\LineResolution;
use PHPExif\Common\Data\ValueObject\Resolution;
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
            Resolution::class,
        );
    }

    /**
     * {@inheritDoc}
     */
    public function mapField($field, array $input, &$output)
    {
        $this->guardInvalidArguments($field, $input, $output);

        if (!(array_key_exists('XResolution', $input) && array_key_exists('YResolution', $input))) {
            return;
        }

        $resolution = new Resolution(
            LineResolution::dpi($input['XResolution']), // horizontal
            LineResolution::dpi($input['YResolution']) // vertical
        );

        $output = $output->withResolution($resolution);
    }
}
