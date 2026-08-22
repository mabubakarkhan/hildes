<?php
/**
 * One-time WordPress tag merge. DELETE after use.
 * ?token=...&dry_run=1  (preview)
 * ?token=...            (execute)
 */
declare(strict_types=1);

$token = 'hildes-merge-tags-20260822-9x2k';
if (($_GET['token'] ?? '') !== $token) {
    http_response_code(404);
    exit('Not found');
}

$dryRun = isset($_GET['dry_run']);

require __DIR__ . '/wp-load.php';

header('Content-Type: text/plain; charset=UTF-8');

$mergeGroups = [
    'ai-automation' => [
        'ai', 'ai-agents', 'ai-app-rescue', 'ai-consulting', 'ai-for-business', 'ai-for-startups',
        'ai-integration', 'ai-solutions', 'ai-technology', 'ai-development', 'artificial-intelligence',
        'machine-learning', 'generative-ai', 'intelligent-automation', 'future-of-ai',
        'how-to-use-ai-for-your-business',
    ],
    'hr-tech' => [
        'ai-hiring', 'recruiting-software', 'ats',
    ],
    'digital-transformation' => [
        'digital-growth', 'digital-innovation', 'business-growth-through-technology',
        'technology-innovation', 'technology-trends', 'business-innovation', 'technology-solutions',
        'business-growth', 'customer-experience', 'business-intelligence', 'predictive-analytics',
    ],
    'saas-development' => [
        'saas', 'ai-saas', 'startup-saas', 'enterprise-saas', 'multi-tenant-saas',
        'software-as-a-service', 'saas-application-development', 'saas-architecture',
        'saas-development-services', 'saas-platform-development', 'saas-security',
    ],
    'mvp-development' => [
        'minimum-viable-product', 'build-mvp', 'startup-mvp', 'lean-startup', 'product-validation',
        'product-launch', 'startup-development', 'startup-strategy',
    ],
    'software-development' => [
        'software-development-process', 'software-company', 'software-collaboration',
        'enterprise-software', 'business-software', 'business-apps', 'scalable-applications',
        'cloud-software-development', 'app-debugging', 'erp-development',
    ],
    'mobile-app-development' => [
        'ios-development', 'android-development', 'flutter-development', 'react-native',
        'hybrid-mobile-apps', 'hybrid-mobile-app-development', 'cross-platform-development',
        'mobile-technology',
    ],
    'business-automation' => [
        'workflow-automation', 'process-automation', 'enterprise-automation',
        'smart-business-solutions', 'business-productivity',
    ],
    'custom-web-development' => [
        'web-development', 'web-application-development',
    ],
    'api-development' => [
        'api-integration', 'api-integrations',
    ],
    'cloud-devops' => [
        'cloud-computing', 'cloud-infrastructure', 'cloud-applications', 'devops',
    ],
    'project-management-software' => [
        'project-planning', 'project-tracking', 'software-project-management-system',
        'agile-development', 'development-workflow',
    ],
    'business-technology' => [
        'crm',
    ],
];

$deleteOnly = ['enterests'];

$keepCanonical = [
    'ai-automation', 'hr-tech', 'digital-transformation', 'saas-development', 'mvp-development',
    'software-development', 'mobile-app-development', 'business-automation', 'custom-web-development',
    'api-development', 'cloud-devops', 'project-management-software', 'ui-ux-design', 'hildes',
    'business-technology',
];

function tag_count(): int {
    global $wpdb;
    return (int) $wpdb->get_var("
        SELECT COUNT(*) FROM {$wpdb->terms} t
        INNER JOIN {$wpdb->term_taxonomy} tt ON tt.term_id = t.term_id
        WHERE tt.taxonomy = 'post_tag'
    ");
}

function term_id_by_slug(string $slug): ?int {
    $term = get_term_by('slug', $slug, 'post_tag');
    return ($term && ! is_wp_error($term)) ? (int) $term->term_id : null;
}

echo $dryRun ? "=== DRY RUN ===\n\n" : "=== EXECUTING MERGE ===\n\n";
echo 'Tags before: ' . tag_count() . "\n\n";

$merged = 0;
$deleted = 0;
$errors = [];

foreach ($mergeGroups as $canonicalSlug => $sourceSlugs) {
    $canonicalId = term_id_by_slug($canonicalSlug);
    if ($canonicalId === null) {
        if ($dryRun) {
            echo "[WARN] Canonical missing (would create on execute): {$canonicalSlug}\n";
            continue;
        }
        $created = wp_insert_term(ucwords(str_replace('-', ' ', $canonicalSlug)), 'post_tag', ['slug' => $canonicalSlug]);
        if (is_wp_error($created)) {
            $errors[] = "Failed creating {$canonicalSlug}: " . $created->get_error_message();
            continue;
        }
        $canonicalId = (int) $created['term_id'];
    }

    foreach ($sourceSlugs as $sourceSlug) {
        if ($sourceSlug === $canonicalSlug) {
            continue;
        }

        $sourceId = term_id_by_slug($sourceSlug);
        if ($sourceId === null) {
            echo "[SKIP] Source not found: {$sourceSlug}\n";
            continue;
        }

        $postIds = get_objects_in_term($sourceId, 'post_tag');
        if (is_wp_error($postIds)) {
            $errors[] = "get_objects_in_term failed for {$sourceSlug}";
            continue;
        }

        echo "Merge {$sourceSlug} ({$sourceId}) -> {$canonicalSlug} ({$canonicalId}) | posts: " . count($postIds) . "\n";

        foreach ($postIds as $postId) {
            $postId = (int) $postId;
            $current = wp_get_post_terms($postId, 'post_tag', ['fields' => 'ids']);
            if (is_wp_error($current)) {
                continue;
            }
            $newIds = array_values(array_unique(array_merge($current, [$canonicalId])));
            $newIds = array_values(array_diff($newIds, [$sourceId]));

            if (! $dryRun) {
                wp_set_post_terms($postId, $newIds, 'post_tag', false);
            }
        }

        if (! $dryRun) {
            $result = wp_delete_term($sourceId, 'post_tag');
            if (is_wp_error($result)) {
                $errors[] = "Delete {$sourceSlug}: " . $result->get_error_message();
            } else {
                $deleted++;
            }
        } else {
            $deleted++;
        }
        $merged++;
    }
}

foreach ($deleteOnly as $slug) {
    $id = term_id_by_slug($slug);
    if ($id === null) {
        echo "[SKIP] Delete not found: {$slug}\n";
        continue;
    }
    echo "Delete only: {$slug} ({$id})\n";
    if (! $dryRun) {
        $result = wp_delete_term($id, 'post_tag');
        if (is_wp_error($result)) {
            $errors[] = "Delete {$slug}: " . $result->get_error_message();
        } else {
            $deleted++;
        }
    } else {
        $deleted++;
    }
}

if (! $dryRun) {
    wp_cache_flush();
}

echo "\nTags after: " . ($dryRun ? tag_count() . ' (unchanged in dry run)' : tag_count()) . "\n";
echo "Merged sources processed: {$merged}\n";
echo "Terms deleted: {$deleted}\n";

if ($errors !== []) {
    echo "\nERRORS:\n" . implode("\n", $errors) . "\n";
}

echo "\nRemaining canonical tags kept:\n";
foreach ($keepCanonical as $slug) {
    $id = term_id_by_slug($slug);
    if ($id) {
        $term = get_term($id);
        echo "  {$slug} (count " . (int) $term->count . ")\n";
    } else {
        echo "  {$slug} (MISSING)\n";
    }
}
