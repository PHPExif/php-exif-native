<?php
/**
 * Mapper for mapping data between raw input and an FocusDistance VO
 *
 * @link        http://github.com/PHPExif/php-exif-native for the canonical source repository
 * @copyright   Copyright (c) 2016 Tom Van Herreweghe <tom@theanalogguy.be>
 * @license     http://github.com/PHPExif/php-exif-native/blob/master/LICENSE MIT License
 * @category    PHPExif
 * @package     Native
 */

namespace PHPExif\Adapter\Native\Reader\Mapper\Exif;

use PHPExif\Common\Data\ExifInterface;
use PHPExif\Common\Data\ValueObject\FocusDistance;
use PHPExif\Common\Mapper\FieldMapper;
use PHPExif\Common\Mapper\GuardInvalidArgumentsForExifTrait;

/**
 * Mapper
 *
 * @category    PHPExif
 * @package     Native
 */
class FocusDistanceFieldMapper implements FieldMapper
{
    use GuardInvalidArgumentsForExifTrait;

    /**
     * {@inheritDoc}
     */
    public function getSupportedFields()
    {
        return array(
            FocusDistance::class,
        );
    }

    /**
     * {@inheritDoc}
     */
    public function mapField($field, array $input, &$output)
    {
        $this->guardInvalidArguments($field, $input, $output);

        if (!array_key_exists('computed', $input)
            || !array_key_exists('focusdistance', $input['computed'])) {
            return;
        }

        $focusDistance = new FocusDistance(
            $input['computed']['focusdistance']
        );

        $output = $output->withFocusDistance($focusDistance);
    }
}
