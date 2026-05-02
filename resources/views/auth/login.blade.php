<!DOCTYPE html>
<html lang="en" class="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Mona+Sans:ital,wght@0,200..900;1,200..900&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        :root {
            --brand-orange: #ff6600;
            --brand-orange-soft: #ff8a3d;
            --brand-blue-900: #070f24;
            --brand-blue-800: #0d1a36;
            --brand-border: rgba(255, 102, 0, 0.35);
            --brand-text: #dbe7ff;
        }
        * { box-sizing: border-box; }
        body {
            letter-spacing: .01em;
            background:
                radial-gradient(1000px 500px at 50% 110%, rgba(115, 175, 255, 0.1), transparent 62%),
                radial-gradient(680px 320px at 50% -10%, rgba(255, 138, 61, 0.08), transparent 72%),
                #02040b;
            color: var(--brand-text);
            font-family: "Mona Sans", "Segoe UI", sans-serif;
            font-optical-sizing: auto;
            font-variation-settings: "wdth" 100;
            overflow: hidden;
            position: relative;
        }
        h1, h2, h3, h4, .heading-text { letter-spacing: .06em; font-weight: 700; }
        h1, h2, h3 { text-shadow: 0 0 18px rgba(255,102,0,.16); }

        .space-vignette {
            position: fixed;
            inset: 0;
            pointer-events: none;
            z-index: 2;
            background:
                radial-gradient(circle at center, transparent 46%, rgba(2, 5, 15, .3) 73%, rgba(1, 3, 10, .7) 100%);
        }

        #warp-canvas {
            position: fixed;
            inset: 0;
            width: 100%;
            height: 100%;
            z-index: 1;
            pointer-events: none;
            opacity: .9;
        }
        .galaxy-layer {
            position: fixed;
            inset: 0;
            pointer-events: none;
            z-index: 2;
            overflow: hidden;
        }
        .galaxy {
            position: absolute;
            opacity: .18;
            filter: blur(.2px) drop-shadow(0 0 10px rgba(148, 196, 255, .35));
            animation: galaxyDrift linear infinite;
            transform-origin: center;
            will-change: transform;
        }
        .galaxy.g1 { width: 140px; left: 8%; top: 14%; animation-duration: 38s; }
        .galaxy.g2 { width: 200px; right: 10%; top: 22%; animation-duration: 45s; animation-direction: reverse; }
        .galaxy.g3 { width: 120px; left: 16%; bottom: 16%; animation-duration: 41s; }
        .galaxy.g4 { width: 170px; right: 18%; bottom: 20%; animation-duration: 52s; animation-direction: reverse; }
        .sun {
            position: absolute;
            width: 74px;
            height: 74px;
            border-radius: 50%;
            background:
                radial-gradient(circle at 33% 30%, rgba(255, 255, 232, .98) 0 16%, rgba(255, 236, 150, .95) 28%, rgba(255, 173, 62, .95) 46%, rgba(255, 103, 32, .9) 74%, rgba(255, 64, 24, .5) 100%);
            box-shadow:
                0 0 24px rgba(255, 186, 93, .55),
                0 0 58px rgba(255, 139, 55, .4),
                0 0 110px rgba(255, 108, 40, .3);
            opacity: .56;
            filter: blur(.1px) saturate(1);
            animation: sunDrift 30s ease-in-out infinite, sunShine 3.6s ease-in-out infinite;
            transform: translate3d(0, 0, 0);
            will-change: transform;
        }
        .sun::before {
            content: "";
            position: absolute;
            inset: -16px;
            border-radius: 50%;
            background:
                radial-gradient(circle, rgba(255, 196, 96, .55) 0%, rgba(255, 126, 43, .28) 50%, rgba(255, 94, 33, 0) 75%);
            filter: blur(2px);
            animation: coronaPulse 2.8s ease-in-out infinite;
        }
        .sun::after {
            content: "";
            position: absolute;
            inset: 0;
            border-radius: 50%;
            background:
                conic-gradient(
                    from 0deg,
                    rgba(255, 220, 120, .26),
                    rgba(255, 171, 74, .08),
                    rgba(255, 209, 110, .24),
                    rgba(255, 142, 52, .06),
                    rgba(255, 220, 120, .26)
                );
            mix-blend-mode: screen;
            animation: solarFlicker 1.8s linear infinite;
        }

        .login-shell {
            position: relative;
            z-index: 3;
            backdrop-filter: blur(10px);
            border-color: rgba(255, 161, 106, 0.45) !important;
            background:
                linear-gradient(180deg, rgba(16, 31, 67, 0.78), rgba(8, 20, 43, 0.82)),
                radial-gradient(120% 120% at 50% 0%, rgba(255, 141, 69, .12), transparent 55%);
            box-shadow:
                0 20px 70px rgba(4, 9, 23, .7),
                inset 0 0 0 1px rgba(255, 255, 255, .04),
                0 0 35px rgba(86, 129, 255, .18);
        }

        .space-input {
            border: 1px solid rgba(140, 171, 255, .24) !important;
            background: linear-gradient(180deg, rgba(13, 24, 50, .8), rgba(10, 18, 38, .85)) !important;
            color: #e8f1ff;
        }
        .space-input:focus {
            outline: none;
            border-color: rgba(255, 140, 58, .7) !important;
            box-shadow: 0 0 0 3px rgba(255, 131, 60, .15);
        }

        .space-login-btn {
            box-shadow: 0 10px 28px rgba(255, 118, 38, .25);
            transition: transform .2s ease, box-shadow .2s ease, filter .2s ease;
        }
        .space-login-btn:hover {
            transform: translateY(-1px);
            filter: brightness(1.05);
            box-shadow: 0 14px 30px rgba(255, 118, 38, .35);
        }
        @keyframes galaxyDrift {
            0% { transform: translate3d(0, 0, 0) rotate(0deg) scale(1); }
            50% { transform: translate3d(12px, -10px, 0) rotate(7deg) scale(1.06); }
            100% { transform: translate3d(0, 0, 0) rotate(0deg) scale(1); }
        }
        @keyframes sunDrift {
            0% { transform: translate3d(0, 0, 0) scale(1); }
            25% { transform: translate3d(20px, -10px, 0) scale(1.03); }
            50% { transform: translate3d(38px, 6px, 0) scale(1.06); }
            75% { transform: translate3d(16px, 20px, 0) scale(1.02); }
            100% { transform: translate3d(0, 0, 0) scale(1); }
        }
        @keyframes sunShine {
            0%, 100% {
                filter: brightness(1);
                box-shadow:
                    0 0 28px rgba(255, 193, 104, .72),
                    0 0 70px rgba(255, 148, 61, .6),
                    0 0 130px rgba(255, 118, 46, .45);
            }
            50% {
                filter: brightness(1.24);
                box-shadow:
                    0 0 38px rgba(255, 212, 122, .84),
                    0 0 86px rgba(255, 156, 68, .72),
                    0 0 170px rgba(255, 124, 50, .54);
            }
        }
        @keyframes coronaPulse {
            0%, 100% { transform: scale(1); opacity: .72; }
            50% { transform: scale(1.11); opacity: .95; }
        }
        @keyframes solarFlicker {
            0% { transform: rotate(0deg); opacity: .4; }
            50% { opacity: .72; }
            100% { transform: rotate(360deg); opacity: .4; }
        }

    </style>
