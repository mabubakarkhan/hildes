<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ config('app.name', 'Laravel') }}</title>
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <style>
            :root {
                --preloader-accent: #FF750F;
                --preloader-bg: #000000;
            }

            body.is-preloading {
                overflow: hidden;
            }

            #site-content {
                opacity: 1;
                transition: opacity 420ms ease;
            }

            body.is-preloading #site-content {
                opacity: 0;
            }

            .preloader {
                position: fixed;
                inset: 0;
                z-index: 9999;
                pointer-events: auto;
                overflow: hidden;
            }

            .preloader__panel {
                position: absolute;
                left: 0;
                width: 100%;
                height: 50%;
                background: var(--preloader-bg);
                transition: transform 760ms cubic-bezier(0.22, 0.61, 0.36, 1);
                will-change: transform;
            }

            .preloader__panel--top {
                top: 0;
            }

            .preloader__panel--bottom {
                bottom: 0;
            }

            .preloader__center {
                position: absolute;
                inset: 0;
                display: flex;
                align-items: center;
                justify-content: center;
                transition: opacity 300ms ease;
            }

            .preloader__track {
                width: min(200px, 70vw);
                height: 3px;
                border-radius: 9999px;
                background: rgba(255, 255, 255, 0.22);
                overflow: hidden;
            }

            .preloader__bar {
                width: 45%;
                height: 100%;
                border-radius: inherit;
                background: var(--preloader-accent);
                animation: loaderBar 1.25s ease-in-out infinite;
                box-shadow: 0 0 12px rgba(255, 117, 15, 0.65);
            }

            .preloader.is-opening .preloader__center {
                opacity: 0;
            }

            .preloader.is-opening .preloader__panel--top {
                transform: translateY(-100%);
            }

            .preloader.is-opening .preloader__panel--bottom {
                transform: translateY(100%);
            }

            .preloader.is-done {
                pointer-events: none;
            }

            @keyframes loaderBar {
                0% {
                    transform: translateX(-120%);
                }
                50% {
                    transform: translateX(150%);
                }
                100% {
                    transform: translateX(320%);
                }
            }
        </style>
    </head>
    <body class="is-preloading bg-[#FDFDFC] text-[#111]">
        <div id="site-preloader" class="preloader" aria-hidden="true">
            <div class="preloader__panel preloader__panel--top"></div>
            <div class="preloader__panel preloader__panel--bottom"></div>
            <div class="preloader__center">
                <div class="preloader__track">
                    <div class="preloader__bar"></div>
                </div>
            </div>
        </div>

        <div id="site-content" class="min-h-screen flex items-center justify-center">
            <h1 class="text-2xl font-semibold">Welcome</h1>
        </div>

        <script>
            window.addEventListener("load", function () {
                const preloader = document.getElementById("site-preloader");
                const body = document.body;

                if (!preloader) {
                    body.classList.remove("is-preloading");
                    return;
                }

                const loadingDuration = 1050;
                const openDuration = 760;

                setTimeout(function () {
                    preloader.classList.add("is-opening");
                    body.classList.remove("is-preloading");
                }, loadingDuration);

                setTimeout(function () {
                    preloader.classList.add("is-done");
                    preloader.remove();
                }, loadingDuration + openDuration + 60);
            });
        </script>
    </body>
</html>
