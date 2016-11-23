<?php
/**
 * Mapper for mapping data between raw input and a Height VO
 *
 * @link        http://github.com/PHPExif/php-exif-native for the canonical source repository
 * @copyright   Copyright (c) 2016 Tom Van Herreweghe <tom@theanalogguy.be>
 * @license     http://github.com/PHPExif/php-exif-native/blob/master/LICENSE MIT License
 * @category    PHPExif
 * @package     Native
 */

namespace PHPExif\Adapter\Native\Reader\Mapper\Exif;

use PHPExif\Common\Data\ExifInterface;
use PHPExif\Common\Data\ValueObject\Dimensions;
use PHPExif\Common\Data\ValueObject\Height;
use PHPExif\Common\Data\ValueObject\Width;
use PHPExif\Common\Mapper\FieldMapper;

/**
 * Mapper
 *
 * @category    PHPExif
 * @package     Native
 */
class DimensionsFieldMapper implements FieldMapper
{
    use GuardInvalidArgumentsTrait;

    /**
     * {@inheritDoc}
     */
    public function getSupportedFields()
    {
        return array(
            Dimensions::class,
        );
    }

    /**
     * {@inheritDoc}
     */
    public function mapField($field, array $input, &$output)
    {
        $this->guardInvalidArguments($field, $input, $output);

        if (!array_key_exists('COMPUTED', $input)) {
            return;
        }
        $input = $input['COMPUTED'];

        if (!(array_key_exists('Width', $input) && array_key_exists('Height', $input))) {
            return;
        }

        $dimensions = new Dimensions(
            Width::pixels((int) $input['Width']),
            Height::pixels((int) $input['Height'])
        );

        $output = $output->withDimensions($dimensions);
    }
}
