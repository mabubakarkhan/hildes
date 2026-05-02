<x-admin-layout title="Edit Case Study">
    <div class="mb-4">
        <a href="{{ route('admin.case-studies.index') }}" class="btn btn-secondary inline-block">Back to Case Studies</a>
    </div>
    @include('admin.case-studies._form', [
        'action' => route('admin.case-studies.update', $caseStudy),
        'method' => 'PUT',
        'submitLabel' => 'Save changes',
        'caseStudy' => $caseStudy,
    ])
</x-admin-layout>

