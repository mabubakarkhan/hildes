<?php

namespace App\View\Composers;

use App\Models\ServicePage;
use Illuminate\Support\Collection;
use Illuminate\View\View;

class HomeServiceHrefsComposer
{
    public function compose(View $view): void
    {
        $svcList = $this->publishedServices($view);

        $href = static function (?string $slug): string {
            return $slug !== null && $slug !== ''
                ? route('service.slug', $slug)
                : route('services.index');
        };

        $slugByKeywords = static function (Collection $list, array $keywordsPreferred): ?string {
            foreach ($keywordsPreferred as $keyword) {
                $needle = strtolower(trim((string) $keyword));
                if ($needle === '') {
                    continue;
                }

                foreach ($list as $svc) {
                    $name = strtolower((string) $svc->name);
                    $slugLower = strtolower((string) $svc->slug);
                    if (str_contains($name, $needle) || str_contains($slugLower, str_replace([' ', '&'], '-', $needle))) {
                        return (string) $svc->slug;
                    }
                }
            }

            return null;
        };

        $view->with([
            'homeSvcHrefWeb' => $href($slugByKeywords($svcList, ['web development', 'frontend', 'backend', 'website', 'web'])),
            'homeSvcHrefMobile' => $href($slugByKeywords($svcList, ['mobile development', 'ios', 'android', 'mobile'])),
            'homeSvcHrefAi' => $href($slugByKeywords($svcList, ['machine learning', 'generative ai', 'ai/ml', 'artificial intelligence', 'ai automation', 'ai solutions', 'ai solution', 'automation experts', 'automation expert', 'automation'])),
            'homeSvcHrefDevops' => $href($slugByKeywords($svcList, ['devops engineering', 'devops'])),
            'homeSvcHrefSaaS' => $href($slugByKeywords($svcList, ['saas', 'saas platform'])),
            'homeSvcHrefDedicated' => $href($slugByKeywords($svcList, ['staff augmentation', 'dedicated teams', 'dedicated team'])),
        ]);
    }

    private function publishedServices(View $view): Collection
    {
        $raw = data_get($view->getData(), 'headerServices');
        $list = $raw instanceof Collection ? $raw : collect($raw ?? []);
        if ($list->isNotEmpty()) {
            return $list;
        }

        return ServicePage::query()
            ->where('is_published', true)
            ->ordered()
            ->get(['id', 'name', 'slug']);
    }
}
