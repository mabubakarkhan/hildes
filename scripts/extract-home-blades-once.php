<?php

/**
 * One-off: builds Blade partials from html/index.html using the same rules as ThemePageBuilder.
 * Run: php scripts/extract-home-blades-once.php
 */

declare(strict_types=1);

$root = dirname(__DIR__);
$html = file_get_contents($root . '/html/index.html') ?: '';

$footerStartNeedle = '<!-- rts footer two area wrapper -->';
$scriptsStartNeedle = '<script defer src="assets/js/plugins/jquery.js"></script>';

$headerEnd = strpos($html, '</header>');
$footerStart = strpos($html, $footerStartNeedle);
$scriptsStart = strpos($html, $scriptsStartNeedle);

$header = '';
if ($headerEnd !== false) {
    $s = strpos($html, '<header');
    if ($s !== false) {
        $header = substr($html, $s, ($headerEnd - $s) + strlen('</header>'));
    }
}

$content = '';
if ($headerEnd !== false && $footerStart !== false && $footerStart > $headerEnd) {
    $content = substr($html, $headerEnd + strlen('</header>'), $footerStart - ($headerEnd + strlen('</header>')));
}

$footer = '';
if ($footerStart !== false && $scriptsStart !== false && $scriptsStart > $footerStart) {
    $footer = substr($html, $footerStart, $scriptsStart - $footerStart);
}

$rewrite = static function (string $html): string {
    $html = preg_replace('/(src|href)=["\']assets\/([^"\']+)["\']/i', '$1="assets/$2"', $html) ?? $html;
    $html = preg_replace_callback('/href=["\']([^"\']+\.html)["\']/i', static function (array $m): string {
        $href = $m[1];
        if (str_starts_with($href, 'assets/')) {
            return 'href="' . $href . '"';
        }

        return 'href="/"';
    }, $html) ?? $html;

    return $html;
};

$sanitize = static function (string $html): string {
    $html = preg_replace('/<script\b[^>]*>.*?<\/script>/is', '', $html) ?? $html;

    return trim($html);
};

$header = $sanitize($rewrite($header));
$content = $sanitize($rewrite($content));
$footer = $sanitize($rewrite($footer));

$footer = str_replace('__HILDES_COPYRIGHT_YEAR__', '{{ date(\'Y\') }}', $footer);

$bladeEscape = static function (string $html): string {
    return str_replace('@', '@@', $html);
};

$views = $root . '/resources/views/frontend/partials';

file_put_contents($views . '/site-header.blade.php', $bladeEscape($header) . "\n");
file_put_contents($views . '/site-home-body.blade.php', $bladeEscape($content) . "\n");
file_put_contents($views . '/site-footer.blade.php', $bladeEscape($footer) . "\n");

echo "Wrote site-header, site-home-body, site-footer Blade partials.\n";
