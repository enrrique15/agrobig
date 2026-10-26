<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    @php
    $storeName = \App\Models\StoreSetting::get('store_name', config('app.name', 'Agrobig'));
    $storeSlogan = \App\Models\StoreSetting::get('store_slogan', 'Tu aliado agropecuario de confianza');
    $storeEmail = \App\Models\StoreSetting::get('store_email', 'contacto@agrobig.com');
    $storePhone = \App\Models\StoreSetting::get('store_phone', '+591 70000000');
    $cleanPhone = preg_replace('/[^0-9]/', '', $storePhone);
    $loginUrl = Route::has('filament.admin.auth.login') ? route('filament.admin.auth.login') : url('/admin/login');
    @endphp

    <title>{{ $storeName }} | Próximamente - Tienda Virtual en Construcción</title>

    <meta name="description" content="Estamos construyendo la nueva tienda virtual de {{ $storeName }}. Muy pronto disponible con catálogo de insumos agrícolas, productos veterinarios y asesoría técnica.">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=Space+Grotesk:wght@500;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --primary: #059669;
            --primary-light: #10b981;
            --primary-dark: #047857;
            --accent: #f59e0b;
            --accent-glow: rgba(245, 158, 11, 0.25);
            --bg-dark: #090d0b;
            --bg-card: rgba(18, 26, 22, 0.75);
            --border-glass: rgba(255, 255, 255, 0.08);
            --border-glow: rgba(16, 185, 129, 0.25);
            --text-main: #f8fafc;
            --text-muted: #94a3b8;
            --text-sub: #cbd5e1;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Plus Jakarta Sans', system-ui, -apple-system, sans-serif;
            background-color: var(--bg-dark);
            color: var(--text-main);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            overflow-x: hidden;
            position: relative;
            background-image:
                radial-gradient(circle at 15% 15%, rgba(5, 150, 105, 0.18) 0%, transparent 45%),
                radial-gradient(circle at 85% 80%, rgba(16, 185, 129, 0.12) 0%, transparent 45%),
                radial-gradient(circle at 50% 50%, rgba(4, 120, 87, 0.08) 0%, transparent 60%);
            background-attachment: fixed;
        }

        /* Subtle grid overlay */
        body::before {
            content: '';
            position: fixed;
            inset: 0;
            background-size: 40px 40px;
            background-image:
                linear-gradient(to right, rgba(255, 255, 255, 0.02) 1px, transparent 1px),
                linear-gradient(to bottom, rgba(255, 255, 255, 0.02) 1px, transparent 1px);
            pointer-events: none;
            z-index: 1;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 1.5rem;
            width: 100%;
            position: relative;
            z-index: 2;
        }

        /* Top Navbar */
        .header {
            padding: 1.75rem 0;
            display: flex;
            align-items: center;
            justify-content: space-between;
            border-bottom: 1px solid var(--border-glass);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
        }

        .logo-wrap {
            display: flex;
            align-items: center;
            gap: 0.875rem;
            text-decoration: none;
            color: inherit;
        }

        .logo-icon {
            width: 44px;
            height: 44px;
            border-radius: 12px;
            background: linear-gradient(135deg, #059669, #10b981);
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 0 20px rgba(16, 185, 129, 0.35);
            border: 1px solid rgba(255, 255, 255, 0.2);
            transition: transform 0.3s ease;
        }

        .logo-wrap:hover .logo-icon {
            transform: scale(1.05) rotate(3deg);
        }

        .logo-icon svg {
            width: 24px;
            height: 24px;
            fill: none;
            stroke: #ffffff;
            stroke-width: 2.2;
            stroke-linecap: round;
            stroke-linejoin: round;
        }

        .brand-text h1 {
            font-family: 'Space Grotesk', sans-serif;
            font-size: 1.5rem;
            font-weight: 700;
            letter-spacing: -0.02em;
            line-height: 1.1;
            background: linear-gradient(to right, #ffffff, #d1fae5);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .brand-text span {
            font-size: 0.75rem;
            color: #6ee7b7;
            font-weight: 600;
            letter-spacing: 0.08em;
            text-transform: uppercase;
        }

        .header-actions {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .btn-login {
            display: inline-flex;
            align-items: center;
            gap: 0.6rem;
            padding: 0.65rem 1.35rem;
            border-radius: 9999px;
            font-size: 0.875rem;
            font-weight: 600;
            color: #ffffff;
            background: rgba(255, 255, 255, 0.06);
            border: 1px solid rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(8px);
            text-decoration: none;
            transition: all 0.25s ease;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.2);
        }

        .btn-login:hover {
            background: rgba(255, 255, 255, 0.12);
            border-color: rgba(16, 185, 129, 0.5);
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(16, 185, 129, 0.25);
            color: #ecfdf5;
        }

        .btn-login svg {
            width: 16px;
            height: 16px;
            stroke: currentColor;
            stroke-width: 2;
            fill: none;
            transition: transform 0.2s ease;
        }

        .btn-login:hover svg {
            transform: translateX(2px);
        }

        /* Main Hero Section */
        .hero {
            flex: 1;
            display: flex;
            align-items: center;
            padding: 4.5rem 0 3.5rem;
        }

        .hero-content {
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
            max-width: 860px;
            margin: 0 auto;
        }

        /* Status Badge */
        .status-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.6rem;
            padding: 0.45rem 1rem;
            border-radius: 9999px;
            background: rgba(16, 185, 129, 0.1);
            border: 1px solid rgba(16, 185, 129, 0.3);
            color: #6ee7b7;
            font-size: 0.8125rem;
            font-weight: 600;
            letter-spacing: 0.04em;
            text-transform: uppercase;
            margin-bottom: 2rem;
            box-shadow: 0 0 25px rgba(16, 185, 129, 0.15);
            animation: float 4s ease-in-out infinite;
        }

        @keyframes float {

            0%,
            100% {
                transform: translateY(0);
            }

            50% {
                transform: translateY(-4px);
            }
        }

        .pulse-dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background-color: #10b981;
            position: relative;
        }

        .pulse-dot::after {
            content: '';
            position: absolute;
            inset: -4px;
            border-radius: 50%;
            background-color: rgba(16, 185, 129, 0.6);
            animation: pulse 1.8s infinite;
        }

        @keyframes pulse {
            0% {
                transform: scale(1);
                opacity: 1;
            }

            100% {
                transform: scale(2.6);
                opacity: 0;
            }
        }

        /* Main Headings */
        .hero-title {
            font-family: 'Space Grotesk', sans-serif;
            font-size: clamp(2.25rem, 5vw, 3.75rem);
            font-weight: 700;
            line-height: 1.15;
            letter-spacing: -0.03em;
            margin-bottom: 1.5rem;
            color: #ffffff;
        }

        .hero-title .gradient-text {
            background: linear-gradient(135deg, #34d399 0%, #10b981 50%, #059669 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            display: inline-block;
        }

        .hero-desc {
            font-size: clamp(1.05rem, 2vw, 1.25rem);
            line-height: 1.7;
            color: var(--text-sub);
            max-width: 680px;
            margin-bottom: 2.75rem;
            font-weight: 400;
        }

        /* Progress card */
        .progress-card {
            width: 100%;
            max-width: 520px;
            background: var(--bg-card);
            border: 1px solid var(--border-glass);
            border-radius: 18px;
            padding: 1.5rem 1.75rem;
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            margin-bottom: 3rem;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.35);
        }

        .progress-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 0.85rem;
            font-size: 0.875rem;
            font-weight: 600;
        }

        .progress-header span:first-child {
            color: var(--text-sub);
            display: flex;
            align-items: center;
            gap: 0.4rem;
        }

        .progress-header span:last-child {
            color: #34d399;
            font-family: 'Space Grotesk', sans-serif;
            font-size: 1rem;
        }

        .progress-track {
            width: 100%;
            height: 10px;
            background: rgba(255, 255, 255, 0.08);
            border-radius: 9999px;
            overflow: hidden;
            position: relative;
        }

        .progress-fill {
            width: 85%;
            height: 100%;
            border-radius: 9999px;
            background: linear-gradient(90deg, #059669, #10b981, #34d399);
            position: relative;
            box-shadow: 0 0 12px rgba(16, 185, 129, 0.5);
            animation: shimmer 2s infinite linear;
            background-size: 200% 100%;
        }

        @keyframes shimmer {
            0% {
                background-position: 200% 0;
            }

            100% {
                background-position: -200% 0;
            }
        }

        .progress-footer {
            margin-top: 0.75rem;
            font-size: 0.785rem;
            color: var(--text-muted);
            text-align: left;
        }

        /* Action Buttons */
        .action-group {
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            justify-content: center;
            gap: 1rem;
            margin-bottom: 3.5rem;
        }

        .btn-primary {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.75rem;
            padding: 0.95rem 2rem;
            border-radius: 14px;
            background: linear-gradient(135deg, #059669, #10b981);
            color: #ffffff;
            font-size: 1rem;
            font-weight: 700;
            text-decoration: none;
            transition: all 0.3s ease;
            box-shadow: 0 4px 20px rgba(16, 185, 129, 0.4);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .btn-primary:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 30px rgba(16, 185, 129, 0.55);
            background: linear-gradient(135deg, #047857, #059669);
        }

        .btn-primary svg {
            width: 20px;
            height: 20px;
            fill: none;
            stroke: currentColor;
            stroke-width: 2.2;
            transition: transform 0.2s ease;
        }

        .btn-primary:hover svg {
            transform: translateX(4px);
        }

        .btn-secondary {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.75rem;
            padding: 0.95rem 1.85rem;
            border-radius: 14px;
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid var(--border-glass);
            color: var(--text-sub);
            font-size: 1rem;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .btn-secondary:hover {
            background: rgba(255, 255, 255, 0.1);
            border-color: rgba(255, 255, 255, 0.25);
            color: #ffffff;
            transform: translateY(-2px);
        }

        .btn-secondary svg {
            width: 20px;
            height: 20px;
            stroke: #25d366;
            fill: none;
            stroke-width: 2;
        }

        /* Pillars / Features Grid */
        .features-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
            gap: 1.5rem;
            width: 100%;
            margin-top: 1rem;
        }

        .feature-card {
            background: var(--bg-card);
            border: 1px solid var(--border-glass);
            border-radius: 16px;
            padding: 1.75rem;
            text-align: left;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
        }

        .feature-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 3px;
            background: linear-gradient(90deg, transparent, var(--primary-light), transparent);
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .feature-card:hover {
            transform: translateY(-5px);
            border-color: var(--border-glow);
            box-shadow: 0 12px 30px rgba(0, 0, 0, 0.4);
        }

        .feature-card:hover::before {
            opacity: 1;
        }

        .feature-icon-box {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            background: rgba(16, 185, 129, 0.12);
            border: 1px solid rgba(16, 185, 129, 0.25);
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 1.25rem;
            color: #34d399;
        }

        .feature-icon-box svg {
            width: 24px;
            height: 24px;
            stroke: currentColor;
            fill: none;
            stroke-width: 2;
        }

        .feature-card h3 {
            font-size: 1.125rem;
            font-weight: 700;
            color: #ffffff;
            margin-bottom: 0.5rem;
            font-family: 'Space Grotesk', sans-serif;
        }

        .feature-card p {
            font-size: 0.875rem;
            color: var(--text-muted);
            line-height: 1.6;
        }

        /* Footer */
        .footer {
            padding: 2.5rem 0;
            border-top: 1px solid var(--border-glass);
            font-size: 0.875rem;
            color: var(--text-muted);
            backdrop-filter: blur(8px);
            -webkit-backdrop-filter: blur(8px);
        }

        .footer-content {
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            justify-content: space-between;
            gap: 1.5rem;
        }

        .footer-links {
            display: flex;
            align-items: center;
            gap: 1.5rem;
            flex-wrap: wrap;
        }

        .footer-links a {
            color: var(--text-sub);
            text-decoration: none;
            font-weight: 500;
            transition: color 0.2s ease;
        }

        .footer-links a:hover {
            color: #34d399;
        }

        /* Responsive Breakpoints */
        @media (max-width: 768px) {
            .header {
                padding: 1.25rem 0;
            }

            .hero {
                padding: 3rem 0 2.5rem;
            }

            .action-group {
                flex-direction: column;
                width: 100%;
            }

            .btn-primary,
            .btn-secondary {
                width: 100%;
            }

            .footer-content {
                flex-direction: column;
                text-align: center;
                gap: 1rem;
            }

            .footer-links {
                justify-content: center;
            }
        }
    </style>
</head>

<body>

    <!-- Header / Barra de Navegación -->
    <header class="header">
        <div class="container" style="display: flex; align-items: center; justify-content: space-between;">
            <a href="{{ url('/') }}" class="logo-wrap">
                <div class="logo-icon">
                    <svg viewBox="0 0 24 24">
                        <path d="M12 2L2 7l10 5 10-5-10-5z"></path>
                        <path d="M2 17l10 5 10-5"></path>
                        <path d="M2 12l10 5 10-5"></path>
                    </svg>
                </div>
                <div class="brand-text">
                    <h1>{{ strtoupper($storeName) }}</h1>
                    <span>Plataforma Digital</span>
                </div>
            </a>

            <div class="header-actions">
                <a href="{{ $loginUrl }}" class="btn-login" title="Acceso al panel administrativo">
                    <svg viewBox="0 0 24 24">
                        <path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"></path>
                        <polyline points="10 17 15 12 10 7"></polyline>
                        <line x1="15" y1="12" x2="3" y2="12"></line>
                    </svg>
                    <span>Iniciar Sesión</span>
                </a>
            </div>
        </div>
    </header>

    <!-- Sección Principal / Hero -->
    <main class="hero">
        <div class="container">
            <div class="hero-content">

                <!-- Badge de Estado -->
                <div class="status-badge">
                    <span class="pulse-dot"></span>
                    <span>Nueva Plataforma en Construcción</span>
                </div>

                <!-- Título Principal -->
                <h2 class="hero-title">
                    Estamos sembrando una <br>
                    <span class="gradient-text">nueva experiencia digital</span> para el campo
                </h2>

                <!-- Subtítulo -->
                <p class="hero-desc">
                    Muy pronto podrás acceder a nuestro catálogo completo de insumos agrícolas y asesoramiento técnico con envios a toda Bolivia.
                </p>


                <!-- Botones de Acción -->
                <div class="action-group">
                    <a href="{{ $loginUrl }}" class="btn-primary">
                        <span>Acceder al Panel de Control</span>
                        <svg viewBox="0 0 24 24">
                            <line x1="5" y1="12" x2="19" y2="12"></line>
                            <polyline points="12 5 19 12 12 19"></polyline>
                        </svg>
                    </a>

                    @if(!empty($storePhone))
                    <a href="https://wa.me/{{ $cleanPhone }}?text={{ urlencode('Hola, me comunico desde la web de Agrobig para solicitar información.') }}" target="_blank" rel="noopener noreferrer" class="btn-secondary">
                        <svg viewBox="0 0 24 24">
                            <path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"></path>
                        </svg>
                        <span>Atención por WhatsApp</span>
                    </a>
                    @endif
                </div>

            </div>
        </div>
    </main>

</body>

</html>