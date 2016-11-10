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

namespace PHPExif\Adapter\Native\Reader;

use PHPExif\Common\Adapter\MapperInterface;
use PHPExif\Common\Data\MetadataInterface;
use PHPExif\Common\Mapper\ArrayMapper;
use PHPExif\Common\Mapper\FieldMapperTrait;

/**
 * Mapper
 *
 * Maps the array of exif & iptc data onto the
 * correct fields of given MetadataInterface object
 *
 * @category    PHPExif
 * @package     Native
 */
class Mapper implements MapperInterface, ArrayMapper
{
    use FieldMapperTrait;

    /**
     * {@inheritDoc}
     */
    public function map(array $input, MetadataInterface &$output)
    {
        $this->mapArray($input, $output);

        $output->setRawData($input);
    }

    /**
     * {@inheritDoc}
     */
    public function mapArray(array $input, &$output)
    {
        $mappers = $this->getFieldMappers();

        foreach ($mappers as $field => $mapper) {
            $mapper->mapField($field, $input, $output);
        }
    }
}
