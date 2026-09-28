<?php

namespace App\Modules\Identity\Services;

class CaptchaService
{
    protected const SESSION_KEY = 'admin_login_captcha';

    /**
     * Generate a new captcha, store in session, and return image as base64 data URI.
     */
    public function generate(): string
    {
        $numbers = '1234567890';
        $uppers = 'ABCDEFGHJKLMNPQRSTUVWXYZ';
        $lowers = 'abcdefghjkmnpqrstuvwxyz';
        $all = $numbers . $uppers . $lowers;

        // Ensure at least 1 digit, 1 uppercase, and 1 lowercase
        $chars = [
            $numbers[random_int(0, strlen($numbers) - 1)],
            $uppers[random_int(0, strlen($uppers) - 1)],
            $lowers[random_int(0, strlen($lowers) - 1)],
        ];

        // Fill remaining 3 characters to make 6 characters total
        for ($i = 0; $i < 3; $i++) {
            $chars[] = $all[random_int(0, strlen($all) - 1)];
        }

        // Shuffle characters
        shuffle($chars);
        $code = implode('', $chars);

        // Store exact case in session
        session([self::SESSION_KEY => $code]);

        return $this->createImage($code);
    }

    /**
     * Validate the given captcha code against session (case-sensitive).
     */
    public function validate(?string $input): bool
    {
        if (empty($input)) {
            return false;
        }

        $sessionCode = session(self::SESSION_KEY);
        if (!$sessionCode) {
            return false;
        }

        $isValid = hash_equals($sessionCode, trim($input));

        // Invalidate captcha after verification to prevent replay attacks
        session()->forget(self::SESSION_KEY);

        return $isValid;
    }

    /**
     * Create distorted PNG image for the captcha code.
     */
    protected function createImage(string $text): string
    {
        $width = 180;
        $height = 46;
        $image = imagecreatetruecolor($width, $height);

        // Background color (light slate)
        $bg = imagecolorallocate($image, 241, 245, 249);
        imagefilledrectangle($image, 0, 0, $width, $height, $bg);

        // Palette for letters
        $palette = [
            imagecolorallocate($image, 13, 148, 136), // teal-600
            imagecolorallocate($image, 2, 132, 199),  // sky-600
            imagecolorallocate($image, 37, 99, 235),  // blue-600
            imagecolorallocate($image, 79, 70, 229),  // indigo-600
            imagecolorallocate($image, 15, 23, 42),   // slate-900
        ];

        // Background noise lines
        $lineColor = imagecolorallocate($image, 203, 213, 225);
        for ($i = 0; $i < 4; $i++) {
            imageline($image, random_int(0, $width), random_int(0, $height), random_int(0, $width), random_int(0, $height), $lineColor);
        }

        // Noise dots
        $dotColor = imagecolorallocate($image, 148, 163, 184);
        for ($i = 0; $i < 70; $i++) {
            imagesetpixel($image, random_int(0, $width), random_int(0, $height), $dotColor);
        }

        // Detect available TTF fonts
        $ttfFont = null;
        $possibleFonts = [
            'C:/Windows/Fonts/arialbd.ttf',
            'C:/Windows/Fonts/arial.ttf',
            '/usr/share/fonts/truetype/dejavu/DejaVuSans-Bold.ttf',
            '/usr/share/fonts/truetype/liberation/LiberationSans-Bold.ttf',
        ];
        foreach ($possibleFonts as $f) {
            if (file_exists($f)) {
                $ttfFont = $f;
                break;
            }
        }

        $len = strlen($text);
        if ($ttfFont && function_exists('imagettftext')) {
            $fontSize = 19;
            for ($i = 0; $i < $len; $i++) {
                $angle = random_int(-14, 14);
                $x = 14 + ($i * 26) + random_int(-1, 1);
                $y = 33 + random_int(-2, 2);
                $color = $palette[array_rand($palette)];
                imagettftext($image, $fontSize, $angle, (int)$x, (int)$y, $color, $ttfFont, $text[$i]);
            }
        } else {
            $charWidth = ($width - 24) / $len;
            for ($i = 0; $i < $len; $i++) {
                $color = $palette[array_rand($palette)];
                $y = random_int(12, 17);
                $x = 14 + ($i * $charWidth) + random_int(-2, 2);
                imagechar($image, 5, (int)$x, (int)$y, $text[$i], $color);
            }
        }

        // Anti-OCR wave line
        $waveColor = imagecolorallocate($image, 100, 116, 139);
        for ($x = 0; $x < $width - 1; $x++) {
            $y = (int)(23 + sin($x / 14) * 6);
            imagesetpixel($image, $x, $y, $waveColor);
        }

        ob_start();
        imagepng($image);
        $data = ob_get_clean();
        imagedestroy($image);

        return 'data:image/png;base64,' . base64_encode($data);
    }
}
