@extends('frontend.layouts.app')

@section('content')
    <section class="rts-section-gap">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="text-center">
                        <h1 class="title mb--20">404</h1>
                        <h2 class="mb--20">Page not found</h2>
                        <p class="disc mb--30">
                            The page you requested does not exist, was moved, or is unavailable.
                        </p>
                        <a href="{{ route('home') }}" class="rts-btn btn-primary">Back to Home</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
