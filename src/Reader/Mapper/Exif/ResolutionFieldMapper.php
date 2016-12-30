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
use PHPExif\Common\Mapper\GuardInvalidArgumentsForExifTrait;

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
            'dataField' => 'xresolution',
            'method' => 'withHorizontalResolution',
        ],
        VerticalResolution::class => [
            'dataField' => 'yresolution',
            'method' => 'withVerticalResolution',
        ],
    ];

    use GuardInvalidArgumentsForExifTrait;

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

        if (!(array_key_exists('xresolution', $input) && array_key_exists('yresolution', $input))) {
            return;
        }

        $resolution = new Resolution(
            LineResolution::dpi($input['xresolution']), // horizontal
            LineResolution::dpi($input['yresolution']) // vertical
        );

        $output = $output->withResolution($resolution);
    }
}
