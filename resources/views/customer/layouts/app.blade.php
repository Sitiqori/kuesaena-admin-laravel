<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Kuesaena - Your Sweetness Start From Here')</title>
    <meta name="description" content="@yield('description', 'Kuesaena - Bakery premium dengan cita rasa homemade, menggunakan bahan pilihan terbaik untuk moment spesialmu.')">

    {{-- Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700;800&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">

    {{-- Icons --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    {{-- CSS Variables & Base --}}
    <style>
        :root {
            --brown-darkest: #1C0A02;
            --brown-dark:    #3B1A08;
            --brown-main:    #5C2D0E;
            --brown-mid:     #7B3F18;
            --brown-warm:    #A0522D;
            --brown-light:   #C68B5A;
            --cream-dark:    #E8D5B7;
            --cream-main:    #F5ECD8;
            --cream-light:   #FBF6EE;
            --white:         #FFFFFF;
            --text-dark:     #1A0A00;
            --text-mid:      #4A2C10;
            --text-muted:    #8B6050;
            --shadow-sm:     0 2px 8px rgba(60,20,0,0.08);
            --shadow-md:     0 8px 24px rgba(60,20,0,0.12);
            --shadow-lg:     0 16px 48px rgba(60,20,0,0.18);
            --radius-sm:     8px;
            --radius-md:     16px;
            --radius-lg:     24px;
            --radius-xl:     32px;
            --transition:    all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html {
        scroll-behavior: smooth;
        color-scheme: light;
        }

        body {
            font-family: 'DM Sans', sans-serif;
            color: var(--text-dark);
            background: var(--white);
            overflow-x: hidden;
            line-height: 1.6;
        }

        h1, h2, h3, h4 {
            font-family: 'Playfair Display', serif;
        }

        a {
            text-decoration: none;
            color: inherit;
            transition: var(--transition);
        }

        img {
            max-width: 100%;
            display: block;
        }

        button {
            cursor: pointer;
            font-family: 'DM Sans', sans-serif;
            border: none;
            outline: none;
        }

        input, textarea {
            font-family: 'DM Sans', sans-serif;
        }

        .container {
            max-width: 1280px;
            margin: 0 auto;
            padding: 0 24px;
        }

        /* Scrollbar */
        ::-webkit-scrollbar { width: 6px; }
        ::-webkit-scrollbar-track { background: var(--cream-light); }
        ::-webkit-scrollbar-thumb { background: var(--brown-mid); border-radius: 3px; }

        /* Utilities */
        .btn-primary {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: var(--brown-dark);
            color: var(--white);
            padding: 14px 32px;
            border-radius: var(--radius-xl);
            font-size: 15px;
            font-weight: 600;
            letter-spacing: 0.3px;
            transition: var(--transition);
        }

        .btn-primary:hover {
            background: var(--brown-main);
            transform: translateY(-2px);
            box-shadow: 0 8px 24px rgba(91,45,14,0.35);
        }

        .btn-outline {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: transparent;
            color: var(--brown-dark);
            padding: 12px 28px;
            border-radius: var(--radius-xl);
            font-size: 15px;
            font-weight: 600;
            border: 2px solid var(--brown-dark);
            transition: var(--transition);
        }

        .btn-outline:hover {
            background: var(--brown-dark);
            color: var(--white);
        }

        .section-label {
            font-size: 12px;
            font-weight: 600;
            letter-spacing: 2.5px;
            text-transform: uppercase;
            color: var(--brown-warm);
            margin-bottom: 8px;
            font-family: 'DM Sans', sans-serif;
        }

        .section-title {
            font-size: clamp(28px, 3.5vw, 44px);
            font-weight: 700;
            line-height: 1.2;
            color: var(--text-dark);
        }

        .section-subtitle {
            font-size: 16px;
            color: var(--text-muted);
            margin-top: 12px;
            max-width: 520px;
            margin-left: auto;
            margin-right: auto;
        }

        .text-center { text-align: center; }

        /* Animations */
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(30px); }
            to   { opacity: 1; transform: translateY(0); }
        }
        @keyframes fadeIn {
            from { opacity: 0; }
            to   { opacity: 1; }
        }
        @keyframes floatY {
            0%, 100% { transform: translateY(0px); }
            50%       { transform: translateY(-12px); }
        }

        .animate-fade-up  { animation: fadeInUp 0.7s ease forwards; }
        .animate-fade     { animation: fadeIn 0.7s ease forwards; }
        .float-anim       { animation: floatY 4s ease-in-out infinite; }

        /* Responsive */
        @media (max-width: 768px) {
            .container { padding: 0 16px; }
        }
    </style>

    @stack('styles')
</head>
<body>

    @include('customer.components.navbar')

    <main>
        @yield('content')
    </main>

    @include('customer.components.footer')

    {{-- Scripts --}}
    <script>
        // Navbar scroll effect
        const navbar = document.getElementById('customer-navbar');
        window.addEventListener('scroll', () => {
            if (window.scrollY > 60) {
                navbar.classList.add('scrolled');
            } else {
                navbar.classList.remove('scrolled');
            }
        });

        // Mobile menu toggle
        const mobileToggle = document.getElementById('mobile-toggle');
        const mobileMenu   = document.getElementById('mobile-menu');
        if (mobileToggle && mobileMenu) {
            mobileToggle.addEventListener('click', () => {
                mobileMenu.classList.toggle('open');
            });
        }
    </script>

    @stack('scripts')
</body>
</html>
