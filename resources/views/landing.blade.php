<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Akadea - Academic Information System</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
            line-height: 1.6;
            color: #1a202c;
            background-color: #ffffff;
        }

        /* Navigation */
        nav {
            padding: 0.875rem 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: #ffffff;
            border-bottom: 1px solid #f0f0f0;
            position: sticky;
            top: 0;
            z-index: 100;
        }

        .logo {
            font-size: 1.25rem;
            font-weight: 700;
            color: #2563eb;
            letter-spacing: -0.5px;
        }

        nav ul {
            display: flex;
            list-style: none;
            gap: 1.5rem;
        }

        nav a {
            text-decoration: none;
            color: #4b5563;
            font-size: 0.95rem;
            transition: color 0.3s;
        }

        nav a:hover {
            color: #2563eb;
        }

        .nav-cta {
            display: flex;
            gap: 0.75rem;
            align-items: center;
        }

        .language-switcher {
            display: flex;
            gap: 0.5rem;
            align-items: center;
            margin-right: 0.5rem;
        }

        .lang-btn {
            padding: 0.4rem 0.75rem;
            border-radius: 0.375rem;
            text-decoration: none;
            font-size: 0.8rem;
            font-weight: 600;
            transition: all 0.3s;
            border: 1px solid #e5e7eb;
            background: white;
            color: #4b5563;
            cursor: pointer;
        }

        .lang-btn.active {
            background: #2563eb;
            color: white;
            border-color: #2563eb;
        }

        .lang-btn:hover {
            border-color: #2563eb;
            color: #2563eb;
        }

        .lang-btn.active:hover {
            background: #1d4ed8;
        }

        /* Typography & Spacing Utilities */
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 2rem;
        }

        .section {
            padding: 6rem 2rem;
        }

        h1 {
            font-size: 3.5rem;
            font-weight: 800;
            line-height: 1.1;
            margin-bottom: 1.5rem;
            color: #0f172a;
        }

        h2 {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 1rem;
            color: #0f172a;
            text-align: center;
        }

        h3 {
            font-size: 1.3rem;
            font-weight: 600;
            margin-bottom: 0.75rem;
            color: #1a202c;
        }

        p {
            color: #4b5563;
            font-size: 1rem;
        }

        /* Buttons */
        .btn {
            display: inline-block;
            padding: 0.625rem 1.25rem;
            border-radius: 0.5rem;
            text-decoration: none;
            font-weight: 600;
            font-size: 0.85rem;
            transition: all 0.3s;
            border: none;
            cursor: pointer;
            text-align: center;
        }

        .btn-primary {
            background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%);
            color: white;
            box-shadow: 0 4px 15px rgba(37, 99, 235, 0.2);
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(37, 99, 235, 0.3);
        }

        .btn-secondary {
            background: white;
            color: #2563eb;
            border: 2px solid #2563eb;
        }

        .btn-secondary:hover {
            background: #f0f8ff;
            transform: translateY(-2px);
        }

        /* Hero Section */
        .hero {
            padding: 4rem 2rem 6rem;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 3rem;
            align-items: center;
        }

        .hero-content {
            padding-right: 2rem;
        }

        .hero h1 {
            background: linear-gradient(135deg, #0f172a 0%, #2563eb 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .hero-subtitle {
            font-size: 1.1rem;
            color: #4b5563;
            margin-bottom: 2rem;
            line-height: 1.8;
        }

        .hero-buttons {
            display: flex;
            gap: 1rem;
            margin-bottom: 2rem;
            flex-wrap: wrap;
        }

        .hero-image {
            background: linear-gradient(135deg, #dbeafe 0%, #eff6ff 100%);
            border-radius: 1rem;
            height: 400px;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 20px 50px rgba(37, 99, 235, 0.1);
            overflow: hidden;
        }

        .hero-image svg {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .dashboard-mockup {
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 600;
            font-size: 1.5rem;
        }

        /* Features Section */
        .features {
            background: linear-gradient(180deg, #f9fafb 0%, #ffffff 100%);
        }

        .features-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 2rem;
            margin-top: 3rem;
        }

        .feature-card {
            padding: 2rem;
            background: white;
            border-radius: 1rem;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
            transition: all 0.3s;
            text-align: center;
        }

        .feature-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 8px 24px rgba(37, 99, 235, 0.1);
        }

        .feature-icon {
            width: 60px;
            height: 60px;
            background: linear-gradient(135deg, #dbeafe 0%, #bfdbfe 100%);
            border-radius: 0.75rem;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.5rem;
            font-size: 1.75rem;
        }

        .feature-card p {
            color: #6b7280;
            line-height: 1.6;
        }

        /* Why Choose Us */
        .why-us-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 2.5rem;
            margin-top: 3rem;
        }

        .why-us-card {
            padding: 2.5rem;
            background: white;
            border-radius: 1rem;
            border: 1px solid #e5e7eb;
            transition: all 0.3s;
        }

        .why-us-card:hover {
            border-color: #2563eb;
            box-shadow: 0 8px 24px rgba(37, 99, 235, 0.08);
        }

        .why-us-icon {
            font-size: 2.5rem;
            margin-bottom: 1rem;
        }

        .why-us-card h3 {
            color: #0f172a;
            margin-bottom: 0.75rem;
        }

        .why-us-card p {
            color: #6b7280;
            font-size: 0.95rem;
        }

        /* Preview Section */
        .preview {
            background: linear-gradient(180deg, #ffffff 0%, #f9fafb 100%);
        }

        .preview-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 1.5rem;
            margin-top: 3rem;
        }

        .preview-item {
            background: linear-gradient(135deg, #dbeafe 0%, #eff6ff 100%);
            border-radius: 1rem;
            aspect-ratio: 16 / 10;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #2563eb;
            font-weight: 600;
            font-size: 0.95rem;
            box-shadow: 0 4px 12px rgba(37, 99, 235, 0.08);
        }

        /* Pricing Section */
        .pricing {
            background: linear-gradient(180deg, #f9fafb 0%, #ffffff 100%);
        }

        .pricing-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 2rem;
            margin-top: 3rem;
        }

        .pricing-card {
            padding: 2.5rem;
            background: white;
            border-radius: 1rem;
            border: 2px solid #e5e7eb;
            transition: all 0.3s;
            position: relative;
        }

        .pricing-card.featured {
            border-color: #2563eb;
            transform: scale(1.05);
            box-shadow: 0 12px 40px rgba(37, 99, 235, 0.15);
        }

        .pricing-card:hover {
            border-color: #2563eb;
            box-shadow: 0 8px 24px rgba(37, 99, 235, 0.1);
        }

        .pricing-badge {
            position: absolute;
            top: -12px;
            left: 1rem;
            background: #2563eb;
            color: white;
            padding: 0.25rem 0.75rem;
            border-radius: 9999px;
            font-size: 0.75rem;
            font-weight: 700;
            display: none;
        }

        .pricing-card.featured .pricing-badge {
            display: block;
        }

        .pricing-name {
            font-size: 1.3rem;
            font-weight: 700;
            color: #0f172a;
            margin-bottom: 0.5rem;
        }

        .pricing-description {
            color: #6b7280;
            font-size: 0.9rem;
            margin-bottom: 1.5rem;
        }

        .pricing-price {
            font-size: 2.5rem;
            font-weight: 800;
            color: #0f172a;
            margin-bottom: 0.25rem;
        }

        .pricing-period {
            color: #6b7280;
            font-size: 0.9rem;
            margin-bottom: 2rem;
        }

        .pricing-features {
            list-style: none;
            margin-bottom: 2rem;
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }

        .pricing-features li {
            display: flex;
            align-items: center;
            color: #4b5563;
            font-size: 0.95rem;
        }

        .pricing-features li:before {
            content: "✓";
            display: inline-block;
            width: 20px;
            height: 20px;
            background: linear-gradient(135deg, #dbeafe 0%, #bfdbfe 100%);
            border-radius: 50%;
            text-align: center;
            line-height: 20px;
            color: #2563eb;
            font-weight: 700;
            margin-right: 0.75rem;
            flex-shrink: 0;
        }

        .pricing-card .btn {
            width: 100%;
            text-align: center;
        }

        /* Footer */
        footer {
            background: #0f172a;
            color: white;
            padding: 3rem 2rem;
        }

        .footer-content {
            max-width: 1200px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 2rem;
            margin-bottom: 2rem;
        }

        .footer-section h4 {
            margin-bottom: 1rem;
            font-size: 0.95rem;
            font-weight: 700;
        }

        .footer-section ul {
            list-style: none;
        }

        .footer-section a {
            color: #9ca3af;
            text-decoration: none;
            font-size: 0.9rem;
            display: block;
            margin-bottom: 0.75rem;
            transition: color 0.3s;
        }

        .footer-section a:hover {
            color: #2563eb;
        }

        .footer-logo {
            font-size: 1.5rem;
            font-weight: 700;
            color: #2563eb;
            margin-bottom: 0.5rem;
        }

        .footer-section p {
            color: #9ca3af;
            font-size: 0.9rem;
        }

        .social-links {
            display: flex;
            gap: 1rem;
            margin-top: 1rem;
        }

        .social-icon {
            width: 40px;
            height: 40px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 0.5rem;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            text-decoration: none;
            transition: all 0.3s;
            font-size: 0.9rem;
            font-weight: 700;
        }

        .social-icon:hover {
            background: #2563eb;
        }

        .footer-bottom {
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            padding-top: 2rem;
            text-align: center;
            color: #9ca3af;
            font-size: 0.9rem;
        }

        /* Responsive */
        @media (max-width: 768px) {
            h1 {
                font-size: 2.5rem;
            }

            h2 {
                font-size: 2rem;
            }

            .hero {
                grid-template-columns: 1fr;
                padding: 2rem 0 4rem;
            }

            .hero-content {
                padding-right: 0;
            }

            .hero-image {
                height: 300px;
            }

            .hero-buttons {
                flex-direction: column;
            }

            .hero-buttons .btn {
                width: 100%;
            }

            nav {
                flex-direction: column;
                gap: 1rem;
            }

            nav ul {
                flex-wrap: wrap;
                justify-content: center;
                gap: 1rem;
            }

            .nav-cta {
                width: 100%;
                justify-content: center;
            }

            .pricing-card.featured {
                transform: scale(1);
            }

            .section {
                padding: 4rem 2rem;
            }

            .footer-content {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 480px) {
            h1 {
                font-size: 2rem;
            }

            h2 {
                font-size: 1.5rem;
            }

            .section {
                padding: 3rem 1rem;
            }

            .container {
                padding: 0 1rem;
            }

            nav {
                padding: 1rem;
            }

            nav ul {
                gap: 1rem;
            }

            nav a {
                font-size: 0.85rem;
            }

            .btn {
                padding: 0.75rem 1.25rem;
                font-size: 0.85rem;
            }

            .features-grid,
            .why-us-grid,
            .pricing-grid,
            .preview-grid {
                gap: 1.5rem;
            }

            .hero-buttons {
                gap: 0.75rem;
            }
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav>
        <div class="logo">AKADEA</div>
        <ul>
            <li><a href="#features" data-en="Features" data-id="Fitur">Features</a></li>
            <li><a href="#pricing" data-en="Pricing" data-id="Harga">Pricing</a></li>
            <li><a href="#about" data-en="About" data-id="Tentang">About</a></li>
        </ul>
        <div class="nav-cta">
            <div class="language-switcher">
                <button class="lang-btn active" data-lang="en">EN</button>
                <button class="lang-btn" data-lang="id">ID</button>
            </div>
            <a href="{{ route('login') }}" class="btn btn-secondary" data-en="Sign In" data-id="Masuk">Sign In</a>
            <a href="{{ route('register') }}" class="btn btn-primary" data-en="Get Started" data-id="Mulai">Get Started</a>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero container">
        <div class="hero-content">
            <h1 data-en="Academic Information System" data-id="Sistem Informasi Akademik">Academic Information System</h1>
            <p class="hero-subtitle" data-en="A modern platform to manage students, teachers, grades, schedules, and academic operations. Simplify education management with powerful, intuitive tools." data-id="Platform modern untuk mengelola siswa, guru, nilai, jadwal, dan operasi akademik. Sederhanakan manajemen pendidikan dengan alat yang kuat dan intuitif.">A modern platform to manage students, teachers, grades, schedules, and academic operations. Simplify education management with powerful, intuitive tools.</p>
            <div class="hero-buttons">
                <a href="{{ route('register') }}" class="btn btn-primary" data-en="Get Started" data-id="Mulai">Get Started</a>
                <a href="https://wa.me/6289692373366" class="btn btn-secondary" data-en="Contact Us" data-id="Hubungi Kami">Contact Us</a>
            </div>
        </div>
        <div class="hero-image">
            <div class="dashboard-mockup" data-en="Dashboard Preview" data-id="Pratinjau Dashboard">Dashboard Preview</div>
        </div>
    </section>

    <!-- Features Section -->
    <section id="features" class="features section">
        <div class="container">
            <h2 data-en="Powerful Features" data-id="Fitur Canggih">Powerful Features</h2>
            <p style="text-align: center; color: #6b7280; margin-bottom: 1rem;" data-en="Everything you need to manage your academic institution" data-id="Semua yang Anda butuhkan untuk mengelola institusi akademik Anda">Everything you need to manage your academic institution</p>
            <div class="features-grid">
                <div class="feature-card">
                    <div class="feature-icon">👨‍🎓</div>
                    <h3 data-en="Student Management" data-id="Manajemen Siswa">Student Management</h3>
                    <p data-en="Manage student profiles, enrollment, and academic history all in one place." data-id="Kelola profil siswa, pendaftaran, dan riwayat akademik di satu tempat.">Manage student profiles, enrollment, and academic history all in one place.</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">👨‍🏫</div>
                    <h3 data-en="Teacher & Staff Management" data-id="Manajemen Guru & Staf">Teacher & Staff Management</h3>
                    <p data-en="Organize staff information, roles, and responsibilities effortlessly." data-id="Atur informasi staf, peran, dan tanggung jawab dengan mudah.">Organize staff information, roles, and responsibilities effortlessly.</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">📋</div>
                    <h3 data-en="Attendance Tracking" data-id="Pelacakan Kehadiran">Attendance Tracking</h3>
                    <p data-en="Monitor attendance with real-time tracking and comprehensive reports." data-id="Pantau kehadiran dengan pelacakan real-time dan laporan komprehensif.">Monitor attendance with real-time tracking and comprehensive reports.</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">📊</div>
                    <h3 data-en="Grade & Report Cards" data-id="Nilai & Kartu Rapor">Grade & Report Cards</h3>
                    <p data-en="Issue digital report cards and manage grades with detailed analytics." data-id="Terbitkan kartu rapor digital dan kelola nilai dengan analitik terperinci.">Issue digital report cards and manage grades with detailed analytics.</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">📅</div>
                    <h3 data-en="Class Scheduling" data-id="Penjadwalan Kelas">Class Scheduling</h3>
                    <p data-en="Create and manage class schedules without conflicts." data-id="Buat dan kelola jadwal kelas tanpa konflik.">Create and manage class schedules without conflicts.</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">💳</div>
                    <h3 data-en="Payment & Billing" data-id="Pembayaran & Penagihan">Payment & Billing</h3>
                    <p data-en="Handle fees, invoicing, and payment processing securely." data-id="Tangani biaya, faktur, dan pemrosesan pembayaran dengan aman.">Handle fees, invoicing, and payment processing securely.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Why Choose Us Section -->
    <section id="about" class="section">
        <div class="container">
            <h2 data-en="Why Choose Akadea?" data-id="Mengapa Memilih Akadea?">Why Choose Akadea?</h2>
            <div class="why-us-grid">
                <div class="why-us-card">
                    <div class="why-us-icon">⚡</div>
                    <h3 data-en="Fast & Reliable" data-id="Cepat & Andal">Fast & Reliable</h3>
                    <p data-en="Lightning-fast performance with 99.9% uptime ensures your institution stays connected." data-id="Performa super cepat dengan uptime 99,9% memastikan institusi Anda tetap terhubung.">Lightning-fast performance with 99.9% uptime ensures your institution stays connected.</p>
                </div>
                <div class="why-us-card">
                    <div class="why-us-icon">🔒</div>
                    <h3 data-en="Secure & Compliant" data-id="Aman & Sesuai">Secure & Compliant</h3>
                    <p data-en="Enterprise-grade security with encryption and compliance with education standards." data-id="Keamanan tingkat enterprise dengan enkripsi dan kepatuhan terhadap standar pendidikan.">Enterprise-grade security with encryption and compliance with education standards.</p>
                </div>
                <div class="why-us-card">
                    <div class="why-us-icon">✨</div>
                    <h3 data-en="Easy to Use" data-id="Mudah Digunakan">Easy to Use</h3>
                    <p data-en="Intuitive interface designed for educators, not technicians. Zero learning curve." data-id="Antarmuka intuitif dirancang untuk pendidik, bukan teknisi. Kurva pembelajaran nol.">Intuitive interface designed for educators, not technicians. Zero learning curve.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Preview Section -->
    <section class="preview section">
        <div class="container">
            <h2 data-en="See Akadea in Action" data-id="Lihat Akadea dalam Aksi">See Akadea in Action</h2>
            <p style="text-align: center; color: #6b7280; margin-bottom: 1rem;" data-en="Explore our clean, modern interface" data-id="Jelajahi antarmuka kami yang bersih dan modern">Explore our clean, modern interface</p>
            <div class="preview-grid">
                <div class="preview-item" data-en="Student Dashboard" data-id="Dashboard Siswa">Student Dashboard</div>
                <div class="preview-item" data-en="Attendance Panel" data-id="Panel Kehadiran">Attendance Panel</div>
                <div class="preview-item" data-en="Grades Overview" data-id="Ringkasan Nilai">Grades Overview</div>
                <div class="preview-item" data-en="Schedule View" data-id="Tampilan Jadwal">Schedule View</div>
                <div class="preview-item" data-en="Reports & Analytics" data-id="Laporan & Analitik">Reports & Analytics</div>
                <div class="preview-item" data-en="Payment Manager" data-id="Manajer Pembayaran">Payment Manager</div>
            </div>
        </div>
    </section>

    <!-- Pricing Section -->
    <section id="pricing" class="pricing section">
        <div class="container">
            <h2 data-en="Simple, Transparent Pricing" data-id="Harga Sederhana, Transparan">Simple, Transparent Pricing</h2>
            <p style="text-align: center; color: #6b7280; margin-bottom: 1rem;" data-en="Choose the perfect plan for your institution" data-id="Pilih paket sempurna untuk institusi Anda">Choose the perfect plan for your institution</p>
            <div class="pricing-grid">
                <!-- Basic Plan -->
                <div class="pricing-card">
                    <div class="pricing-badge" data-en="Popular" data-id="Populer">Popular</div>
                    <div class="pricing-name" data-en="Basic" data-id="Dasar">Basic</div>
                    <p class="pricing-description" data-en="Perfect for small schools" data-id="Sempurna untuk sekolah kecil">Perfect for small schools</p>
                    <div class="pricing-price">Rp 0</div>
                    <p class="pricing-period" data-en="per month" data-id="per bulan">per month</p>
                    <ul class="pricing-features">
                        <li data-en="Up to 500 students" data-id="Hingga 500 siswa">Up to 500 students</li>
                        <li data-en="Basic student management" data-id="Manajemen siswa dasar">Basic student management</li>
                        <li data-en="Attendance tracking" data-id="Pelacakan kehadiran">Attendance tracking</li>
                        <li data-en="Email support" data-id="Dukungan email">Email support</li>
                    </ul>
                    <a href="#" class="btn btn-secondary" data-en="Get Started" data-id="Mulai">Get Started</a>
                </div>

                <!-- Standard Plan -->
                <div class="pricing-card featured">
                    <div class="pricing-badge" data-en="Most Popular" data-id="Paling Populer">Most Popular</div>
                    <div class="pricing-name" data-en="Standard" data-id="Standar">Standard</div>
                    <p class="pricing-description" data-en="For growing institutions" data-id="Untuk institusi yang berkembang">For growing institutions</p>
                    <div class="pricing-price">Rp 1,000K</div>
                    <p class="pricing-period" data-en="per month" data-id="per bulan">per month</p>
                    <ul class="pricing-features">
                        <li data-en="Up to 2,000 students" data-id="Hingga 2.000 siswa">Up to 2,000 students</li>
                        <li data-en="Full student management" data-id="Manajemen siswa lengkap">Full student management</li>
                        <li data-en="Attendance & grades" data-id="Kehadiran & nilai">Attendance & grades</li>
                        <li data-en="Class scheduling" data-id="Penjadwalan kelas">Class scheduling</li>
                        <li data-en="Priority support" data-id="Dukungan prioritas">Priority support</li>
                    </ul>
                    <a href="#" class="btn btn-primary" data-en="Get Started" data-id="Mulai">Get Started</a>
                </div>

                <!-- Premium Plan -->
                <div class="pricing-card">
                    <div class="pricing-badge" data-en="Enterprise" data-id="Perusahaan">Enterprise</div>
                    <div class="pricing-name" data-en="Premium" data-id="Premium">Premium</div>
                    <p class="pricing-description" data-en="For large universities" data-id="Untuk universitas besar">For large universities</p>
                    <div class="pricing-price">Rp 5,000K</div>
                    <p class="pricing-period" data-en="per month" data-id="per bulan">per month</p>
                    <ul class="pricing-features">
                        <li data-en="Unlimited students" data-id="Siswa tanpa batas">Unlimited students</li>
                        <li data-en="All features included" data-id="Semua fitur disertakan">All features included</li>
                        <li data-en="Payment processing" data-id="Pemrosesan pembayaran">Payment processing</li>
                        <li data-en="Advanced analytics" data-id="Analitik lanjutan">Advanced analytics</li>
                        <li data-en="24/7 dedicated support" data-id="Dukungan khusus 24/7">24/7 dedicated support</li>
                    </ul>
                    <a href="https://wa.me/6289692373366" class="btn btn-secondary" data-en="Contact Sales" data-id="Hubungi Penjualan">Contact Sales</a>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer>
        <div class="container">
            <div class="footer-content">
                <div class="footer-section">
                    <div class="footer-logo">AKADEA</div>
                    <p>Modern academic management for the future of education.</p>
                </div>
                <div class="footer-section">
                    <h4 data-en="Product" data-id="Produk">Product</h4>
                    <ul>
                        <li><a href="#features" data-en="Features" data-id="Fitur">Features</a></li>
                        <li><a href="#pricing" data-en="Pricing" data-id="Harga">Pricing</a></li>
                    </ul>
                </div>
                <div class="footer-section">
                    <h4 data-en="Company" data-id="Perusahaan">Company</h4>
                    <ul>
                        <li><a href="#about" data-en="About Us" data-id="Tentang Kami">About Us</a></li>
                        <li><a href="#about" data-en="Blog" data-id="Blog">Blog</a></li>
                        <li><a href="#about" data-en="Careers" data-id="Karir">Careers</a></li>
                    </ul>
                </div>
                <div class="footer-section">
                    <h4 data-en="Legal" data-id="Hukum">Legal</h4>
                    <ul>
                        <li><a href="https://docs.google.com/document/d/16tkXV6oclykGHnKXJwtfKN_8Wmw_Y2eyy0uU4g4gOyM/edit?usp=sharing" data-en="Privacy Policy" data-id="Kebijakan Privasi">Privacy Policy</a></li>
                        <li><a href="https://docs.google.com/document/d/16tkXV6oclykGHnKXJwtfKN_8Wmw_Y2eyy0uU4g4gOyM/edit?usp=sharing" data-en="Terms of Service" data-id="Syarat Layanan">Terms of Service</a></li>
                        <li><a href="https://wa.me/6289692373366" data-en="Contact" data-id="Hubungi">Contact</a></li>
                    </ul>
                </div>
            </div>
            <div class="footer-bottom">
                <p>&copy; 2025 Akadea. All rights reserved. | Academic Information System</p>
            </div>
        </div>
    </footer>

    <script>
        // Language switcher functionality
        const langBtns = document.querySelectorAll('.lang-btn');
        const allElements = document.querySelectorAll('[data-en][data-id]');

        // Set default language to English
        let currentLang = localStorage.getItem('selectedLang') || 'en';
        setLanguage(currentLang);

        langBtns.forEach(btn => {
            btn.addEventListener('click', () => {
                const lang = btn.getAttribute('data-lang');
                setLanguage(lang);
                localStorage.setItem('selectedLang', lang);
            });
        });

        function setLanguage(lang) {
            // Update button states
            langBtns.forEach(btn => {
                btn.classList.remove('active');
                if (btn.getAttribute('data-lang') === lang) {
                    btn.classList.add('active');
                }
            });

            // Update all text content
            allElements.forEach(element => {
                const text = element.getAttribute(`data-${lang}`);
                if (text) {
                    // Check if it's a badge element
                    if (element.classList.contains('pricing-badge')) {
                        element.textContent = text;
                    } 
                    // Check if it has child nodes (for elements with tags inside)
                    else if (element.children.length === 0) {
                        element.textContent = text;
                    } else {
                        // For elements with children, update only the direct text nodes
                        let found = false;
                        element.childNodes.forEach(node => {
                            if (node.nodeType === 3) { // Text node
                                node.textContent = text;
                                found = true;
                            }
                        });
                        if (!found) {
                            element.textContent = text;
                        }
                    }
                }
            });

            currentLang = lang;
        }
    </script>
</body>
</html>
