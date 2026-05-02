<x-admin-layout title="Create Case Study">
    <div class="mb-4">
        <a href="{{ route('admin.case-studies.index') }}" class="btn btn-secondary inline-block">Back to Case Studies</a>
    </div>
    @include('admin.case-studies._form', [
        'action' => route('admin.case-studies.store'),
        'method' => 'POST',
        'submitLabel' => 'Create Case Study',
        'caseStudy' => null,
    ])
</x-admin-layout>

