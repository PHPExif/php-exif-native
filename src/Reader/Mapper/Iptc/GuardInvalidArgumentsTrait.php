<?php
/**
 * Trait with method to validate arguments of ::mapField
 * from Iptc\*Mapper classes
 *
 * @link        http://github.com/PHPExif/php-exif-native for the canonical source repository
 * @copyright   Copyright (c) 2016 Tom Van Herreweghe <tom@theanalogguy.be>
 * @license     http://github.com/PHPExif/php-exif-native/blob/master/LICENSE MIT License
 * @category    PHPExif
 * @package     Native
 */

namespace PHPExif\Adapter\Native\Reader\Mapper\Iptc;

use PHPExif\Common\Data\IptcInterface;
use PHPExif\Common\Exception\Mapper\UnsupportedFieldException;
use PHPExif\Common\Exception\Mapper\UnsupportedOutputException;

/**
 * Common method to check the arguments of an Iptc\* mapper
 *
 * @category    PHPExif
 * @package     Native
 */
trait GuardInvalidArgumentsTrait
{
    /**
     * Guard function for invalid arguments
     *
     * @param string $field
     * @param array $input
     * @param object $output
     *
     * @throws UnsupportedFieldException when asked to map an unsupported field
     * @throws UnsupportedOutputException when asked to map data on an unsupported output object
     *
     * @return void
     */
    private function guardInvalidArguments($field, array $input, $output)
    {
        if (!in_array($field, $this->getSupportedFields())) {
            throw UnsupportedFieldException::forField($field);
        }

        if (!($output instanceof IptcInterface)) {
            throw UnsupportedOutputException::forOutput($output);
        }
    }

    /**
     * {@inheritDoc}
     */
    abstract public function getSupportedFields();
}
