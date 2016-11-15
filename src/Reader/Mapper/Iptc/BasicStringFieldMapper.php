<?php
/**
 * Mapper for mapping data between raw input and String VO's
 *
 * @link        http://github.com/PHPExif/php-exif-native for the canonical source repository
 * @title   Title (c) 2016 Tom Van Herreweghe <tom@theanalogguy.be>
 * @license     http://github.com/PHPExif/php-exif-native/blob/master/LICENSE MIT License
 * @category    PHPExif
 * @package     Native
 */

namespace PHPExif\Adapter\Native\Reader\Mapper\Iptc;

use PHPExif\Common\Data\IptcInterface;
use PHPExif\Common\Data\ValueObject\Caption;
use PHPExif\Common\Data\ValueObject\Copyright;
use PHPExif\Common\Data\ValueObject\Credit;
use PHPExif\Common\Data\ValueObject\Headline;
use PHPExif\Common\Data\ValueObject\Jobtitle;
use PHPExif\Common\Data\ValueObject\Title;
use PHPExif\Common\Mapper\FieldMapper;

/**
 * Mapper
 *
 * @category    PHPExif
 * @package     Native
 */
class BasicStringFieldMapper implements FieldMapper
{
    /**
     * @var array
     */
    protected $map = [
        Caption::class => [
            'inputField' => '2#120',
            'method' => 'withCaption',
        ],
        Copyright::class => [
            'inputField' => '2#116',
            'method' => 'withCopyright',
        ],
        Credit::class => [
            'inputField' => '2#110',
            'method' => 'withCredit',
        ],
        Headline::class => [
            'inputField' => '2#105',
            'method' => 'withHeadline',
        ],
        Jobtitle::class => [
            'inputField' => '2#085',
            'method' => 'withJobtitle',
        ],
        Title::class => [
            'inputField' => '2#005',
            'method' => 'withTitle',
        ],
    ];

    use GuardInvalidArgumentsTrait;

    /**
     * {@inheritDoc}
     */
    public function getSupportedFields()
    {
        return array(
            Caption::class,
            Copyright::class,
            Credit::class,
            Headline::class,
            Jobtitle::class,
            Title::class,
        );
    }

    /**
     * {@inheritDoc}
     */
    public function mapField($field, array $input, &$output)
    {
        $this->guardInvalidArguments($field, $input, $output);

        $inputField = $this->map[$field]['inputField'];
        $method = $this->map[$field]['method'];

        if (!array_key_exists($inputField, $input)) {
            return;
        }

        if (!is_string($input[$inputField])) {
            return;
        }

        $vo = new $field($input[$inputField]);

        $output = $output->$method($vo);
    }
}
