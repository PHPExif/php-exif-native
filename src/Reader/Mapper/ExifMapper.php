<?php
/**
 * Mapper for mapping data between raw input and Data classes
 *
 * @link        http://github.com/PHPExif/php-exif-native for the canonical source repository
 * @copyright   Copyright (c) 2016 Tom Van Herreweghe <tom@theanalogguy.be>
 * @license     http://github.com/PHPExif/php-exif-native/blob/master/LICENSE MIT License
 * @category    PHPExif
 * @package     Native
 */

namespace PHPExif\Adapter\Native\Reader\Mapper;

use PHPExif\Common\Data\Exif;
use PHPExif\Common\Data\ExifInterface;
use PHPExif\Common\Data\MetadataInterface;
use PHPExif\Common\Exception\Mapper\UnsupportedFieldException;
use PHPExif\Common\Exception\Mapper\UnsupportedOutputException;
use PHPExif\Common\Mapper\ArrayMapper;
use PHPExif\Common\Mapper\FieldMapper;
use PHPExif\Common\Mapper\FieldMapperTrait;

/**
 * ExifMapper
 *
 * Maps the array of exif data onto the correct
 * fields of given Exif object
 *
 * @category    PHPExif
 * @package     Native
 */
class ExifMapper implements ArrayMapper, FieldMapper
{
    use FieldMapperTrait;

    /**
     * {@inheritDoc}
     */
    public function getSupportedFields()
    {
        return array(
            Exif::class,
        );
    }

    /**
     * {@inheritDoc}
     */
    public function mapArray(array $input, &$output)
    {
        if (!($output instanceof ExifInterface)) {
            throw UnsupportedOutputException::forOutput($output);
        }

        $fieldMappers = $this->getFieldMappers();

        foreach ($fieldMappers as $field => $fieldMapper) {
            $fieldMapper->mapField(
                $field,
                $input,
                $output
            );
        }
    }

    /**
     * {@inheritDoc}
     */
    public function mapField($field, array $input, &$output)
    {
        if (!in_array($field, $this->getSupportedFields())) {
            throw UnsupportedFieldException::forField($field);
        }

        if (!($output instanceof MetadataInterface)) {
            throw UnsupportedOutputException::forOutput($output);
        }

        $exif = $output->getExif();
        $this->mapArray($input, $exif);
        $output = $output->withExif($exif);
    }
}
