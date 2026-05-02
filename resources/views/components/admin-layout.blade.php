@props(['title' => 'Admin'])

<!DOCTYPE html>
<html lang="en" class="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title }}</title>
    @php
        $spaceImagePool = collect(glob(resource_path('images/space/*.{png,jpg,jpeg,webp,gif}'), GLOB_BRACE))
            ->map(function ($path) {
                $ext = strtolower(pathinfo($path, PATHINFO_EXTENSION));
                $mimeExt = $ext === 'jpg' ? 'jpeg' : $ext;
                return 'data:image/' . $mimeExt . ';base64,' . base64_encode(file_get_contents($path));
            })
            ->values()
            ->all();
    @endphp
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Mona+Sans:ital,wght@0,200..900;1,200..900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/2.0.8/css/dataTables.dataTables.min.css">
    @if(request()->is('admin/jobs') || request()->is('admin/jobs/*'))
        <link rel="stylesheet" href="{{ asset('assets/css/plugins/fontawesome.css') }}">
    @endif
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = { darkMode: 'class' };
    </script>
    <style>
        :root {
            --brand-orange: #ff6600;
            --brand-orange-soft: #ff8a3d;
            --brand-blue-900: #050d1f;
            --brand-blue-800: #0a1630;
            --brand-blue-700: #122447;
            --brand-card: #0c1935;
            --brand-border: rgba(255, 102, 0, 0.28);
            --brand-text: #dbe7ff;
            --card-glow: 0 10px 30px rgba(6, 10, 35, 0.35), 0 0 0 1px rgba(255, 102, 0, 0.1);
        }
        html:not(.dark) {
            --brand-blue-900: #f6f8fd;
            --brand-blue-800: #ffffff;
            --brand-blue-700: #eef3ff;
            --brand-card: #ffffff;
            --brand-border: rgba(255, 102, 0, 0.24);
            --brand-text: #1b2c4d;
            --card-glow: 0 10px 30px rgba(20, 34, 73, 0.07), 0 0 0 1px rgba(255, 102, 0, 0.14);
        }
        body {
            background: radial-gradient(circle at top right, rgba(255, 102, 0, 0.12), transparent 35%),
                        radial-gradient(circle at 20% 20%, rgba(85, 128, 255, 0.18), transparent 40%),
                        var(--brand-blue-900);
            color: var(--brand-text);
            font-family: "Mona Sans", "Segoe UI", sans-serif;
            font-optical-sizing: auto;
            font-variation-settings: "wdth" 100;
            letter-spacing: .01em;
        }
        .bg-slate-950 { background: var(--brand-blue-900) !important; }
        .bg-slate-900 { background: linear-gradient(180deg, var(--brand-card), var(--brand-blue-800)) !important; }
        .bg-slate-800 { background: rgba(7, 16, 37, 0.72) !important; }
        html:not(.dark) .bg-slate-800 { background: #f4f7ff !important; }
        .border-cyan-500\/20, .border-slate-700, .border-slate-800 { border-color: var(--brand-border) !important; }
        .text-cyan-400, .text-cyan-300 { color: var(--brand-orange-soft) !important; }
        .bg-cyan-600 { background: linear-gradient(90deg, #ff6600, #ff8a3d) !important; }
        .bg-cyan-600:hover { filter: brightness(1.04); }
        .bg-rose-600 { background: #243b67 !important; }
        .text-rose-400 { color: #ff9b5c !important; }
        .text-slate-100, .text-slate-300, .text-slate-400 { color: var(--brand-text) !important; opacity: 0.92; }
        h1, h2, h3, h4, .heading-text { letter-spacing: .055em; font-weight: 700; }
        h1, h2, h3 { color: #ffb07a; text-shadow: 0 1px 0 rgba(255,255,255,.04), 0 0 18px rgba(255,102,0,.14); }
        html:not(.dark) h1, html:not(.dark) h2, html:not(.dark) h3 { color: #d25a00; text-shadow: none; }
        * { transition: all .22s ease; }
        .panel {
            border: 1px solid var(--brand-border);
            border-radius: 14px;
            box-shadow: var(--card-glow);
            position: relative;
            overflow: hidden;
        }
        .panel::before {
            content: "";
            position: absolute;
            inset: -120px auto auto -120px;
            width: 240px;
            height: 240px;
            background: radial-gradient(circle, rgba(255, 102, 0, .18), transparent 70%);
            pointer-events: none;
        }
        .panel::after {
            content: "";
            position: absolute;
            inset: 0;
            pointer-events: none;
            opacity: .18;
            background-image:
                repeating-linear-gradient(
                    to right,
                    rgba(255,255,255,.07) 0,
                    rgba(255,255,255,.07) 1px,
                    transparent 1px,
                    transparent 22px
                ),
                repeating-linear-gradient(
                    to bottom,
                    rgba(255,255,255,.07) 0,
                    rgba(255,255,255,.07) 1px,
                    transparent 1px,
                    transparent 22px
                ),
                repeating-linear-gradient(
                    to right,
                    rgba(255,102,0,.13) 0,
                    rgba(255,102,0,.13) 1px,
                    transparent 1px,
                    transparent 110px
                ),
                repeating-linear-gradient(
                    to bottom,
                    rgba(255,102,0,.13) 0,
                    rgba(255,102,0,.13) 1px,
                    transparent 1px,
                    transparent 110px
                );
            border-radius: inherit;
        }
        html:not(.dark) .panel::after {
            opacity: .13;
            background-image:
                repeating-linear-gradient(
                    to right,
                    rgba(20,40,90,.06) 0,
                    rgba(20,40,90,.06) 1px,
                    transparent 1px,
                    transparent 22px
                ),
                repeating-linear-gradient(
                    to bottom,
                    rgba(20,40,90,.06) 0,
                    rgba(20,40,90,.06) 1px,
                    transparent 1px,
                    transparent 22px
                ),
                repeating-linear-gradient(
                    to right,
                    rgba(255,102,0,.16) 0,
                    rgba(255,102,0,.16) 1px,
                    transparent 1px,
                    transparent 110px
                ),
                repeating-linear-gradient(
                    to bottom,
                    rgba(255,102,0,.16) 0,
                    rgba(255,102,0,.16) 1px,
                    transparent 1px,
                    transparent 110px
                );
        }
        .sidebar-texture {
            position: absolute;
            inset: 0;
            pointer-events: none;
            z-index: 0;
            opacity: .36;
            background-image:
                repeating-linear-gradient(
                    to right,
                    rgba(255,255,255,.09) 0,
                    rgba(255,255,255,.09) 1px,
                    transparent 1px,
                    transparent 24px
                ),
                repeating-linear-gradient(
                    to bottom,
                    rgba(255,255,255,.09) 0,
                    rgba(255,255,255,.09) 1px,
                    transparent 1px,
                    transparent 24px
                ),
                repeating-linear-gradient(
                    to right,
                    rgba(255,102,0,.18) 0,
                    rgba(255,102,0,.18) 1px,
                    transparent 1px,
                    transparent 120px
                ),
                repeating-linear-gradient(
                    to bottom,
                    rgba(255,102,0,.18) 0,
                    rgba(255,102,0,.18) 1px,
                    transparent 1px,
                    transparent 120px
                );
        }
        .sidebar-bubbles {
            position: absolute;
            inset: 0;
            z-index: 0;
            pointer-events: none;
            overflow: hidden;
        }
        .sidebar-bubbles span {
            position: absolute;
            border-radius: 999px;
            filter: blur(1px);
            opacity: .34;
            background: radial-gradient(circle at 35% 30%, rgba(255, 164, 102, .55), rgba(255, 102, 0, .08) 58%, transparent 100%);
            border: 1px solid rgba(255, 120, 48, .25);
            box-shadow: 0 0 26px rgba(255, 102, 0, .22);
        }
        .sidebar-bubbles .b1 { width: 140px; height: 140px; top: 8%; left: -42px; }
        .sidebar-bubbles .b2 { width: 96px; height: 96px; top: 42%; right: -28px; opacity: .16; }
        .sidebar-bubbles .b3 { width: 128px; height: 128px; bottom: 9%; left: 28%; opacity: .14; }
        .sidebar-bubbles .b4 { width: 210px; height: 210px; top: 18%; right: -92px; opacity: .12; }
        .sidebar-bubbles .b5 { width: 64px; height: 64px; top: 30%; left: 16px; opacity: .22; }
        .sidebar-bubbles .b6 { width: 170px; height: 170px; bottom: 26%; left: -70px; opacity: .11; }
        .sidebar-bubbles .b7 { width: 84px; height: 84px; bottom: 18%; right: 20px; opacity: .18; }
        .sidebar-bubbles .b8 { width: 260px; height: 260px; bottom: -120px; right: -98px; opacity: .1; }
        .sidebar-bubbles .b9 { width: 46px; height: 46px; top: 66%; left: 54%; opacity: .2; }
        .sidebar-bubbles .b10 { width: 32px; height: 32px; top: 24%; left: 64%; opacity: .3; }
        .sidebar-bubbles .b11 { width: 24px; height: 24px; top: 55%; left: 78%; opacity: .32; }
        .sidebar-bubbles .b12 { width: 38px; height: 38px; bottom: 34%; left: 10%; opacity: .29; }
        .sidebar-bubbles .b13 { width: 18px; height: 18px; top: 72%; right: 18%; opacity: .34; }
        .sidebar-bubbles .b14 { width: 14px; height: 14px; top: 14%; right: 26%; opacity: .36; }
        .sidebar-bubbles .b15 { width: 20px; height: 20px; bottom: 12%; left: 48%; opacity: .33; }
        html:not(.dark) .sidebar-bubbles span {
            opacity: .2;
            background: radial-gradient(circle at 35% 30%, rgba(255, 164, 102, .42), rgba(255, 102, 0, .06) 58%, transparent 100%);
            border-color: rgba(255, 120, 48, .18);
            box-shadow: 0 0 20px rgba(255, 102, 0, .16);
        }
        .space-fleet {
            position: fixed;
            left: 0;
            top: 0;
            width: 100vw;
            height: 100vh;
            z-index: 0;
            pointer-events: none;
            overflow: hidden;
        }
        .space-fleet .cosmic-item {
            position: absolute;
            width: 220px;
            height: 120px;
            opacity: .14;
            display: flex;
            align-items: center;
            justify-content: center;
            filter: drop-shadow(0 0 10px rgba(255, 132, 57, .16));
            transform: translateY(0);
        }
        .space-fleet .cosmic-item img {
            width: 100%;
            height: 100%;
            object-fit: contain;
            user-select: none;
            -webkit-user-drag: none;
            filter: saturate(.72) brightness(.9) drop-shadow(0 0 8px rgba(255, 102, 0, .13));
        }
        .space-fleet::before {
            content: "";
            position: absolute;
            inset: 0;
            background: radial-gradient(circle at 70% 20%, rgba(255, 102, 0, .11), transparent 45%),
                        radial-gradient(circle at 80% 70%, rgba(100, 140, 255, .08), transparent 50%);
        }
        html:not(.dark) .space-fleet .cosmic-item { opacity: .1; }
        .shooting-star {
            position: absolute;
            width: 140px;
            height: 2px;
            border-radius: 999px;
            background: linear-gradient(90deg, rgba(255,255,255,0), rgba(255,200,160,.95), rgba(255,130,60,.8));
            box-shadow: 0 0 10px rgba(255, 130, 60, .45), 0 0 20px rgba(120, 170, 255, .25);
            opacity: 0;
            transform-origin: center;
            pointer-events: none;
        }
        html:not(.dark) .sidebar-texture {
            opacity: .24;
            background-image:
                repeating-linear-gradient(
                    to right,
                    rgba(20,40,90,.08) 0,
                    rgba(20,40,90,.08) 1px,
                    transparent 1px,
                    transparent 24px
                ),
                repeating-linear-gradient(
                    to bottom,
                    rgba(20,40,90,.08) 0,
                    rgba(20,40,90,.08) 1px,
                    transparent 1px,
                    transparent 24px
                ),
                repeating-linear-gradient(
                    to right,
                    rgba(255,102,0,.2) 0,
                    rgba(255,102,0,.2) 1px,
                    transparent 1px,
                    transparent 120px
                ),
                repeating-linear-gradient(
                    to bottom,
                    rgba(255,102,0,.2) 0,
                    rgba(255,102,0,.2) 1px,
                    transparent 1px,
                    transparent 120px
                );
        }
        .menu-item {
            display: flex;
            align-items: center;
            gap: .6rem;
            padding: .58rem .75rem;
            border-radius: .75rem;
            border: 1px solid transparent;
            color: var(--brand-text);
            background: rgba(13, 27, 55, .4);
        }
        html:not(.dark) .menu-item {
            background: #f0f4fd;
            color: #24365b;
        }
        .menu-item:hover {
            transform: translateX(3px);
            border-color: rgba(255, 102, 0, .4);
            box-shadow: 0 0 20px rgba(255, 102, 0, .15);
            background: rgba(13, 27, 55, .75);
        }
        html:not(.dark) .menu-item:hover {
            background: #fff5ee;
            box-shadow: 0 0 0 1px rgba(255, 102, 0, .24), 0 7px 20px rgba(255, 102, 0, .12);
        }
        .menu-item.active {
            border-color: rgba(255, 102, 0, .55);
            box-shadow: 0 0 24px rgba(255, 102, 0, .2);
            background: linear-gradient(90deg, rgba(255, 102, 0, .2), rgba(255, 138, 61, .1));
        }
        .menu-icon {
            width: 1.55rem;
            height: 1.55rem;
            border-radius: .45rem;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: .72rem;
            border: 1px solid rgba(255, 102, 0, .28);
            background: rgba(255, 102, 0, .12);
            color: #ffb47f;
        }
        .notify-btn {
            position: relative;
            width: 38px;
            height: 38px;
            border-radius: 999px;
            border: 1px solid rgba(255, 102, 0, .45);
            background: rgba(8, 20, 45, .55);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 0 16px rgba(255, 102, 0, .14);
        }
        .notify-btn:hover { transform: translateY(-1px); box-shadow: 0 0 22px rgba(255, 102, 0, .22); }
        .audio-btn.active {
            border-color: rgba(255, 102, 0, .75) !important;
            box-shadow: 0 0 18px rgba(255, 102, 0, .24);
        }
        .notify-dot {
            position: absolute;
            top: -2px;
            right: -2px;
            min-width: 18px;
            height: 18px;
            border-radius: 999px;
            background: linear-gradient(90deg, #ff6600, #ff8a3d);
            color: #fff;
            font-size: 10px;
            font-weight: 700;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 0 4px;
            border: 1px solid rgba(255,255,255,.25);
        }
        .field-wrap {
            position: relative;
            width: 100%;
        }
        .field-label {
            position: absolute;
            left: .78rem;
            top: .72rem;
            font-size: .83rem;
            color: rgba(153, 167, 199, .9);
            pointer-events: none;
            transition: all .2s ease;
            background: transparent;
            padding: 0 .2rem;
            z-index: 1;
        }
        html:not(.dark) .field-label { color: rgba(80, 97, 130, .9); }
        .field-wrap.active .field-label {
            top: -0.42rem;
            font-size: .72rem;
            color: #ff7a26;
            background: var(--brand-blue-800);
        }
        .field-wrap::after {
            content: "";
            position: absolute;
            inset: 0;
            border-radius: .72rem;
            pointer-events: none;
            box-shadow: 0 0 0 0 rgba(255, 102, 0, 0);
            transition: box-shadow .2s ease;
        }
        .field-wrap.active::after {
            box-shadow: 0 0 0 3px rgba(255, 102, 0, .12), 0 0 24px rgba(255, 102, 0, .22);
        }
        input:not([type]), input[type="text"], input[type="email"], input[type="number"], input[type="date"], input[type="password"], input[type="url"], select, textarea {
            width: 100%;
            border-radius: .7rem;
            border: 1px solid var(--brand-border);
            background: rgba(5, 12, 30, .64);
            padding: .92rem .78rem .5rem;
            font-size: .92rem;
            line-height: 1.35;
            color: var(--brand-text);
            outline: none;
            box-shadow: inset 0 0 0 1px rgba(255, 255, 255, .02);
        }
        select {
            appearance: none;
            -webkit-appearance: none;
            -moz-appearance: none;
            min-height: 48px;
            padding: .72rem 2.45rem .72rem .82rem;
            background-image: linear-gradient(45deg, transparent 50%, #ff8a3d 50%), linear-gradient(135deg, #ff8a3d 50%, transparent 50%);
            background-position: calc(100% - 18px) calc(50% - 3px), calc(100% - 12px) calc(50% - 3px);
            background-size: 6px 6px, 6px 6px;
            background-repeat: no-repeat;
            cursor: pointer;
        }
        select option {
            background: #0b1b38;
            color: #dbe7ff;
        }
        html:not(.dark) select option {
            background: #ffffff;
            color: #1a2a49;
        }
        html:not(.dark) input:not([type]), html:not(.dark) input[type="text"], html:not(.dark) input[type="email"], html:not(.dark) input[type="number"], html:not(.dark) input[type="date"], html:not(.dark) input[type="password"], html:not(.dark) input[type="url"], html:not(.dark) select, html:not(.dark) textarea {
            background: #f8fbff;
            color: #1a2a49;
        }
        input:focus, select:focus, textarea:focus {
            border-color: rgba(255, 102, 0, .66);
            box-shadow: 0 0 0 0 rgba(255, 102, 0, 0);
        }
        input::placeholder, textarea::placeholder { color: rgba(153, 167, 199, .9); }
        html:not(.dark) input::placeholder, html:not(.dark) textarea::placeholder { color: rgba(77, 94, 128, .75); }
        label { font-size: .83rem; opacity: .92; margin-bottom: .35rem; display: inline-block; }
        textarea { min-height: 110px; }
        button, .btn {
            border-radius: .62rem;
            border: 1px solid transparent;
            padding: .48rem .88rem !important;
            font-size: .84rem;
            font-weight: 600;
            line-height: 1.1;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: auto;
        }
        .btn-primary {
            color: #fff;
            background: linear-gradient(90deg, #ff6600, #ff8a3d);
            box-shadow: 0 8px 20px rgba(255, 102, 0, .22);
        }
        .btn-primary:hover { transform: translateY(-1px); box-shadow: 0 12px 22px rgba(255, 102, 0, .28); }
        .btn-secondary {
            border-color: rgba(255, 102, 0, .35);
            background: rgba(8, 20, 45, .55);
        }
        .btn-secondary:hover { border-color: rgba(255, 102, 0, .65); box-shadow: 0 0 18px rgba(255, 102, 0, .17); }
        html:not(.dark) .btn-secondary {
            background: linear-gradient(90deg, #ff6600, #ff8a3d);
            color: #fff;
            border-color: rgba(255, 102, 0, .7);
            box-shadow: 0 8px 18px rgba(255, 102, 0, .2);
        }
        html:not(.dark) .btn-secondary:hover {
            filter: brightness(1.03);
            box-shadow: 0 10px 22px rgba(255, 102, 0, .28);
        }
        .form-submit {
            justify-self: start;
            margin-top: .2rem;
            min-width: 158px;
        }
        table tr:hover td { background: rgba(255, 102, 0, .06); }
        .dropzone {
            border: 1px dashed rgba(255, 102, 0, .45);
            background: rgba(255, 102, 0, .07);
            border-radius: .78rem;
            min-height: 132px;
            padding: 1rem;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: .6rem;
            cursor: pointer;
            text-align: center;
            flex-direction: column;
        }
        .dropzone:hover, .dropzone.dragover {
            border-color: rgba(255, 102, 0, .8);
            background: rgba(255, 102, 0, .13);
            box-shadow: 0 0 22px rgba(255, 102, 0, .19);
        }
        .dropzone .hint { font-size: .82rem; opacity: .88; }
        .dropzone .dz-title { font-size: 1rem; font-weight: 700; }
        .option-pills {
            display: flex;
            flex-wrap: wrap;
            gap: .5rem;
        }
        .option-pills input[type="radio"] {
            position: absolute;
            opacity: 0;
            pointer-events: none;
        }
        .option-pills label {
            margin: 0;
            border: 1px solid rgba(255, 102, 0, .32);
            border-radius: 999px;
            padding: .42rem .78rem;
            font-size: .82rem;
            background: rgba(8, 20, 45, .45);
            cursor: pointer;
            user-select: none;
        }
        .option-pills label:hover {
            border-color: rgba(255, 102, 0, .62);
            box-shadow: 0 0 14px rgba(255, 102, 0, .16);
        }
        .option-pills input[type="radio"]:checked + label {
            color: #fff;
            border-color: rgba(255, 102, 0, .72);
            background: linear-gradient(90deg, #ff6600, #ff8a3d);
            box-shadow: 0 7px 16px rgba(255, 102, 0, .24);
        }
        .dt-container .dt-search input, .dt-container .dt-length select {
            border: 1px solid var(--brand-border) !important;
            border-radius: .6rem !important;
            background: rgba(8, 20, 45, .45) !important;
            color: var(--brand-text) !important;
            padding: .35rem .55rem !important;
        }
        .dt-container .dt-layout-row { margin-bottom: .5rem; }
        .dt-container .dt-paging .dt-paging-button {
            border: 1px solid rgba(255, 102, 0, .28) !important;
            border-radius: .45rem !important;
            color: var(--brand-text) !important;
            background: rgba(8, 20, 45, .45) !important;
        }
        .dt-container .dt-paging .dt-paging-button.current {
            background: linear-gradient(90deg, #ff6600, #ff8a3d) !important;
            color: #fff !important;
            border-color: rgba(255, 102, 0, .72) !important;
        }
    </style>
</head>
<body class="bg-slate-950 text-slate-100 min-h-screen">
<div class="min-h-screen flex items-start">
    <aside class="w-72 bg-slate-900 border-r border-cyan-500/20 p-4 panel sticky top-0 h-screen overflow-y-auto overflow-x-hidden">
        <div class="sidebar-texture"></div>
        <div class="sidebar-bubbles">
            <span class="b1"></span>
            <span class="b2"></span>
            <span class="b3"></span>
            <span class="b4"></span>
            <span class="b5"></span>
            <span class="b6"></span>
            <span class="b7"></span>
            <span class="b8"></span>
            <span class="b9"></span>
            <span class="b10"></span>
            <span class="b11"></span>
            <span class="b12"></span>
            <span class="b13"></span>
            <span class="b14"></span>
            <span class="b15"></span>
        </div>
        <div class="relative z-10 flex items-center gap-3 mb-5">
            <img src="data:image/png;base64,{{ base64_encode(file_get_contents(resource_path('images/logo.png'))) }}" alt="Logo Dark" class="h-10 w-auto rounded logo-dark">
            <img src="data:image/png;base64,{{ base64_encode(file_get_contents(resource_path('images/logo-light.png'))) }}" alt="Logo Light" class="h-10 w-auto rounded logo-light hidden">
            <div>
                <h1 class="text-lg font-bold text-cyan-400 leading-tight">HilDes Admin</h1>
                <p class="text-xs text-slate-400">Control Center</p>
            </div>
        </div>
        <nav class="relative z-10 space-y-2 text-sm">
            <a href="{{ route('admin.dashboard') }}" class="menu-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}"><span class="menu-icon">D</span> Dashboard</a>
            <a href="{{ route('admin.home-hero.index') }}" class="menu-item {{ request()->routeIs('admin.home-hero.*') ? 'active' : '' }}"><span class="menu-icon">H</span> Home hero</a>
            <a href="{{ route('admin.contact-settings.index') }}" class="menu-item {{ request()->routeIs('admin.contact-settings.*') ? 'active' : '' }}"><span class="menu-icon">C</span> Contact Settings</a>
            <a href="{{ route('admin.services.index') }}" class="menu-item {{ request()->routeIs('admin.services.*') ? 'active' : '' }}"><span class="menu-icon">S</span> Services</a>
            <a href="{{ route('admin.case-studies.index') }}" class="menu-item {{ request()->routeIs('admin.case-studies.*') ? 'active' : '' }}"><span class="menu-icon">CS</span> Case Studies</a>
            <a href="{{ route('admin.clients.index') }}" class="menu-item {{ request()->routeIs('admin.clients.*') ? 'active' : '' }}"><span class="menu-icon">CL</span> Clients</a>
            <a href="{{ route('admin.testimonials.index') }}" class="menu-item {{ request()->routeIs('admin.testimonials.*') ? 'active' : '' }}"><span class="menu-icon">T</span> Testimonials</a>
            <a href="{{ route('admin.cms-pages.index') }}" class="menu-item {{ request()->routeIs('admin.cms-pages.*') ? 'active' : '' }}"><span class="menu-icon">CM</span> CMS Pages</a>
            <a href="{{ route('admin.jobs.index') }}" class="menu-item {{ request()->routeIs('admin.jobs.*') ? 'active' : '' }}"><span class="menu-icon">J</span> Careers / Jobs</a>
            <a href="{{ route('admin.applications.index') }}" class="menu-item {{ request()->routeIs('admin.applications.*') ? 'active' : '' }}"><span class="menu-icon">A</span> Applications</a>
            <a href="{{ route('admin.lead-submissions.index') }}" class="menu-item {{ request()->routeIs('admin.lead-submissions.*') ? 'active' : '' }}"><span class="menu-icon">L</span> Lead Forms</a>
            <a href="{{ route('admin.newsletter-subscriptions.index') }}" class="menu-item {{ request()->routeIs('admin.newsletter-subscriptions.*') ? 'active' : '' }}"><span class="menu-icon">N</span> Newsletter</a>
            <a href="{{ route('admin.users.index') }}" class="menu-item {{ request()->routeIs('admin.users.*') ? 'active' : '' }}"><span class="menu-icon">U</span> Users</a>
            <a href="{{ route('admin.profile.edit') }}" class="menu-item {{ request()->routeIs('admin.profile.*') ? 'active' : '' }}"><span class="menu-icon">P</span> My Profile</a>
        </nav>
    </aside>
    <main class="flex-1 p-6">
        <header class="flex justify-between items-center mb-6">
            <div>
                <p class="text-slate-400 text-sm">Information Technology Services</p>
                <h2 class="text-2xl font-semibold">{{ $title }}</h2>
            </div>
            @php($unreadNotifications = \Illuminate\Notifications\DatabaseNotification::whereNull('read_at')->count())
            <div class="flex gap-3 items-center">
                <a href="{{ route('admin.notifications.index') }}" class="notify-btn" title="Notifications">
                    <span style="font-size: 17px;">&#128276;</span>
                    @if($unreadNotifications > 0)
                        <span class="notify-dot">{{ $unreadNotifications > 99 ? '99+' : $unreadNotifications }}</span>
                    @endif
                </a>
                <button id="spaceAudioToggle" class="btn btn-secondary audio-btn" type="button" title="Toggle Deep Space Music">Space Audio</button>
                <button id="themeToggle" class="btn btn-secondary">Dark / Light</button>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="btn btn-secondary">Logout</button>
                </form>
            </div>
        </header>

        @if(session('success'))
            <div class="mb-4 rounded border p-3 panel" style="border-color: rgba(255, 102, 0, .28); background: rgba(255, 102, 0, .09);">{{ session('success') }}</div>
        @endif
        @if($errors->any())
            <div class="mb-4 rounded border p-3 panel" style="border-color: rgba(255, 102, 0, .4); background: rgba(255, 102, 0, .08);">{{ $errors->first() }}</div>
        @endif

        {{ $slot }}
    </main>
</div>
<div class="space-fleet" id="spaceFleet"></div>
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.datatables.net/2.0.8/js/dataTables.min.js"></script>
<script>
    const key = 'hildes-theme';
    const html = document.documentElement;
    if (localStorage.getItem(key) === 'light') html.classList.remove('dark');
    const syncLogos = () => {
        document.querySelectorAll('.logo-dark').forEach(el => el.classList.toggle('hidden', !html.classList.contains('dark')));
        document.querySelectorAll('.logo-light').forEach(el => el.classList.toggle('hidden', html.classList.contains('dark')));
    };
    syncLogos();
    document.getElementById('themeToggle').addEventListener('click', () => {
        html.classList.toggle('dark');
        localStorage.setItem(key, html.classList.contains('dark') ? 'dark' : 'light');
        syncLogos();
    });

    document.querySelectorAll('input[type="file"]').forEach((input, idx) => {
        if (input.dataset.enhanced === '1') return;
        input.dataset.enhanced = '1';
        input.classList.add('hidden');
        const wrapper = document.createElement('label');
        wrapper.className = 'dropzone';
        wrapper.setAttribute('for', input.id || `file_${idx}`);
        if (!input.id) input.id = `file_${idx}`;
        wrapper.innerHTML = `
            <div class="dz-title">Drag & drop file here</div>
            <div class="hint">or click to browse</div>
            <span class="btn btn-secondary">Browse File</span>
        `;
        input.parentNode.insertBefore(wrapper, input);
        wrapper.appendChild(input);
        const setName = () => {
            const fileName = input.files?.[0]?.name;
            const hint = wrapper.querySelector('.hint');
            if (fileName) hint.textContent = fileName;
        };
        ['dragenter', 'dragover'].forEach(evt => wrapper.addEventListener(evt, (e) => {
            e.preventDefault();
            wrapper.classList.add('dragover');
        }));
        ['dragleave', 'drop'].forEach(evt => wrapper.addEventListener(evt, (e) => {
            e.preventDefault();
            wrapper.classList.remove('dragover');
        }));
        wrapper.addEventListener('drop', (e) => {
            if (e.dataTransfer?.files?.length) {
                input.files = e.dataTransfer.files;
                setName();
                input.dispatchEvent(new Event('change', { bubbles: true }));
            }
        });
        input.addEventListener('change', setName);
    });

    document.querySelectorAll('input, select, textarea').forEach((el) => {
        if (el.type === 'hidden' || el.type === 'file' || el.type === 'checkbox' || el.dataset.floating === '0') return;
        if (el.closest('.field-wrap')) return;

        const placeholder = el.getAttribute('placeholder');
        if (!placeholder) return;

        const wrap = document.createElement('div');
        wrap.className = 'field-wrap';
        if (el.className.includes('md:col-span-2')) {
            wrap.classList.add('md:col-span-2');
            el.className = el.className.replace('md:col-span-2', '').trim();
        }

        const label = document.createElement('label');
        label.className = 'field-label';
        label.textContent = placeholder;

        el.parentNode.insertBefore(wrap, el);
        wrap.appendChild(el);
        wrap.appendChild(label);
        el.removeAttribute('placeholder');

        const sync = () => {
            if (document.activeElement === el || String(el.value || '').length > 0) wrap.classList.add('active');
            else wrap.classList.remove('active');
        };
        el.addEventListener('focus', sync);
        el.addEventListener('blur', sync);
        el.addEventListener('input', sync);
        el.addEventListener('change', sync);
        sync();
    });

    if (typeof window.DataTable !== 'undefined') {
        document.querySelectorAll('table.data-table').forEach((table) => {
            if (table.dataset.dtReady === '1') return;
            table.dataset.dtReady = '1';
            new DataTable(table, {
                pageLength: 10,
                lengthMenu: [10, 25, 50, 100],
                order: [],
                language: {
                    search: 'Search:',
                    lengthMenu: 'Show _MENU_',
                },
            });
        });
    }

    const spaceImagePool = @json($spaceImagePool);
    const fleet = document.getElementById('spaceFleet');
    const orbiters = [];
    if (fleet && spaceImagePool.length > 0) {
        const layerRect = () => fleet.getBoundingClientRect();
        const count = Math.min(11, Math.max(8, spaceImagePool.length));
        const hugeIndices = new Set([]);
        const placed = [];

        const randomFrom = (arr) => arr[Math.floor(Math.random() * arr.length)];
        for (let i = 0; i < count; i++) {
            const item = document.createElement('div');
            item.className = 'cosmic-item';
            const img = document.createElement('img');
            img.src = randomFrom(spaceImagePool);
            img.alt = 'space element';
            item.appendChild(img);
            fleet.appendChild(item);

            const r = layerRect();
            const huge = hugeIndices.has(i);
            const size = huge ? (110 + Math.random() * 20) : (42 + Math.random() * 44);

            let cx = (Math.random() * 0.9 + 0.05) * r.width;
            let cy = (Math.random() * 0.88 + 0.06) * r.height;
            let tries = 0;
            while (tries < 180) {
                const farEnough = placed.every((p) => {
                    const dx = p.cx - cx;
                    const dy = p.cy - cy;
                    const minDist = (p.size + size) * 0.62 + 28;
                    return (dx * dx + dy * dy) > (minDist * minDist);
                });
                if (farEnough) break;
                cx = (Math.random() * 0.9 + 0.05) * r.width;
                cy = (Math.random() * 0.88 + 0.06) * r.height;
                tries++;
            }

            const rx = 4 + Math.random() * (huge ? 8 : 14);
            const ry = 3 + Math.random() * (huge ? 7 : 12);
            const direction = Math.random() * Math.PI * 2;
            const speed = 0.004 + Math.random() * 0.014;

            orbiters.push({
                el: item,
                angle: Math.random() * Math.PI * 2,
                baseSpeed: 0.0001 + Math.random() * 0.00018,
                spin: (Math.random() * 0.012 + 0.003) * (Math.random() > 0.5 ? 1 : -1),
                size,
                rx,
                ry,
                x: cx,
                y: cy,
                vx: Math.cos(direction) * speed,
                vy: Math.sin(direction) * speed,
                rot: Math.random() * 360,
            });
            placed.push({ cx, cy, size });
        }

        let lastY = window.scrollY || 0;
        let boost = 0;
        window.addEventListener('scroll', () => {
            const y = window.scrollY || 0;
            boost = Math.min(1.4, boost + Math.abs(y - lastY) / 260);
            lastY = y;
        }, { passive: true });

        let lastTs = performance.now();
        const tick = (ts) => {
            const dt = ts - lastTs;
            lastTs = ts;
            boost *= 0.965;
            const speedFactor = 1 + boost;
            const r = layerRect();
            orbiters.forEach((o) => {
                // Very slow screen-wide drift with wrap-around.
                o.x += o.vx * dt * speedFactor;
                o.y += o.vy * dt * speedFactor;
                const margin = o.size * 0.8;
                if (o.x < -margin) o.x = r.width + margin;
                if (o.x > r.width + margin) o.x = -margin;
                if (o.y < -margin) o.y = r.height + margin;
                if (o.y > r.height + margin) o.y = -margin;
                o.angle += o.baseSpeed * dt * (0.55 + speedFactor * 0.45);
                o.rot += o.spin * dt;
                const x = o.x + Math.cos(o.angle) * o.rx;
                const y = o.y + Math.sin(o.angle) * o.ry * 0.72;
                o.el.style.width = `${o.size}px`;
                o.el.style.height = `${o.size}px`;
                o.el.style.left = `${x - o.size / 2}px`;
                o.el.style.top = `${y - o.size / 2}px`;
                o.el.style.transform = `rotate(${o.rot}deg)`;
            });
            requestAnimationFrame(tick);
        };
        requestAnimationFrame(tick);

        let lastStarAngle = null;
        const launchStar = () => {
            const rect = layerRect();
            const cx = Math.random() * rect.width;
            const cy = Math.random() * rect.height;
            const dist = Math.hypot(rect.width, rect.height) * 0.72;
            let theta = Math.random() * Math.PI * 2;
            if (lastStarAngle !== null && Math.abs(theta - lastStarAngle) < 0.42) {
                theta = (theta + 0.65 + Math.random() * 0.9) % (Math.PI * 2);
            }
            lastStarAngle = theta;
            const sx = cx - Math.cos(theta) * dist;
            const sy = cy - Math.sin(theta) * dist;
            const dx = cx + Math.cos(theta) * dist;
            const dy = cy + Math.sin(theta) * dist;
            const angle = Math.atan2(dy - sy, dx - sx) * 180 / Math.PI;

            const star = document.createElement('div');
            star.className = 'shooting-star';
            fleet.appendChild(star);

            star.style.transition = 'none';
            star.style.opacity = '0';
            star.style.left = `${sx}px`;
            star.style.top = `${sy}px`;
            star.style.transform = `translate(0,0) rotate(${angle}deg)`;
            requestAnimationFrame(() => {
                star.style.transition = 'transform 2000ms ease-out, opacity 420ms ease-out';
                star.style.opacity = '0.85';
                star.style.transform = `translate(${dx - sx}px, ${dy - sy}px) rotate(${angle}deg)`;
            });
            setTimeout(() => {
                star.style.opacity = '0';
                setTimeout(() => star.remove(), 450);
            }, 2100);
        };

        // Start immediately and then fire every 2 seconds.
        launchStar();
        setInterval(launchStar, 2000);
    }

    // Deep-space ambient audio (continuous). Requires user interaction on most browsers.
    let audioCtx = null;
    let masterGain = null;
    let audioReady = false;
    let audioEnabled = false;
    const audioBtn = document.getElementById('spaceAudioToggle');

    const setupDeepSpaceAudio = async () => {
        if (audioReady) return;
        audioCtx = new (window.AudioContext || window.webkitAudioContext)();
        masterGain = audioCtx.createGain();
        masterGain.gain.value = 0.0;
        masterGain.connect(audioCtx.destination);

        const makeDrone = (freq, gainValue, detune = 0) => {
            const osc = audioCtx.createOscillator();
            const lp = audioCtx.createBiquadFilter();
            const g = audioCtx.createGain();
            osc.type = 'sine';
            osc.frequency.value = freq;
            osc.detune.value = detune;
            lp.type = 'lowpass';
            lp.frequency.value = 420;
            g.gain.value = gainValue;
            osc.connect(lp);
            lp.connect(g);
            g.connect(masterGain);
            osc.start();
            return { osc, g };
        };

        makeDrone(43, 0.32);
        makeDrone(64, 0.22, -7);
        makeDrone(96, 0.11, 5);

        const lfo = audioCtx.createOscillator();
        const lfoGain = audioCtx.createGain();
        lfo.type = 'sine';
        lfo.frequency.value = 0.07;
        lfoGain.gain.value = 0.014;
        lfo.connect(lfoGain);
        lfoGain.connect(masterGain.gain);
        lfo.start();

        audioReady = true;
    };

    const toggleSpaceAudio = async () => {
        await setupDeepSpaceAudio();
        if (audioCtx.state === 'suspended') await audioCtx.resume();

        audioEnabled = !audioEnabled;
        masterGain.gain.cancelScheduledValues(audioCtx.currentTime);
        masterGain.gain.setTargetAtTime(audioEnabled ? 0.052 : 0.0, audioCtx.currentTime, 0.45);
        audioBtn.classList.toggle('active', audioEnabled);
        audioBtn.textContent = audioEnabled ? 'Audio On' : 'Space Audio';
    };

    if (audioBtn) {
        audioBtn.addEventListener('click', toggleSpaceAudio);
    }
</script>
</body>
</html>
