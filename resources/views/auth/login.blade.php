<x-guest-layout>
    <style>
    @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&display=swap');

    [x-cloak] { display: none !important; }

    :root {
        --brand-red: #c81d25;
        --brand-red-dark: #8f1116;
        --brand-gold: #e8b44c;
    }

    * { box-sizing: border-box; }
    html, body { height: 100%; overflow-x: hidden; }
    .font-body { font-family: 'Plus Jakarta Sans', sans-serif; }

    /* ============ FONDO DIAGONAL ============ */
    .split-bg {
        position: relative;
        min-height: 100vh;
        background: #f5f2ee;
        overflow: hidden;
    }

    /* ============ IMAGEN DE FONDO GENERAL DESVANECIDA ============ */
    .page-watermark {
        position: absolute;
        inset: 0;
        width: 100%;
        height: 100%;
        object-fit: cover;
        opacity: 0.65;
        mix-blend-mode: normal;
        pointer-events: none;
        user-select: none;
        z-index: 1;
    }

    .split-red {
        position: absolute;
        inset: 0;
        background: linear-gradient(135deg, var(--brand-red) 0%, var(--brand-red-dark) 100%);
        clip-path: polygon(40% 0%, 100% 0%, 100% 100%, 62% 100%);
        z-index: 2;
        overflow: hidden;
    }

    /* ============ PATRÓN CON COLOR ORIGINAL Y BRILLO ============ */
    .red-pattern {
        position: absolute;
        inset: 0;
        background-image: url('{{ asset("images/pattern.jpg") }}');
        background-repeat: repeat;
        background-size: 380px;
        opacity: 0.45;
        mix-blend-mode: screen;
        pointer-events: none;
        z-index: 1;
    }

    .red-speckle {
        position: absolute;
        border-radius: 50%;
        background: rgba(0,0,0,0.12);
        z-index: 2;
    }

    /* ============ LOGO ============ */
    .brand-mark {
        position: absolute;
        top: 32px;
        right: 40px;
        z-index: 20;
        display: flex;
        align-items: center;
        gap: 10px;
    }
    .brand-mark img {
        width: 44px;
        height: 44px;
        border-radius: 12px;
        box-shadow: 0 6px 18px rgba(0,0,0,0.25);
    }
    .brand-mark span {
        color: white;
        font-weight: 900;
        font-size: 15px;
        letter-spacing: 0.03em;
        text-shadow: 0 2px 6px rgba(0,0,0,0.3);
    }

    /* ============ PLATO DE MADERA + PIZZA GIRANDO ============ */
    .pizza-position {
        position: absolute;
        top: 50%;
        left: 23%;
        transform: translate(-50%, -50%);
        width: min(74vw, 960px);
        aspect-ratio: 873 / 1049;
        z-index: 5;
    }

    .plate-photo {
        position: absolute;
        inset: 0;
        width: 100%;
        height: 100%;
        object-fit: contain;
        mix-blend-mode: multiply;
        filter: drop-shadow(0 35px 45px rgba(0,0,0,0.32));
    }

    .pizza-frame {
        position: absolute;
        left: 49.6%;
        top: 53.4%;
        width: 84%;
        aspect-ratio: 1 / 1;
        transform: translate(-50%, -50%);
        border-radius: 50%;
        overflow: hidden;
    }

    .pizza-spin {
        position: absolute;
        inset: 0;
        animation: spinPizza 45s linear infinite;
        will-change: transform;
    }

    .pizza-layer {
        position: absolute;
        inset: 0;
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
        opacity: 0;
        transition: opacity 1.1s ease;
    }
    .pizza-layer.active { opacity: 1; }

    @keyframes spinPizza {
        from { transform: rotate(0deg); }
        to   { transform: rotate(360deg); }
    }

    @media (prefers-reduced-motion: reduce) {
        .pizza-spin { animation: none; }
    }

    /* ============ TARJETA FLOTANTE ============ */
    .login-stage {
        position: relative;
        z-index: 10;
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: flex-end;
        padding: 120px 7% 40px;
    }

    .login-card {
        width: 100%;
        max-width: 410px;
        background: #ffffff;
        border-radius: 32px;
        box-shadow: 0 25px 60px -15px rgba(0, 0, 0, 0.3);
        border: 1px solid rgba(255, 255, 255, 0.8);
        padding: 46px 42px;
    }

    .back-link {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        color: #64748b;
        font-weight: 600;
        font-size: 13px;
        text-decoration: none;
        transition: color 0.2s ease;
    }
    .back-link:hover { color: var(--brand-red); }
    .back-link i { transition: transform 0.2s ease; }
    .back-link:hover i { transform: translateX(-3px); }

    .field-input {
        transition: all 0.2s ease;
    }
    .field-input:focus {
        border-color: var(--brand-red);
        background-color: #ffffff;
        box-shadow: 0 0 0 4px rgba(200, 29, 37, 0.08);
    }

    .btn-primary-red {
        background: var(--brand-red);
        transition: all 0.2s ease;
    }
    .btn-primary-red:hover:not(:disabled) {
        background: var(--brand-red-dark);
        transform: translateY(-1px);
        box-shadow: 0 10px 22px -6px rgba(200, 29, 37, 0.45);
    }
    .btn-primary-red:active:not(:disabled) { transform: scale(0.98); }
    .btn-primary-red:disabled { opacity: 0.6; cursor: not-allowed; }

    @keyframes shake {
        10%, 90% { transform: translateX(-1px); }
        20%, 80% { transform: translateX(2px); }
        30%, 50%, 70% { transform: translateX(-4px); }
        40%, 60% { transform: translateX(4px); }
    }
    .shake { animation: shake 0.5s cubic-bezier(.36,.07,.19,.97) both; }

    @keyframes fadeUp {
        from { opacity: 0; transform: translateY(16px); }
        to   { opacity: 1; transform: translateY(0); }
    }
    .fade-up { animation: fadeUp 0.7s cubic-bezier(.16,1,.3,1) both; }

    @media (prefers-reduced-motion: reduce) {
        *, *::before, *::after {
            animation-duration: 0.001ms !important;
            animation-iteration-count: 1 !important;
            transition-duration: 0.001ms !important;
        }
    }

    /* ================================================================
       RESPONSIVE
       ================================================================ */

    /* ---- LAPTOP CHICO / TABLET GRANDE (hasta 1200px) ---- */
    @media (max-width: 1200px) {
        .pizza-position {
            left: 18%;
            width: min(65vw, 700px);
        }
        .login-stage {
            padding: 100px 6% 40px;
        }
        .login-card {
            max-width: 380px;
            padding: 40px 34px;
        }
    }

    /* ---- TABLET / MÓVIL (hasta 900px) ---- */
    /* ---- MÓVIL (hasta 600px) ---- */
