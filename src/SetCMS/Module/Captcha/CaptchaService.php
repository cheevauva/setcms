<?php

namespace SetCMS\Module\Captcha;

use SetCMS\Module\Captcha\CaptchaDAO;
use SetCMS\Module\Captcha\Captcha;
use SetCMS\Module\Ordinary\OrdinaryService;

class CaptchaService extends OrdinaryService
{

    private CaptchaDAO $captchaDAO;

    public function __construct(CaptchaDAO $captchaDAO)
    {
        $this->captchaDAO = $captchaDAO;
    }

    private function createPngImage(string $text): string
    {
        $image = imagecreatetruecolor(200, 50);
        $background_color = imagecolorallocate($image, 255, 255, 255);
        imagefilledrectangle($image, 0, 0, 200, 50, $background_color);
        $line_color = imagecolorallocate($image, 64, 64, 64);
        $number_of_lines = rand(3, 7);

        for ($i = 0; $i < $number_of_lines; $i++) {
            imageline($image, 0, rand() % 50, 250, rand() % 50, $line_color);
        }

        $pixel = imagecolorallocate($image, 0, 0, 255);

        for ($i = 0; $i < 500; $i++) {
            imagesetpixel($image, rand() % 200, rand() % 50, $pixel);
        }

        $color = imagecolorallocate($image, 0, 0, 0);

        for ($i = 0; $i < strlen($text); $i++) {
            imagestring($image, 5, 5 + ($i * 30), 20, $text[$i], $color);
        }

        $file = fopen('php://memory', 'r+');
        
        imagepng($image, $file);

        rewind($file);

        return base64_encode(stream_get_contents($file));
    }

    public function solveCaptcha(string $id, string $solvedText): Captcha
    {
        $captcha = $this->dao()->get($id);
        $captcha->solve($solvedText);

        $this->dao()->save($captcha);

        return $captcha;
    }

    public function useSolvedCaptchaById(string $id): Captcha
    {
        $captcha = $this->dao()->get($id);
        $captcha->use();

        $this->dao()->save($captcha);

        return $captcha;
    }

    public function createCaptcha(): Captcha
    {
        $captcha = new Captcha;
        $captcha->content = $this->createPngImage($captcha->text());

        $this->dao()->save($captcha);

        return $captcha;
    }

    protected function dao(): CaptchaDAO
    {
        return $this->captchaDAO;
    }

    public function entity(): Captcha
    {
        return new Captcha;
    }

}
