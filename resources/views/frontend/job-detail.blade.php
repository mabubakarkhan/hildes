@extends('frontend.layouts.app')

@section('content')
    <div class="hildes-job-detail-page">
        @include('frontend.partials.sections.page-hero', [
            'pre' => $job->department ?? 'Open role',
            'bgTitle' => 'Careers',
            'title' => $job->title,
        ])

        <div class="container rts-section-gapBottom">
            <nav class="hildes-job-detail-breadcrumb" aria-label="Breadcrumb">
                <a href="{{ route('careers.page') }}">Careers</a>
                <span class="hildes-job-detail-breadcrumb__sep" aria-hidden="true">/</span>
                <span class="hildes-job-detail-breadcrumb__current">{{ $job->title }}</span>
            </nav>

            <div class="row g-4 g-lg-5">
                <div class="col-lg-8">
                    <div class="hildes-job-detail-main">
                        <div class="hildes-job-detail-summary card-like">
                            <div class="hildes-job-detail-summary__icon" aria-hidden="true">
                                @php
                                    $jdIconClass = filled($job->icon_class) ? $job->icon_class : 'fa-regular fa-briefcase';
                                @endphp
                                <i class="{{ $jdIconClass }}"></i>
                            </div>
                            <div class="hildes-job-detail-summary__body">
                                @php
                                    $jdSubtitle = trim(implode(' · ', array_filter([$job->department, $job->employment_type])));
                                @endphp
                                @if(filled($jdSubtitle))
                                    <p class="hildes-job-detail-summary__subtitle">{{ $jdSubtitle }}</p>
                                @endif
                                <ul class="hildes-job-detail-summary__tags">
                                    @if(filled($job->location))
                                        <li><i class="fa-solid fa-location-dot"></i>{{ $job->location }}</li>
                                    @endif
                                    @if(filled($job->work_mode))
                                        <li><i class="fa-regular fa-file-lines"></i>{{ $job->work_mode }}</li>
                                    @endif
                                    @if(filled($job->experience_level))
                                        <li><i class="fa-solid fa-user-graduate"></i>{{ $job->experience_level }}</li>
                                    @endif
                                    @if($job->deadline)
                                        <li><i class="fa-regular fa-calendar"></i>Apply by {{ $job->deadline->format('j M Y') }}</li>
                                    @endif
                                    @if(filled($job->salary_range))
                                        <li><i class="fa-solid fa-dollar-sign"></i>{{ $job->salary_range }}</li>
                                    @endif
                                </ul>
                            </div>
                        </div>

                        @if(filled($job->description))
                            <section class="hildes-job-detail-section card-like">
                                <h2 class="hildes-job-detail-section__title">About this role</h2>
                                <div class="hildes-job-detail-prose">{!! $job->description !!}</div>
                            </section>
                        @endif

                        @if(filled($job->responsibilities))
                            <section class="hildes-job-detail-section card-like">
                                <h2 class="hildes-job-detail-section__title">Responsibilities</h2>
                                <div class="hildes-job-detail-prose">{!! $job->responsibilities !!}</div>
                            </section>
                        @endif

                        @if(filled($job->required_skills))
                            <section class="hildes-job-detail-section card-like">
                                <h2 class="hildes-job-detail-section__title">Skills &amp; qualifications</h2>
                                <div class="hildes-job-detail-prose">{!! $job->required_skills !!}</div>
                            </section>
                        @endif

                        @if(filled($job->education_requirements))
                            <section class="hildes-job-detail-section card-like">
                                <h2 class="hildes-job-detail-section__title">Education</h2>
                                <div class="hildes-job-detail-prose">{!! nl2br(e($job->education_requirements)) !!}</div>
                            </section>
                        @endif

                        <div class="hildes-job-detail-back-mobile d-lg-none">
                            <a href="{{ route('careers.page') }}" class="rts-btn btn-border"><i class="fa-solid fa-arrow-left" aria-hidden="true"></i> All openings</a>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <aside class="case-study-contact-wrap" id="apply">
                        <div class="service-section-card service-section-card--b case-study-contact-inline">
                            <h3 class="title">Apply for this role</h3>
                            <p class="case-study-contact-subtitle">Send your details and CV. We’ll get back to you if there’s a fit.</p>

                            <form id="job-apply-form" class="case-study-contact-form" method="post" action="{{ route('careers.job.apply', ['job' => $job->slug]) }}" enctype="multipart/form-data" novalidate>
                                @csrf
                                <div class="form-group">
                                    <label for="apply-full-name">Full name</label>
                                    <input id="apply-full-name" class="@error('full_name') is-invalid @enderror" type="text" name="full_name" value="{{ old('full_name') }}" required autocomplete="name">
                                    <span class="job-apply-field-error" data-job-apply-error="full_name" role="alert">@error('full_name'){{ $message }}@enderror</span>
                                </div>
                                <div class="form-group">
                                    <label for="apply-email">Email</label>
                                    <input id="apply-email" class="@error('email') is-invalid @enderror" type="email" name="email" value="{{ old('email') }}" required autocomplete="email">
                                    <span class="job-apply-field-error" data-job-apply-error="email" role="alert">@error('email'){{ $message }}@enderror</span>
                                </div>
                                <div class="form-group">
                                    <label for="apply-phone">Phone</label>
                                    <input id="apply-phone" class="@error('phone') is-invalid @enderror" type="text" name="phone" value="{{ old('phone') }}" autocomplete="tel">
                                    <span class="job-apply-field-error" data-job-apply-error="phone" role="alert">@error('phone'){{ $message }}@enderror</span>
                                </div>
                                <div class="form-group">
                                    <label for="apply-education">Education level</label>
                                    <input id="apply-education" class="@error('education_level') is-invalid @enderror" type="text" name="education_level" value="{{ old('education_level') }}" placeholder="e.g. Bachelor’s in CS">
                                    <span class="job-apply-field-error" data-job-apply-error="education_level" role="alert">@error('education_level'){{ $message }}@enderror</span>
                                </div>
                                <div class="form-group">
                                    <label for="apply-years">Years of experience</label>
                                    <select id="apply-years" class="@error('experience_years') is-invalid @enderror" name="experience_years" required>
                                        @for ($y = 0; $y <= 60; $y++)
                                            <option value="{{ $y }}" @selected((int) old('experience_years', 0) === $y)>{{ $y }}{{ $y === 1 ? ' year' : ' years' }}</option>
                                        @endfor
                                    </select>
                                    <span class="job-apply-field-error" data-job-apply-error="experience_years" role="alert">@error('experience_years'){{ $message }}@enderror</span>
                                </div>
                                <div class="form-group">
                                    <label for="apply-skills">Skills</label>
                                    <textarea id="apply-skills" class="@error('skills') is-invalid @enderror" name="skills" rows="3" placeholder="Tools, frameworks, languages…">{{ old('skills') }}</textarea>
                                    <span class="job-apply-field-error" data-job-apply-error="skills" role="alert">@error('skills'){{ $message }}@enderror</span>
                                </div>
                                <div class="form-group">
                                    <label for="apply-cover">Cover letter</label>
                                    <textarea id="apply-cover" class="@error('cover_letter') is-invalid @enderror" name="cover_letter" rows="4" placeholder="Tell us why you’re interested in this role.">{{ old('cover_letter') }}</textarea>
                                    <span class="job-apply-field-error" data-job-apply-error="cover_letter" role="alert">@error('cover_letter'){{ $message }}@enderror</span>
                                </div>
                                <div class="form-group">
                                    <label for="apply-cv">Resume / CV (max 5MB)</label>
                                    <div class="job-apply-dropzone @error('cv_file') is-invalid @enderror" data-job-apply-dropzone>
                                        <input id="apply-cv" class="job-apply-dropzone__input-native @error('cv_file') is-invalid @enderror" type="file" name="cv_file" accept=".pdf,.doc,.docx,application/pdf">
                                        <label for="apply-cv" class="job-apply-dropzone__label-hit">
                                            <span class="job-apply-dropzone__ui">
                                                <span class="job-apply-dropzone__icon"><i class="fa-solid fa-cloud-arrow-up"></i></span>
                                                <span class="job-apply-dropzone__line"><strong>Click to upload</strong> or drag and drop</span>
                                                <span class="job-apply-dropzone__hint">PDF, DOC, DOCX · max 5MB</span>
                                                <span class="job-apply-dropzone__name" data-dropzone-filename hidden></span>
                                            </span>
                                        </label>
                                    </div>
                                    <span class="job-apply-field-error" data-job-apply-error="cv_file" role="alert">@error('cv_file'){{ $message }}@enderror</span>
                                </div>
                                <button type="submit" class="rts-btn btn-primary" id="job-apply-submit" data-default-label="Submit application">
                                    <span class="job-apply-btn-text">Submit application</span>
                                </button>
                            </form>
                        </div>

                        <div class="service-section-card service-section-card--b case-study-contact-inline hildes-job-detail-side-foot d-none d-lg-block mt-4">
                            <a href="{{ route('careers.page') }}" class="hildes-job-detail-all-link"><i class="fa-solid fa-arrow-left" aria-hidden="true"></i> Back to all openings</a>
                            @if($job->deadline)
                                <p class="hildes-job-detail-deadline-note">Deadline: <strong>{{ $job->deadline->format('j F Y') }}</strong></p>
                            @endif
                        </div>
                    </aside>
                </div>
            </div>
        </div>

        <div id="hildes-job-apply-toast" class="hildes-job-apply-toast" role="status" aria-live="polite" hidden></div>

        <div class="careers-page-end-spacer" aria-hidden="true"></div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var form = document.getElementById('job-apply-form');
            var submitBtn = document.getElementById('job-apply-submit');
            var toast = document.getElementById('hildes-job-apply-toast');
            if (!form || !submitBtn || !toast) return;
            if (typeof fetch !== 'function') return;

            var btnLabel = submitBtn.querySelector('.job-apply-btn-text');
            var defaultText = submitBtn.getAttribute('data-default-label') || 'Submit application';
            var toastTimer = null;

            function clearFieldErrors() {
                form.querySelectorAll('.is-invalid').forEach(function (el) {
                    el.classList.remove('is-invalid');
                });
                form.querySelectorAll('[data-job-apply-dropzone]').forEach(function (el) {
                    el.classList.remove('is-invalid', 'job-apply-dropzone--active');
                });
                form.querySelectorAll('[data-job-apply-error]').forEach(function (el) {
                    el.textContent = '';
                });
            }

            function applyFieldErrors(errors) {
                if (!errors || typeof errors !== 'object') return;
                Object.keys(errors).forEach(function (key) {
                    var input = form.querySelector('[name="' + key + '"]');
                    if (input) {
                        input.classList.add('is-invalid');
                        var dz = input.closest('[data-job-apply-dropzone]');
                        if (dz) dz.classList.add('is-invalid');
                    }
                    var errEl = form.querySelector('[data-job-apply-error="' + key + '"]');
                    if (errEl && errors[key] && errors[key][0]) {
                        errEl.textContent = errors[key][0];
                    }
                });
            }

            (function initCvDropzone() {
                var dz = form.querySelector('[data-job-apply-dropzone]');
                var input = document.getElementById('apply-cv');
                var nameEl = form.querySelector('[data-dropzone-filename]');
                if (!dz || !input || !nameEl) return;

                function setFile(file) {
                    if (!file) {
                        input.value = '';
                        nameEl.hidden = true;
                        nameEl.textContent = '';
                        return;
                    }
                    try {
                        var dt = new DataTransfer();
                        dt.items.add(file);
                        input.files = dt.files;
                    } catch (_e) {
                        return;
                    }
                    nameEl.textContent = file.name;
                    nameEl.hidden = false;
                    dz.classList.remove('is-invalid');
                    input.classList.remove('is-invalid');
                    var errCv = form.querySelector('[data-job-apply-error="cv_file"]');
                    if (errCv) errCv.textContent = '';
                }

                input.addEventListener('change', function () {
                    var f = input.files && input.files[0];
                    setFile(f || null);
                });

                ['dragenter', 'dragover'].forEach(function (ev) {
                    dz.addEventListener(ev, function (e) {
                        e.preventDefault();
                        e.stopPropagation();
                        dz.classList.add('job-apply-dropzone--active');
                    });
                });
                ['dragleave', 'drop'].forEach(function (ev) {
                    dz.addEventListener(ev, function (e) {
                        e.preventDefault();
                        e.stopPropagation();
                        dz.classList.remove('job-apply-dropzone--active');
                    });
                });
                dz.addEventListener('drop', function (e) {
                    var files = e.dataTransfer && e.dataTransfer.files;
                    if (!files || !files.length) return;
                    setFile(files[0]);
                });
            })();

            function showToast(message, isError) {
                if (toastTimer) clearTimeout(toastTimer);
                toast.hidden = false;
                toast.textContent = message || '';
                toast.classList.toggle('hildes-job-apply-toast--error', !!isError);
                toast.classList.add('hildes-job-apply-toast--visible');
                toastTimer = setTimeout(function () {
                    toast.classList.remove('hildes-job-apply-toast--visible');
                    setTimeout(function () {
                        toast.hidden = true;
                        toast.textContent = '';
                    }, 320);
                }, 5200);
            }

            form.addEventListener('submit', function (e) {
                e.preventDefault();
                clearFieldErrors();

                submitBtn.disabled = true;
                submitBtn.classList.add('is-loading');
                if (btnLabel) btnLabel.textContent = 'Sending…';

                var fd = new FormData(form);

                fetch(form.action, {
                    method: 'POST',
                    body: fd,
                    headers: {
                        Accept: 'application/json',
                        'X-Requested-With': 'XMLHttpRequest',
                    },
                    credentials: 'same-origin',
                })
                    .then(function (res) {
                        return res.text().then(function (text) {
                            var data = {};
                            try {
                                data = text ? JSON.parse(text) : {};
                            } catch (_e) {}
                            return { ok: res.ok, status: res.status, data: data };
                        });
                    })
                    .then(function (result) {
                        if (result.status === 419) {
                            showToast('Session expired. Refresh the page and try again.', true);
                            return;
                        }
                        if (result.ok && result.data && result.data.success) {
                            showToast(result.data.message || 'Application sent.', false);
                            form.reset();
                            var dzReset = form.querySelector('[data-job-apply-dropzone]');
                            var nameReset = form.querySelector('[data-dropzone-filename]');
                            if (nameReset) {
                                nameReset.hidden = true;
                                nameReset.textContent = '';
                            }
                            if (dzReset) {
                                dzReset.classList.remove('is-invalid', 'job-apply-dropzone--active');
                            }
                            var cvIn = document.getElementById('apply-cv');
                            if (cvIn) cvIn.classList.remove('is-invalid');
                            return;
                        }
                        if (result.status === 422 && result.data && result.data.errors) {
                            applyFieldErrors(result.data.errors);
                            showToast(
                                (result.data.message || 'Please check the highlighted fields.') + '',
                                true
                            );
                            return;
                        }
                        var msg =
                            (result.data && result.data.message) ||
                            'Something went wrong. Please try again.';
                        showToast(msg, true);
                    })
                    .catch(function () {
                        showToast('Network error. Please try again.', true);
                    })
                    .finally(function () {
                        submitBtn.disabled = false;
                        submitBtn.classList.remove('is-loading');
                        if (btnLabel) btnLabel.textContent = defaultText;
                    });
            });
        });
    </script>
@endpush