@media (max-width: 600px) {
    .brand-mark {
        top: 14px;
        right: 14px;
        gap: 6px;
    }
    .brand-mark img {
        width: 32px;
        height: 32px;
    }
    .brand-mark span {
        font-size: 11px;
    }

    .login-card {
        padding: 30px 22px;
        border-radius: 22px;
    }
}

/* ---- MÓVIL PEQUEÑO (hasta 380px) ---- */
@media (max-width: 380px) {
    .login-card {
        padding: 26px 18px;
    }
}

    /* ---- MÓVIL (hasta 600px) ---- */
    @media (max-width: 600px) {
        .brand-mark {
            top: 14px;
            right: 14px;
            gap: 6px;
        }
        .brand-mark img {
            width: 32px;
            height: 32px;
        }
        .brand-mark span {
            font-size: 11px;
        }

        .pizza-position {
            width: min(38vw, 170px);
            margin: 64px auto 0;
        }

        .login-card {
            padding: 30px 22px;
            border-radius: 22px;
        }
    }

    /* ---- MÓVIL PEQUEÑO (hasta 380px) ---- */
    @media (max-width: 380px) {
        .pizza-position {
            width: min(34vw, 140px);
            margin: 56px auto 0;
        }
        .login-card {
            padding: 26px 18px;
        }
    }
