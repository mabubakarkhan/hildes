<?php

declare(strict_types=1);

$mergeGroups = [
    'ai-automation' => [
        'ai', 'ai-agents', 'ai-app-rescue', 'ai-consulting', 'ai-for-business', 'ai-for-startups',
        'ai-integration', 'ai-solutions', 'ai-technology', 'ai-development', 'artificial-intelligence',
        'machine-learning', 'generative-ai', 'intelligent-automation', 'future-of-ai',
        'how-to-use-ai-for-your-business',
    ],
    'hr-tech' => ['ai-hiring', 'recruiting-software', 'ats'],
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
    'custom-web-development' => ['web-development', 'web-application-development'],
    'api-development' => ['api-integration', 'api-integrations'],
    'cloud-devops' => ['cloud-computing', 'cloud-infrastructure', 'cloud-applications', 'devops'],
    'project-management-software' => [
        'project-planning', 'project-tracking', 'software-project-management-system',
        'agile-development', 'development-workflow',
    ],
    'business-technology' => ['crm'],
];

$deleteOnly = ['enterests' => 'hildes'];

$lines = [
    '# BEGIN HilDes tag archive redirects (merged 2026-08-22)',
    '<IfModule mod_rewrite.c>',
    'RewriteEngine On',
];

foreach ($mergeGroups as $canonical => $sources) {
    foreach ($sources as $source) {
        if ($source === $canonical) {
            continue;
        }
        $lines[] = sprintf(
            'RewriteRule ^tag/%s/?$ /blog/tag/%s/ [R=301,L]',
            preg_quote($source, '/'),
            $canonical
        );
    }
}

foreach ($deleteOnly as $source => $target) {
    $lines[] = sprintf(
        'RewriteRule ^tag/%s/?$ /blog/tag/%s/ [R=301,L]',
        preg_quote($source, '/'),
        $target
    );
}

$lines[] = '</IfModule>';
$lines[] = '# END HilDes tag archive redirects';

echo implode("\n", $lines)."\n";
