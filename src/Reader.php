<?php
/**
 * Reader which uses native PHP functionality to read EXIF data
 *
 * @category    PHPExif
 * @copyright   Copyright (c) 2016 Tom Van Herreweghe <tom@theanalogguy.be>
 * @license     http://github.com/PHPExif/php-exif-native/blob/master/LICENSE MIT License
 * @link        http://github.com/PHPExif/php-exif-native for the canonical source repository
 * @package     Native
 */

namespace PHPExif\Adapter\Native;

use PHPExif\Common\Adapter\MapperInterface;
use PHPExif\Common\Adapter\ReaderInterface;
use PHPExif\Common\Data\Exif;
use PHPExif\Common\Data\Iptc;
use PHPExif\Common\Data\Metadata;
use PHPExif\Common\Exception\Reader\NoExifDataException;

/**
 * Reader
 *
 * Reads EXIF data
 *
 * @category    PHPExif
 * @package     Native
 */
final class Reader implements ReaderInterface
{
    const SECTIONS = 'sections';
    const ARRAYS = 'asArrays';
    const THUMBNAILINFO = 'thumbnailInfo';
    const WITHIPTC = 'withIptc';

    /**
     * @var MapperInterface
     */
    private $mapper;

    /**
     * @var string
     */
    private $sections = null;

    /**
     * @var boolean
     */
    private $asArrays = false;

    /**
     * @var boolean
     */
    private $thumbnailInfo = false;

    /**
     * @var boolean
     */
    private $withIptc = true;

    /**
     * @param MapperInterface $mapper
     * @param array $config
     */
    public function __construct(
        MapperInterface $mapper,
        array $config = []
    ) {
        $defaults = [
            self::SECTIONS => null,
            self::ARRAYS => false,
            self::THUMBNAILINFO => false,
            self::WITHIPTC => true,
        ];

        $config = array_replace($defaults, $config);

        $this->sections = $config[self::SECTIONS];
        $this->asArrays = $config[self::ARRAYS];
        $this->thumbnailInfo = $config[self::THUMBNAILINFO];
        $this->withIptc = $config[self::WITHIPTC];

        $this->mapper = $mapper;
    }

    /**
     * {@inheritDoc}
     */
    public function getMapper()
    {
        return $this->mapper;
    }

    /**
     * {@inheritDoc}
     */
    public function getMetadataFromFile($filePath)
    {
        $data = @exif_read_data(
            $filePath,
            $this->sections,
            $this->asArrays, // flat array
            $this->thumbnailInfo // no thumbnail
        );

        if (false === $data) {
            throw NoExifDataException::fromFile($filePath);
        }

        $this->augmentDataWithIptcRawData($filePath, $data);

        // map the data:
        $mapper = $this->getMapper();
        $metadata = new Metadata(
            new Exif,
            new Iptc
        );
        $mapper->map($data, $metadata);

        return $metadata;
    }

    /**
     * Adds data from iptcparse to the original raw EXIF data
     *
     * @param string $filePath
     * @param array $data
     *
     * @return void
     */
    private function augmentDataWithIptcRawData($filePath, array &$data)
    {
        if (!$this->withIptc) {
            return;
        }

        getimagesize($filePath, $info);

        if (!array_key_exists('APP13', $info)) {
            return;
        }

        $iptcRawData = iptcparse($info['APP13']);

        // UTF8
        if (isset($iptcRawData["1#090"]) && $iptcRawData["1#090"][0] == "\x1B%G") {
            $iptcRawData = array_map('utf8_encode', $iptcRawData);
        }

        // Merge with original raw Exif data
        $data = array_merge(
            $data,
            $iptcRawData
        );
    }
}
