<?php
/**
 * Mapper for mapping data between raw input and Keyword VO's
 *
 * @link        http://github.com/PHPExif/php-exif-native for the canonical source repository
 * @title   Title (c) 2016 Tom Van Herreweghe <tom@theanalogguy.be>
 * @license     http://github.com/PHPExif/php-exif-native/blob/master/LICENSE MIT License
 * @category    PHPExif
 * @package     Native
 */

namespace PHPExif\Adapter\Native\Reader\Mapper\Iptc;

use PHPExif\Common\Collection\ArrayCollection;
use PHPExif\Common\Data\IptcInterface;
use PHPExif\Common\Data\ValueObject\Keyword;
use PHPExif\Common\Mapper\FieldMapper;

/**
 * Mapper
 *
 * @category    PHPExif
 * @package     Native
 */
class KeywordsFieldMapper implements FieldMapper
{
    use GuardInvalidArgumentsTrait;

    /**
     * {@inheritDoc}
     */
    public function getSupportedFields()
    {
        return array(
            Keyword::class,
        );
    }

    /**
     * {@inheritDoc}
     */
    public function mapField($field, array $input, &$output)
    {
        $this->guardInvalidArguments($field, $input, $output);

        if (!array_key_exists('2#025', $input)) {
            return;
        }

        $collection = new ArrayCollection;

        foreach ($input['2#025'] as $keywordData) {
            $collection->add(
                new Keyword($keywordData)
            );
        }

        $output = $output->withKeywords($collection);
    }
}
