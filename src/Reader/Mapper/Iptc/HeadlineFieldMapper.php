<?php
/**
 * Mapper for mapping data between raw input and a Headline VO
 *
 * @link        http://github.com/PHPExif/php-exif-native for the canonical source repository
 * @headline   Headline (c) 2016 Tom Van Herreweghe <tom@theanalogguy.be>
 * @license     http://github.com/PHPExif/php-exif-native/blob/master/LICENSE MIT License
 * @category    PHPExif
 * @package     Native
 */

namespace PHPExif\Adapter\Native\Reader\Mapper\Iptc;

use PHPExif\Common\Data\IptcInterface;
use PHPExif\Common\Data\ValueObject\Headline;
use PHPExif\Common\Mapper\FieldMapper;

/**
 * Mapper
 *
 * @category    PHPExif
 * @package     Native
 */
class HeadlineFieldMapper implements FieldMapper
{
    use GuardInvalidArgumentsTrait;

    /**
     * {@inheritDoc}
     */
    public function getSupportedFields()
    {
        return array(
            Headline::class,
        );
    }

    /**
     * {@inheritDoc}
     */
    public function mapField($field, array $input, &$output)
    {
        $this->guardInvalidArguments($field, $input, $output);

        if (!array_key_exists('2#105', $input)) {
            return;
        }

        $headline = new Headline($input['2#105']);

        $output = $output->withHeadline($headline);
    }
}
