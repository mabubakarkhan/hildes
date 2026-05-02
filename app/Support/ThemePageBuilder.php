<?php

namespace App\Support;

/**
 * @deprecated The public homepage no longer reads html/index.html at runtime.
 *             Use `php scripts/extract-home-blades-once.php` if you need to re-sync from the sample theme into Blade.
 */
class ThemePageBuilder
{
    public static function buildHomeFromIndex(): array
    {
        $html = file_get_contents(base_path('html/index.html')) ?: '';
        if ($html === '') {
            return [
                'headLinks' => [],
                'header' => '',
                'content' => '',
                'footer' => '',
                'scripts' => '',
            ];
        }

        $head = self::between($html, '<head>', '</head>');
        $header = self::segment($html, '<header', '</header>');

        $footerStartNeedle = '<!-- rts footer two area wrapper -->';
        $scriptsStartNeedle = '<script defer src="assets/js/plugins/jquery.js"></script>';

        $footerStart = strpos($html, $footerStartNeedle);
        $scriptsStart = strpos($html, $scriptsStartNeedle);
        $headerEnd = strpos($html, '</header>');

        $content = '';
        if ($headerEnd !== false && $footerStart !== false && $footerStart > $headerEnd) {
            $content = substr($html, $headerEnd + strlen('</header>'), $footerStart - ($headerEnd + strlen('</header>')));
        }

        $footer = '';
        if ($footerStart !== false && $scriptsStart !== false && $scriptsStart > $footerStart) {
            $footer = substr($html, $footerStart, $scriptsStart - $footerStart);
        }

        $scripts = '';
        if ($scriptsStart !== false) {
            $bodyEnd = strpos($html, '</body>');
            if ($bodyEnd === false) {
                $bodyEnd = strlen($html);
            }
            $scripts = substr($html, $scriptsStart, $bodyEnd - $scriptsStart);
        }

        $headLinks = self::extractHeadLinks($head);
        $header = self::sanitize(self::rewriteLinksAndAssets($header));
        $content = self::sanitize(self::rewriteLinksAndAssets($content));
        $footer = self::sanitize(self::rewriteLinksAndAssets($footer));
        $scripts = self::sanitizeScripts(self::rewriteLinksAndAssets($scripts));

        $footer = str_replace('__HILDES_COPYRIGHT_YEAR__', date('Y'), $footer);

        return compact('headLinks', 'header', 'content', 'footer', 'scripts');
    }

    private static function extractHeadLinks(string $head): array
    {
        preg_match_all('/<link[^>]+>/i', $head, $matches);
        $links = $matches[0] ?? [];

        return array_values(array_filter(array_map(function (string $link): string {
            // Ensure all theme head assets are served via Laravel route.
            $rewritten = self::rewriteLinksAndAssets($link);

            // Fix invalid "stylesheet preload" rel combination used in source HTML.
            $rewritten = preg_replace('/rel=["\']stylesheet preload["\']/i', 'rel="stylesheet"', $rewritten) ?? $rewritten;

            return $rewritten;
        }, $links)));
    }

    private static function between(string $html, string $start, string $end): string
    {
        $s = strpos($html, $start);
        if ($s === false) {
            return '';
        }
        $s += strlen($start);
        $e = strpos($html, $end, $s);
        if ($e === false) {
            return '';
        }
        return substr($html, $s, $e - $s);
    }

    private static function segment(string $html, string $startNeedle, string $endNeedle): string
    {
        $s = strpos($html, $startNeedle);
        if ($s === false) {
            return '';
        }
        $e = strpos($html, $endNeedle, $s);
        if ($e === false) {
            return '';
        }
        return substr($html, $s, ($e - $s) + strlen($endNeedle));
    }

    private static function rewriteLinksAndAssets(string $html): string
    {
        // Theme assets -> standard Laravel public/assets path.
        $html = preg_replace('/(src|href)=["\']assets\/([^"\']+)["\']/i', '$1="assets/$2"', $html) ?? $html;

        // All static page links -> home until pages are migrated.
        $html = preg_replace_callback('/href=["\']([^"\']+\.html)["\']/i', function (array $m): string {
            $href = $m[1];
            if (str_starts_with($href, 'assets/')) {
                return 'href="' . $href . '"';
            }
            return 'href="/"';
        }, $html) ?? $html;

        return $html;
    }

    private static function sanitize(string $html): string
    {
        // Remove inline scripts from content areas.
        $html = preg_replace('/<script\b[^>]*>.*?<\/script>/is', '', $html) ?? $html;
        return trim($html);
    }

    private static function sanitizeScripts(string $html): string
    {
        // Keep external script tags only; no inline scripts.
        preg_match_all('/<script\b[^>]*\bsrc=["\'][^"\']+["\'][^>]*>\s*<\/script>/i', $html, $matches);
        return implode("\n", $matches[0] ?? []);
    }
}

