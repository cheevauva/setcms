<?php

declare(strict_types=1);

namespace SetCMS\Module\Captcha\Servant;

use SetCMS\Module\Captcha\CaptchaEntity;

class CaptchaCreateServant implements \SetCMS\Contract\Servant
{

    use \SetCMS\DITrait;
    use \SetCMS\FactoryTrait;

    public CaptchaEntity $captcha;

    private const BACKGROUND_MIN = 160;
    private const TEXT_MAX = 50;

    private string $text;
    private int $width = 100;
    private int $height = 50;
    protected ?\GdImage $image = null;

    public function serve(): void
    {
        $this->captcha = new CaptchaEntity();
        $this->text = $this->captcha->text;
        $this->createImage();
    }

    protected function createImage(): void
    {
        $image = imagecreatetruecolor($this->width, $this->height);

        $colorText = [mt_rand(0, self::TEXT_MAX), mt_rand(0, self::TEXT_MAX), mt_rand(0, self::TEXT_MAX)];
        $colorBackground = [mt_rand(self::BACKGROUND_MIN, 255), mt_rand(self::BACKGROUND_MIN, 255), mt_rand(self::BACKGROUND_MIN, 255)];

        $imageColorBackground = imagecolorallocate($image, ...$colorBackground);
        $imageColorLine = imagecolorallocate($image, 64, 64, 64);
        $imageColorPixel = imagecolorallocate($image, 0, 0, 255);
        $imageColorText = imagecolorallocate($image, ...$colorText);

        imagefilledrectangle($image, 0, 0, $this->width, $this->height, $imageColorBackground);

        for ($i = 0; $i < rand(5, 7); $i++) {
            imageline($image, 0, rand() % $this->height, 250, rand() % $this->height, $imageColorLine);
        }

        for ($i = 0; $i < 500; $i++) {
            imagesetpixel($image, rand() % $this->width, rand() % $this->height, $imageColorPixel);
        }

        for ($i = 0; $i < strlen($this->text); $i++) {
            imagestring($image, 5, 10 + ($i * 10), 20, $this->text[$i], $imageColorText);
        }

        $rand1 = mt_rand(750000, 1200000) / 10000000;
        $rand2 = mt_rand(750000, 1200000) / 10000000;
        $rand3 = mt_rand(750000, 1200000) / 10000000;
        $rand4 = mt_rand(750000, 1200000) / 10000000;
        $rand5 = mt_rand(0, 31415926) / 10000000;
        $rand6 = mt_rand(0, 31415926) / 10000000;
        $rand7 = mt_rand(0, 31415926) / 10000000;
        $rand8 = mt_rand(0, 31415926) / 10000000;
        $rand9 = mt_rand(330, 420) / 110;
        $rand10 = mt_rand(330, 450) / 100;
        $center = $this->width / 2;

        $this->image = imagecreatetruecolor($this->width, $this->height);

        imagefilledrectangle($this->image, 0, 0, $this->width - 1, $this->height - 1, $imageColorBackground);
        imagefilledrectangle($this->image, 0, $this->height, $this->width - 1, $this->height, $imageColorText);

        for ($x = 0; $x <= $this->width; $x++) {
            for ($y = 0; $y <= $this->height; $y++) {
                $sinX = intval($x + (sin($x * $rand1 + $rand5) + sin($y * $rand3 + $rand6)) * $rand9 - $this->width / 2 + $center + 1);
                $sinY = intval($y + (sin($x * $rand2 + $rand7) + sin($y * $rand4 + $rand8)) * $rand10);

                if ($sinX < 0 || $sinY < 0 || $sinX >= $this->width - 1 || $sinY >= $this->height - 1) {
                    continue;
                } else {
                    $color = imagecolorat($image, $sinX, $sinY) & 0xFF;
                    $colorX = imagecolorat($image, $sinX + 1, $sinY) & 0xFF;
                    $colorY = imagecolorat($image, $sinX, $sinY + 1) & 0xFF;
                    $colorXY = imagecolorat($image, $sinX + 1, $sinY + 1) & 0xFF;
                }

                if ($color == 255 && $colorX == 255 && $colorY == 255 && $colorXY == 255) {
                    continue;
                } else if ($color == 0 && $colorX == 0 && $colorY == 0 && $colorXY == 0) {
                    $newred = $colorText[0];
                    $newgreen = $colorText[1];
                    $newblue = $colorText[2];
                } else {
                    $frsx = $sinX - floor($sinX);
                    $frsy = $sinY - floor($sinY);
                    $frsx1 = 1 - $frsx;
                    $frsy1 = 1 - $frsy;

                    $newColor = ($color * $frsx1 * $frsy1 + $colorX * $frsx * $frsy1 + $colorY * $frsx1 * $frsy + $colorXY * $frsx * $frsy);

                    if ($newColor > 255) {
                        $newColor = 255;
                    }

                    $newColor = $newColor / 255;
                    $newColor0 = 1 - $newColor;

                    $newred = intval($newColor0 * $colorText[0] + $newColor * $colorBackground[0]);
                    $newgreen = intval($newColor0 * $colorText[1] + $newColor * $colorBackground[1]);
                    $newblue = intval($newColor0 * $colorText[2] + $newColor * $colorBackground[2]);
                }

                imagesetpixel($this->image, $x, $y, imagecolorallocate($this->image, $newred, $newgreen, $newblue));
            }
        }
    }

}
