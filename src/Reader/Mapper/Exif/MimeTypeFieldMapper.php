<?php
/**
 * Mapper for mapping data between raw input and a MimeType VO
 *
 * @link        http://github.com/PHPExif/php-exif-native for the canonical source repository
 * @copyright   Copyright (c) 2016 Tom Van Herreweghe <tom@theanalogguy.be>
 * @license     http://github.com/PHPExif/php-exif-native/blob/master/LICENSE MIT License
 * @category    PHPExif
 * @package     Native
 */

namespace PHPExif\Adapter\Native\Reader\Mapper\Exif;

use PHPExif\Common\Data\ExifInterface;
use PHPExif\Common\Data\ValueObject\Exif\MimeType;
use PHPExif\Common\Mapper\FieldMapper;

/**
 * Mapper
 *
 * @category    PHPExif
 * @package     Native
 */
class MimeTypeFieldMapper implements FieldMapper
{
    use GuardInvalidArgumentsTrait;

    /**
     * {@inheritDoc}
     */
    public function getSupportedFields()
    {
        return array(
            MimeType::class,
        );
    }

    /**
     * {@inheritDoc}
     */
    public function mapField($field, array $input, &$output)
    {
        $this->guardInvalidArguments($field, $input, $output);

        if (!array_key_exists('MimeType', $input)) {
            return;
        }

        $mimeType = new MimeType($input['MimeType']);

        $output = $output->withMimeType($mimeType);
    }
}
