<?php
/**
 * Factory for wiring all the different mappers
 *
 * @link        http://github.com/PHPExif/php-exif-native for the canonical source repository
 * @copyright   Copyright (c) 2016 Tom Van Herreweghe <tom@theanalogguy.be>
 * @license     http://github.com/PHPExif/php-exif-native/blob/master/LICENSE MIT License
 * @category    PHPExif
 * @package     Native
 */

namespace PHPExif\Adapter\Native\Reader;

use PHPExif\Adapter\Native\Reader\Mapper\ExifMapper;

/**
 * MapperFactory
 *
 * Registers all available mappers
 *
 * @category    PHPExif
 * @package     Native
 */
class MapperFactory
{
    /**
     * Returns a Mapper instance complete with all sub-mappers
     * registered
     *
     * @return Mapper
     */
    public static function getMapper()
    {
        $exifMapper = self::getExifMapper();

        $mapper = new Mapper();
        $mapper->registerFieldMapper(
            $exifMapper
        );

        return $mapper;
    }

    /**
     * Returns the mapper for Exif data
     *
     * @return ExifMapper
     */
    private static function getExifMapper()
    {
        $exifMapper = new ExifMapper();

        // find all classes
        $reflClass = new \ReflectionClass(ExifMapper::class);
        $namespace = $reflClass->getNamespaceName();
        $namespace .= '\\Exif';

        $path = realpath(__DIR__ . '/Mapper/Exif');

        foreach (glob($path . '/*Mapper.php') as $classPath) {
            $className = str_replace('.php', '', array_reverse(
                explode(DIRECTORY_SEPARATOR, $classPath)
            )[0]);
            $fqcn = $namespace . '\\' . $className;

            $fieldMapper = new $fqcn();

            $exifMapper->registerFieldMapper($fieldMapper);
        }

        return $exifMapper;
    }
}