</style>

    <div class="split-bg font-body">
        {{-- Imagen de fondo general con desvanecimiento --}}
        <img src="{{ asset('images/slice.jpg') }}" alt="" class="page-watermark">

        <div class="split-red">
            {{-- Patrón con color y brillo realzado sobre el fondo rojo --}}
            <div class="red-pattern"></div>

            <div class="red-speckle" style="width:60px; height:60px; top:15%; left:20%;"></div>
            <div class="red-speckle" style="width:30px; height:30px; top:35%; left:55%;"></div>
            <div class="red-speckle" style="width:90px; height:90px; top:60%; left:35%;"></div>
            <div class="red-speckle" style="width:22px; height:22px; top:75%; left:70%;"></div>
            <div class="red-speckle" style="width:45px; height:45px; top:10%; left:78%;"></div>
        </div>

        <div class="brand-mark">
            <img src="{{ asset('storage/' . ($empresa->logo_path ?? '')) }}" alt="{{ $empresa->company_name ?? 'Pizzería Zuñiga' }}" onerror="this.style.display='none'">
            <span>{{ strtoupper($empresa->company_name ?? 'Pizzería Zuñiga') }}</span>
        </div>

        {{-- ============ PLATO DE MADERA + PIZZA GIRANDO ============ --}}
        @php
            $pizzaImages = [
                'images/pizzas/pizza-3.png',
            ];
        @endphp
        <div class="pizza-position">
            <img class="plate-photo" src="{{ asset('images/plates/plate-4.png') }}" alt="Plato de madera">
            <div class="pizza-frame">
                <div class="pizza-spin" id="pizzaCarousel">
                    @foreach ($pizzaImages as $i => $src)
                        <img
                            src="{{ asset($src) }}"
                            alt="Pizza artesanal"
                            class="pizza-layer {{ $i === 0 ? 'active' : '' }}"
                        >
                    @endforeach
                </div>
            </div>
        </div>

        {{-- ============ TARJETA DE LOGIN ============ --}}
        <div
            x-data="{ loading: false, showPassword: false, shakeIt: {{ $errors->any() ? 'true' : 'false' }} }"
            class="login-stage"
        >
            <div class="login-card fade-up" :class="{ 'shake': shakeIt }" @animationend="shakeIt = false">

                <a href="{{ url('/') }}" class="back-link">
                    <i class="fas fa-arrow-left text-xs"></i>
                    <span>Salir</span>
                </a>

                <div class="mt-6 mb-8">
                    <h1 class="text-2xl sm:text-3xl font-black text-slate-900 tracking-tight">Iniciar sesión</h1>
                    <p class="text-slate-500 text-sm mt-2">Ingresa tu correo y contraseña para continuar</p>
                </div>

                <x-auth-session-status class="mb-4" :status="session('status')" />

                <form method="POST" action="{{ route('login') }}" class="space-y-5" @submit="loading = true">
                    @csrf

                    <div>
                        <label for="email" class="block text-xs font-bold uppercase tracking-wide text-slate-500 mb-1.5">Correo</label>
                        <input
                            id="email"
                            class="field-input block w-full px-4 py-3.5 bg-slate-50/80 border border-slate-200 rounded-xl text-slate-800 placeholder:text-slate-400 outline-none"
                            type="email"
                            name="email"
                            value="{{ old('email') }}"
                            required
                            autofocus
                            placeholder="Ingresa tu usuario"
                        />
                        @error('email')
                            <p class="text-xs text-red-600 font-semibold mt-1.5">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="password" class="block text-xs font-bold uppercase tracking-wide text-slate-500 mb-1.5">Contraseña</label>
                        <div class="relative">
                            <input
                                :type="showPassword ? 'text' : 'password'"
                                id="password"
                                class="field-input block w-full px-4 py-3.5 pr-11 bg-slate-50/80 border border-slate-200 rounded-xl text-slate-800 placeholder:text-slate-400 outline-none"
                                name="password"
                                placeholder="Ingresa tu contraseña"
                                required
                            />
                            <button
                                type="button"
                                @click="showPassword = !showPassword"
                                class="absolute inset-y-0 right-0 pr-4 flex items-center text-slate-400 hover:text-red-600 transition-colors"
                            >
                                <i :class="showPassword ? 'fa-eye-slash' : 'fa-eye'" class="fas text-sm"></i>
                            </button>
                        </div>
                        @error('password')
                            <p class="text-xs text-red-600 font-semibold mt-1.5">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex items-center justify-between pt-1">
                        <label for="remember_me" class="flex items-center cursor-pointer select-none">
                            <input id="remember_me" type="checkbox" class="rounded border-slate-300 text-red-600 focus:ring-red-500 w-4 h-4" name="remember">
                            <span class="ms-2 text-sm text-slate-500 font-medium">Recordarme</span>
                        </label>

                        @if (Route::has('password.request'))
                            <a class="text-xs font-bold text-red-600 hover:text-red-700 underline underline-offset-4" href="{{ route('password.request') }}">
                                Olvidé mi contraseña
                            </a>
                        @endif
                    </div>

                    <button
                        type="submit"
                        :disabled="loading"
                        class="btn-primary-red w-full flex justify-center items-center py-4 text-sm font-black rounded-xl text-white uppercase tracking-wider shadow-lg shadow-red-600/25 mt-2"
                    >
                        <template x-if="!loading">
                            <span>Entrar</span>
                        </template>
                        <template x-if="loading">
                            <span class="flex items-center">
                                <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-90" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                                </svg>
                                Verificando...
                            </span>
                        </template>
                    </button>
                </form>
            </div>
        </div>
    </div>

    <script>
        if (typeof window.Alpine === 'undefined') {
            var alpineScript = document.createElement('script');
            alpineScript.src = 'https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js';
            alpineScript.defer = true;
            document.head.appendChild(alpineScript);
        }

        (function () {
            var wrap = document.getElementById('pizzaCarousel');
            if (!wrap) return;
            var layers = wrap.querySelectorAll('.pizza-layer');
            if (layers.length < 2) return;

            var current = 0;
            setInterval(function () {
                layers[current].classList.remove('active');
                current = (current + 1) % layers.length;
                layers[current].classList.add('active');
            }, 8000);
        })();
    </script>
</x-guest-layout>