</head>
<body class="bg-slate-950 min-h-screen text-slate-100 flex items-center justify-center p-6">
    <canvas id="warp-canvas" aria-hidden="true"></canvas>
    <div class="galaxy-layer" aria-hidden="true">
        <img class="galaxy g1" src="{{ asset('assets/images/about/shape/02.svg') }}" alt="">
        <img class="galaxy g2" src="{{ asset('assets/images/about/shape/02.svg') }}" alt="">
        <img class="galaxy g3" src="{{ asset('assets/images/about/shape/02.svg') }}" alt="">
        <img class="galaxy g4" src="{{ asset('assets/images/about/shape/02.svg') }}" alt="">
        <div class="sun" id="space-sun"></div>
    </div>
    <div class="space-vignette"></div>
    <form method="POST" action="{{ route('login.submit') }}" class="login-shell w-full max-w-md border rounded-2xl p-6 shadow-2xl">
        @csrf
        <div class="flex flex-col items-center mb-4">
            <img src="data:image/png;base64,{{ base64_encode(file_get_contents(resource_path('images/logo.png'))) }}" alt="Logo" class="h-14 w-auto mb-3">
            <h1 class="text-2xl font-bold mb-1 text-center" style="color: var(--brand-orange-soft);">Enter the Solar System</h1>
        </div>
        @if($errors->any())
            <p class="mb-4 text-rose-300">{{ $errors->first() }}</p>
        @endif
        <div class="mb-4">
            <input name="username" type="password" required value="{{ old('username') }}" class="space-input w-full p-2 rounded" placeholder="Username">
        </div>
        <div class="mb-4">
            <input name="password" type="password" required class="space-input w-full p-2 rounded" placeholder="Password">
        </div>
        <button class="space-login-btn w-full p-2 rounded font-semibold" style="background: linear-gradient(90deg, #ff6600, #ff8a3d);">Enter</button>
    </form>
    <script>
        (() => {
            const canvas = document.getElementById('warp-canvas');
            if (!canvas) return;

            const ctx = canvas.getContext('2d');
            if (!ctx) return;

            let w = 0;
            let h = 0;
            let cx = 0;
            let cy = 0;
            let stars = [];
            let streaks = [];
            const starSpeed = 70;
            const streakSpeed = 420;
            let starCount = 120;
            const maxStreaks = 16;
            let dpr = 1;
            let lastTs = performance.now();
            const starColors = [
                "rgba(214, 233, 255, 0.72)",
                "rgba(120, 187, 255, 0.75)",
                "rgba(255, 127, 73, 0.72)",
                "rgba(255, 90, 90, 0.68)",
                "rgba(255, 190, 90, 0.72)"
            ];

            const resize = () => {
                dpr = Math.min(window.devicePixelRatio || 1, 1.5);
                w = window.innerWidth;
                h = window.innerHeight;
                canvas.width = Math.floor(w * dpr);
                canvas.height = Math.floor(h * dpr);
                canvas.style.width = `${w}px`;
                canvas.style.height = `${h}px`;
                ctx.setTransform(dpr, 0, 0, dpr, 0, 0);
                cx = w / 2;
                cy = h / 2;
                starCount = Math.max(80, Math.min(140, Math.floor((w * h) / 14000)));
                stars = Array.from({ length: starCount }, () => ({
                    x: Math.random() * w,
                    y: Math.random() * h,
                    vx: (Math.random() - 0.5) * starSpeed,
                    vy: (Math.random() - 0.5) * starSpeed,
                    r: Math.random() * 1.4 + 0.4,
                    c: starColors[(Math.random() * starColors.length) | 0]
                }));
                streaks = [];
            };

            const randomEdgePoint = () => {
                const side = Math.floor(Math.random() * 4);
                if (side === 0) return { x: Math.random() * w, y: -30 };
                if (side === 1) return { x: w + 30, y: Math.random() * h };
                if (side === 2) return { x: Math.random() * w, y: h + 30 };
                return { x: -30, y: Math.random() * h };
            };

            const spawnStreak = () => {
                const start = randomEdgePoint();
                const angle = Math.random() * Math.PI * 2;
                const length = 30 + Math.random() * 60;
                streaks.push({
                    x: start.x,
                    y: start.y,
                    vx: Math.cos(angle) * (streakSpeed + Math.random() * 220),
                    vy: Math.sin(angle) * (streakSpeed + Math.random() * 220),
                    life: 0.25 + Math.random() * 0.45,
                    maxLife: 0.25 + Math.random() * 0.45,
                    len: length,
                    c: starColors[(Math.random() * starColors.length) | 0],
                });
            };

            const tick = (ts) => {
                const dt = Math.min(0.033, (ts - lastTs) / 1000);
                lastTs = ts;
                ctx.clearRect(0, 0, w, h);

                for (let i = 0; i < stars.length; i++) {
                    const s = stars[i];
                    s.x += s.vx * dt;
                    s.y += s.vy * dt;
                    if (s.x < 0) s.x += w;
                    if (s.x > w) s.x -= w;
                    if (s.y < 0) s.y += h;
                    if (s.y > h) s.y -= h;
                    ctx.fillStyle = s.c;
                    ctx.beginPath();
                    ctx.arc(s.x, s.y, s.r, 0, Math.PI * 2);
                    ctx.fill();
                }

                if (Math.random() < 0.06 && streaks.length < maxStreaks) {
                    spawnStreak();
                }

                for (let i = streaks.length - 1; i >= 0; i--) {
                    const t = streaks[i];
                    t.life -= dt;
                    t.x += t.vx * dt;
                    t.y += t.vy * dt;

                    const alpha = Math.max(0, t.life / t.maxLife) * 0.9;
                    const tx = t.x - (t.vx / 900) * t.len;
                    const ty = t.y - (t.vy / 900) * t.len;

                    const color = t.c.replace(/[\d.]+\)\s*$/, `${alpha})`);
                    ctx.strokeStyle = color;
                    ctx.lineWidth = 1.2;
                    ctx.beginPath();
                    ctx.moveTo(t.x, t.y);
                    ctx.lineTo(tx, ty);
                    ctx.stroke();

                    if (
                        t.life <= 0 ||
                        t.x < -80 || t.x > w + 80 ||
                        t.y < -80 || t.y > h + 80
                    ) {
                        streaks.splice(i, 1);
                    }
                }

                requestAnimationFrame(tick);
            };

            const sun = document.getElementById('space-sun');
            if (sun) {
                sun.style.left = `${6 + Math.random() * 78}%`;
                sun.style.top = `${6 + Math.random() * 74}%`;
            }

            resize();
            requestAnimationFrame((ts) => {
                lastTs = ts;
                requestAnimationFrame(tick);
            });
            window.addEventListener('resize', resize);
        })();
    </script>
</body>
</html>
