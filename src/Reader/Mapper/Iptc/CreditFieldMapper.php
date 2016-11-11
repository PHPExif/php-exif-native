<?php
/**
 * Mapper for mapping data between raw input and a Credit VO
 *
 * @link        http://github.com/PHPExif/php-exif-native for the canonical source repository
 * @credit   Credit (c) 2016 Tom Van Herreweghe <tom@theanalogguy.be>
 * @license     http://github.com/PHPExif/php-exif-native/blob/master/LICENSE MIT License
 * @category    PHPExif
 * @package     Native
 */

namespace PHPExif\Adapter\Native\Reader\Mapper\Iptc;

use PHPExif\Common\Data\IptcInterface;
use PHPExif\Common\Data\ValueObject\Credit;
use PHPExif\Common\Mapper\FieldMapper;

/**
 * Mapper
 *
 * @category    PHPExif
 * @package     Native
 */
class CreditFieldMapper implements FieldMapper
{
    use GuardInvalidArgumentsTrait;

    /**
     * {@inheritDoc}
     */
    public function getSupportedFields()
    {
        return array(
            Credit::class,
        );
    }

    /**
     * {@inheritDoc}
     */
    public function mapField($field, array $input, &$output)
    {
        $this->guardInvalidArguments($field, $input, $output);

        if (!array_key_exists('2#110', $input)) {
            return;
        }

        $credit = new Credit($input['2#110']);

        $output = $output->withCredit($credit);
    }
}
