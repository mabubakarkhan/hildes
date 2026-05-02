<?php

/**
 * Font Awesome 6 style icon classes for admin job picker (search uses label + class + keywords).
 */
$solidSlugs = [
    'briefcase', 'building', 'city', 'store', 'warehouse', 'industry', 'landmark', 'hotel',
    'user-tie', 'user', 'users', 'user-group', 'handshake',
    'chart-line', 'chart-bar', 'chart-pie', 'chart-area', 'arrow-trend-up', 'arrow-trend-down',
    'bullhorn', 'megaphone', 'comments', 'comment-dots', 'message', 'envelope', 'paper-plane',
    'phone', 'phone-volume', 'headset', 'microphone', 'video', 'camera', 'image', 'photo-film',
    'laptop', 'laptop-code', 'computer', 'desktop', 'keyboard', 'mouse', 'display', 'mobile-screen',
    'tablet', 'server', 'database', 'hard-drive', 'memory', 'microchip', 'network-wired',
    'ethernet', 'wifi', 'cloud', 'cloud-arrow-up', 'shield-halved', 'lock', 'key', 'fingerprint',
    'code', 'terminal', 'bug', 'gears', 'screwdriver-wrench', 'wrench', 'hammer', 'toolbox',
    'diagram-project', 'sitemap', 'folder-open', 'file-lines', 'file-code', 'clipboard-list',
    'list-check', 'list-ol', 'pen-to-square', 'pen', 'pencil', 'magnifying-glass', 'filter',
    'calendar-days', 'calendar-check', 'clock', 'hourglass-half', 'bell', 'flag', 'bookmark',
    'star', 'heart', 'thumbs-up', 'award', 'trophy', 'medal', 'certificate', 'graduation-cap',
    'book', 'book-open', 'lightbulb', 'brain', 'seedling', 'leaf', 'earth-americas', 'globe',
    'language', 'at', 'link', 'hashtag', 'share-nodes', 'rss', 'newspaper', 'tags', 'tag',
    'receipt', 'file-invoice-dollar', 'coins', 'credit-card', 'scale-balanced',
    'gavel', 'truck', 'plane', 'ship', 'box', 'boxes-stacked', 'cart-shopping', 'basket-shopping',
    'fire', 'bolt', 'gem', 'palette', 'paintbrush', 'wand-magic-sparkles', 'robot', 'rocket',
    'location-dot', 'map-location-dot', 'compass', 'route', 'plug', 'puzzle-piece',
    'cubes', 'layer-group', 'clone', 'copy', 'paste', 'floppy-disk', 'print', 'qrcode', 'barcode',
    'shield-virus', 'user-shield', 'eye', 'eye-slash', 'house', 'house-laptop',
    'building-columns', 'shop', 'cart-flatbed', 'hand-holding-dollar', 'money-bill-wave',
    'chart-simple', 'square-poll-vertical', 'table', 'table-columns', 'infinity', 'circle-play',
];

$brandSlugs = [
    'linkedin', 'github', 'facebook', 'twitter', 'instagram', 'youtube', 'slack', 'google',
    'microsoft', 'apple', 'android', 'docker', 'figma', 'wordpress', 'html5', 'css3-alt',
    'js', 'react', 'node', 'npm', 'git-alt', 'stack-overflow',
];

$icons = [];
foreach ($solidSlugs as $slug) {
    $class = 'fa-solid fa-'.$slug;
    $icons[] = [
        'class' => $class,
        'search' => strtolower($slug.' '.$class.' solid'),
    ];
}
foreach ($brandSlugs as $slug) {
    $class = 'fa-brands fa-'.$slug;
    $icons[] = [
        'class' => $class,
        'search' => strtolower($slug.' '.$class.' brand'),
    ];
}

return [
    'icons' => $icons,
    'default' => 'fa-solid fa-briefcase',
];
