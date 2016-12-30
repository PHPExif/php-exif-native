<?php
/**
 * Mapper for mapping data between raw input and a Height VO
 *
 * @link        http://github.com/PHPExif/php-exif-native for the canonical source repository
 * @copyright   Copyright (c) 2016 Tom Van Herreweghe <tom@theanalogguy.be>
 * @license     http://github.com/PHPExif/php-exif-native/blob/master/LICENSE MIT License
 * @category    PHPExif
 * @package     Native
 */

namespace PHPExif\Adapter\Native\Reader\Mapper\Exif;

use PHPExif\Common\Data\ExifInterface;
use PHPExif\Common\Data\ValueObject\Coordinates;
use PHPExif\Common\Data\ValueObject\DigitalDegrees;
use PHPExif\Common\Mapper\FieldMapper;
use PHPExif\Common\Mapper\GuardInvalidArgumentsForExifTrait;

/**
 * Mapper
 *
 * @category    PHPExif
 * @package     Native
 */
class CoordinatesFieldMapper implements FieldMapper
{
    use GuardInvalidArgumentsForExifTrait;

    /**
     * {@inheritDoc}
     */
    public function getSupportedFields()
    {
        return array(
            Coordinates::class,
        );
    }

    /**
     * {@inheritDoc}
     */
    public function mapField($field, array $input, &$output)
    {
        $this->guardInvalidArguments($field, $input, $output);

        if (!(array_key_exists('gpslatitude', $input) && array_key_exists('gpslongitude', $input))) {
            return;
        }

        $latitude = $this->extractGpsCoordinate($input['gpslatitude']);
        $longitude = $this->extractGpsCoordinate($input['gpslongitude']);
        $latitudeRef = empty($input['gpslatituderef'][0]) ? 'N' : $input['gpslatituderef'][0];
        $longitudeRef = empty($input['gpslongituderef'][0]) ? 'E' : $input['gpslongituderef'][0];

        $coordinates = new Coordinates(
            new DigitalDegrees(
                round((strtoupper($latitudeRef) === 'S' ? -1 : 1) * $latitude, 6)
            ),
            new DigitalDegrees(
                round((strtoupper($longitudeRef) === 'W' ? -1 : 1) * $longitude, 6)
            )
        );

        $output = $output->withCoordinates($coordinates);
    }

    /**
     * Extract & convert GPS coordinate to digital degrees
     *
     * @param array $data
     *
     * @return float
     */
    protected function extractGpsCoordinate(array $data)
    {
        // make sure we always have 3 components
        $default = [0, 0, 0];
        $data = array_replace($default, $data);

        // normalize the components
        array_walk($data, array($this, 'normalizeCoordinatePartData'));

        // convert to digital degrees
        return floatval($data[0]) + floatval($data[1]/60) + floatval($data[2]/3600);
    }

    /**
     * Converts notations like 5610/100 to 56.1
     *
     * @param mixed $data
     */
    protected function normalizeCoordinatePartData(&$data)
    {
        $parts = explode('/', $data);

        if (count($parts) == 1) {
            return $parts[0];
        }

        $data = floatval($parts[0]) / floatval($parts[1]);
    }
}
