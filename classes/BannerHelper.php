<?php

/**
 * Project: yytest
 * File: BannerHelper.php
 * User: YY
 * Date: 18.04.2021
 */
class BannerHelper
{
    /**
     * Output image to browser, only PNG implemented at the moment
     *
     * @param string $fileName
     *
     * @throws Exception
     */
    public static function getBannerImage(string $fileName)
    {
        if (($file = file_get_contents($fileName) === false)) {
            throw new Exception('cannot read file at ' . $fileName);
        }

        $pathParts = pathinfo($fileName);

        switch ($pathParts['extension']) {
            case 'png':
                self::getBannerPngImage($fileName);
                break;
            default:
                throw new Exception('Unsupported extension of image file at' . $fileName);
        }
    }

    /**
     * @param string $fileName
     *
     * @throws Exception
     */
    private static function getBannerPngImage(string $fileName)
    {
        if (($image = imagecreatefrompng($fileName)) === false) {
            throw new Exception('cannot create PNG image from file at ' . $fileName);
        }

        header('Content-Type:image/png');
        imagepng($image);
    }

}