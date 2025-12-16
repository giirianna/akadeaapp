@extends('layouts.app')

@section('content')
    <!-- ========== title-wrapper start ========== -->
    <div class="title-wrapper pt-30">
        <div class="row align-items-center">
            <div class="col-md-6">
                <div class="title">
                    <h2>{{ __('app.dashboard') }}</h2>
                </div>
            </div>
            <div class="col-md-6">
                <div class="breadcrumb-wrapper">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{ route('dashboard') }}">{{ __('app.dashboard') }}</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">
                                {{ __('app.home') }}
                            </li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <!-- ========== title-wrapper end ========== -->

    <!-- ========== ringkasan statistik ========== -->
    <div class="row">
        <div class="col-xl-3 col-lg-4 col-sm-6">
            <div class="icon-card mb-30">
                <div class="icon primary">
                    <i class="lni lni-book"></i>
                </div>
                <div class="content">
                    <h6 class="mb-10">Mata Pelajaran Aktif</h6>
                    <h3 class="text-bold mb-10">8</h3>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-lg-4 col-sm-6">
            <div class="icon-card mb-30">
                <div class="icon success">
                    <i class="lni lni-graduation"></i>
                </div>
                <div class="content">
                    <h6 class="mb-10">Rata-rata Nilai</h6>
                    <h3 class="text-bold mb-10">87.5</h3>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-lg-4 col-sm-6">
            <div class="icon-card mb-30">
                <div class="icon warning">
                    <i class="lni lni-files"></i>
                </div>
                <div class="content">
                    <h6 class="mb-10">Tugas Belum Selesai</h6>
                    <h3 class="text-bold mb-10">3</h3>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-lg-4 col-sm-6">
            <div class="icon-card mb-30">
                <div class="icon purple">
                    <i class="lni lni-calendar"></i>
                </div>
                <div class="content">
                    <h6 class="mb-10">Kehadiran Bulan Ini</h6>
                    <h3 class="text-bold mb-10">94%</h3>
                </div>
            </div>
        </div>
    </div>

    <!-- ========== kalender akademik & modul ========== -->
    <div class="row">
        <!-- Kalender Akademik -->
        <div class="col-lg-6">
            <div class="card-style mb-30">
                <div class="title d-flex justify-content-between">
                    <h6 class="text-medium">Kalender Akademik</h6>
                </div>
                <ul class="list-unstyled">
                    <li class="mb-2">
                        <strong>Jadwal Hari Ini:</strong>
                        <ul class="mt-1 ms-3">
                            <li>Matematika – 07.00–08.30</li>
                            <li>Bahasa Indonesia – 08.30–10.00</li>
                            <li>IPA – 10.30–12.00</li>
                        </ul>
                    </li>
                    <li class="mb-2">
                        <strong>Ujian Mendatang:</strong>
                        <ul class="mt-1 ms-3">
                            <li>UH Matematika – 15 Des 2025</li>
                            <li>PTS IPA – 20 Des 2025</li>
                        </ul>
                    </li>
                    <li>
                        <strong>Deadline Tugas:</strong>
                        <ul class="mt-1 ms-3">
                            <li>Laporan Praktikum – 13 Des 2025</li>
                            <li>Esai Sejarah – 14 Des 2025</li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>

        <!-- Modul & Materi -->
        <div class="col-lg-6">
            <div class="card-style mb-30">
                <div class="title d-flex justify-content-between">
                    <h6 class="text-medium">Modul & Materi</h6>
                    <a href="#" class="text-sm text-primary">Lihat Semua</a>
                </div>
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Mata Pelajaran</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Matematika</td>
                                <td><span class="badge bg-success">Sudah Dibaca</span></td>
                                <td><a href="#" class="text-primary">PDF</a></td>
                            </tr>
                            <tr>
                                <td>IPA</td>
                                <td><span class="badge bg-warning">Belum Dibaca</span></td>
                                <td><a href="#" class="text-primary">Video</a></td>
                            </tr>
                            <tr>
                                <td>Bahasa Inggris</td>
                                <td><span class="badge bg-success">Sudah Dibaca</span></td>
                                <td><a href="#" class="text-primary">PDF</a></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- ========== tugas & evaluasi + pengumuman ========== -->
    <div class="row">
        <!-- Tugas & Evaluasi -->
        <div class="col-lg-6">
            <div class="card-style mb-30">
                <div class="title d-flex justify-content-between">
                    <h6 class="text-medium">Tugas & Evaluasi</h6>
                    <a href="#" class="text-sm text-primary">Lihat Semua</a>
                </div>
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Judul</th>
                                <th>Status</th>
                                <th>Nilai</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Laporan Praktikum</td>
                                <td><span class="badge bg-warning">Dikumpulkan</span></td>
                                <td>85</td>
                            </tr>
                            <tr>
                                <td>Latihan Soal Matematika</td>
                                <td><span class="badge bg-success">Dinilai</span></td>
                                <td>92</td>
                            </tr>
                            <tr>
                                <td>Esai Sejarah</td>
                                <td><span class="badge bg-secondary">Belum Dikerjakan</span></td>
                                <td>-</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Pengumuman & Notifikasi -->
        <div class="col-lg-6">
            <div class="card-style mb-30">
                <div class="title">
                    <h6 class="text-medium">Pengumuman & Notifikasi</h6>
                </div>
                <div class="activity-timeline">
                    <div class="activity-item d-flex mb-3">
                        <div class="icon me-3">
                            <i class="lni lni-bullhorn text-warning"></i>
                        </div>
                        <div>
                            <p class="text-sm mb-1">Wali kelas: “Pastikan SPP bulan Desember sudah dibayar sebelum 15 Desember.”</p>
                            <small class="text-gray">10 Des 2025, 08:30</small>
                        </div>
                    </div>
                    <div class="activity-item d-flex mb-3">
                        <div class="icon me-3">
                            <i class="lni lni-alarm text-danger"></i>
                        </div>
                        <div>
                            <p class="text-sm mb-1">Deadline tugas esai Sejarah tinggal 2 hari lagi!</p>
                            <small class="text-gray">10 Des 2025, 07:15</small>
                        </div>
                    </div>
                    <div class="activity-item d-flex mb-3">
                        <div class="icon me-3">
                            <i class="lni lni-cog text-info"></i>
                        </div>
                        <div>
                            <p class="text-sm mb-1">Sistem akan maintenance pada 14 Desember pukul 22.00–02.00.</p>
                            <small class="text-gray">09 Des 2025, 14:00</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- ========== profil siswa + grafik performa ========== -->
    <div class="row">
        <!-- Profil Siswa -->
        <div class="col-lg-5">
            <div class="card-style mb-30">
                <div class="title">
                    <h6 class="text-medium">Profil Siswa</h6>
                </div>
                @php
                    $user = auth()->user();
                    $siswa = $user->siswa ?? null;
                    $nama = $siswa ? $siswa->nama : 'Nama Siswa';
                    $kelas = $siswa ? $siswa->kelas : 'Kelas Belum Diatur';
                    $nis = $siswa ? $siswa->nis : 'NIS Belum Diatur';
                @endphp
                <div class="d-flex align-items-center mb-20">
                    <div>
                        <h5 class="mb-1">{{ $nama }}</h5>
                        <p class="text-sm text-gray">{{ $kelas }}</p>
                        <p class="text-sm">NIS: {{ $nis }}</p>
                    </div>
                </div>

                <div class="progress mb-15">
                    <div class="progress-bar bg-success" role="progressbar" style="width: 78%" aria-valuenow="78" aria-valuemin="0" aria-valuemax="100">
                        78% Belajar
                    </div>
                </div>
                <p class="text-sm mb-15">Progress materi telah diselesaikan</p>

                <!-- SPP Ringkasan (Dinamis dari DB) -->
                @php
                    // Ambil data siswa yang sedang login
                    $siswa = auth()->user()->siswa ?? null;

                    if ($siswa && isset($siswa->tanggal_masuk)) {
                        $tanggal_masuk = \Carbon\Carbon::parse($siswa->tanggal_masuk);
                        $bulan_masuk = (int) $tanggal_masuk->format('m');
                        $tahun_masuk = (int) $tanggal_masuk->format('Y');
                        
                        // Bulan & tahun sekarang (asumsi: Desember 2025 sebagai referensi tampilan)
                        // Di produksi, ganti dengan Carbon::now()
                        $bulan_sekarang = 12; // (int) \Carbon\Carbon::now()->format('m');
                        $tahun_sekarang = 2025; // (int) \Carbon\Carbon::now()->format('Y');

                        // Hitung jumlah bulan dari masuk hingga sekarang
                        $jumlah_bulan = 0;
                        $tmp_bulan = $bulan_masuk;
                        $tmp_tahun = $tahun_masuk;

                        while (!($tmp_bulan == $bulan_sekarang && $tmp_tahun == $tahun_sekarang)) {
                            $jumlah_bulan++;
                            $tmp_bulan++;
                            if ($tmp_bulan > 12) {
                                $tmp_bulan = 1;
                                $tmp_tahun++;
                            }
                        }
                        $jumlah_bulan++; // termasuk bulan sekarang

                        $tarif_per_bulan = 300000;
                        $total_tagihan = $jumlah_bulan * $tarif_per_bulan;

                        // Ambil bulan yang sudah dibayar
                        $pembayaran_bulan = \App\Models\PembayaranSpp::where('siswa_id', $siswa->id)
                            ->where('tahun', $tahun_sekarang)
                            ->pluck('bulan')
                            ->toArray();

                        $sudah_dibayar = count($pembayaran_bulan) * $tarif_per_bulan;
                        $sisa_tagihan = $total_tagihan - $sudah_dibayar;
                        $lunas = $sisa_tagihan <= 0;

                        // Buat daftar bulan dari masuk → sekarang
                        $bulan_list = [];
                        $bln = $bulan_masuk;
                        $thn = $tahun_masuk;
                        for ($i = 0; $i < $jumlah_bulan; $i++) {
                            if ($bln > 12) {
                                $bln = 1;
                                $thn++;
                            }
                            $bulan_list[$bln] = \Carbon\Carbon::create()->month($bln)->format('F');
                            $bln++;
                        }
                        ksort($bulan_list);
                        $bulan_lunas = $pembayaran_bulan;
                    } else {
                        // Fallback jika tidak ada data
                        $bulan_masuk = 8;
                        $bulan_sekarang = 12;
                        $jumlah_bulan = 5;
                        $total_tagihan = 1500000;
                        $sudah_dibayar = 1200000;
                        $sisa_tagihan = 300000;
                        $lunas = false;
                        $bulan_list = [8 => 'Agustus', 9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'];
                        $bulan_lunas = [8, 9, 10, 11];
                    }
                @endphp

                <div class="border-top pt-3 mt-3">
                    <h6 class="text-sm fw-bold mb-2">Status SPP</h6>
                    <div class="d-flex justify-content-between mb-1">
                        <span>Total Tagihan</span>
                        <strong>Rp{{ number_format($total_tagihan, 0, ',', '.') }}</strong>
                    </div>
                    <div class="d-flex justify-content-between mb-1">
                        <span>Sudah Dibayar</span>
                        <strong class="text-success">Rp{{ number_format($sudah_dibayar, 0, ',', '.') }}</strong>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span>Sisa Tagihan</span>
                        <strong class="{{ $sisa_tagihan > 0 ? 'text-danger' : 'text-success' }}">
                            Rp{{ number_format($sisa_tagihan, 0, ',', '.') }}
                        </strong>
                    </div>

                    @if($lunas)
                        <span class="badge bg-success mb-3">Lunas</span>
                    @else
                        <span class="badge bg-danger mb-3">Belum Lunas</span>
                    @endif
                </div>
            </div>
        </div>

        <!-- Grafik Performa -->
        <div class="col-lg-7">
            <div class="card-style mb-30">
                <div class="title">
                    <h6 class="text-medium">Grafik Performa</h6>
                </div>
                <div class="chart">
                    <canvas id="ChartPerforma" style="width: 100%; height: 300px; margin-left: -20px;"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- ========== Detail SPP - Google Sheet Style ========== -->
    <div class="row" id="detail-spp">
        <div class="col-12">
            <div class="card-style mb-30">
                <div class="title d-flex justify-content-between align-items-center">
                    <h6 class="text-medium">Detail SPP ({{ min(array_keys($bulan_list)) }} – {{ max(array_keys($bulan_list)) }} 2025)</h6>
                    <span class="text-sm text-muted">Tarif: Rp300.000/bulan</span>
                </div>
                <div class="table-responsive">
                    <table class="table table-borderless" style="font-size: 0.95rem;">
                        <thead>
                            <tr style="background-color: #f9fafb;">
                                <th style="padding: 12px 15px; border-bottom: 2px solid #e5e7eb;">#</th>
                                <th style="padding: 12px 15px; border-bottom: 2px solid #e5e7eb;">Bulan</th>
                                <th style="padding: 12px 15px; border-bottom: 2px solid #e5e7eb; text-align: right;">Tagihan</th>
                                <th style="padding: 12px 15px; border-bottom: 2px solid #e5e7eb; text-align: center;">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($bulan_list as $bulan_num => $bulan_nama)
                                <tr style="border-bottom: 1px solid #f3f4f6;">
                                    <td style="padding: 12px 15px;">{{ $loop->iteration }}</td>
                                    <td style="padding: 12px 15px;">{{ $bulan_nama }} 2025</td>
                                    <td style="padding: 12px 15px; text-align: right;">Rp{{ number_format(300000, 0, ',', '.') }}</td>
                                    <td style="padding: 12px 15px; text-align: center;">
                                        @if(in_array($bulan_num, $bulan_lunas))
                                            <span class="badge bg-success" style="font-size: 0.85rem; padding: 5px 10px;">Lunas</span>
                                        @else
                                            <span class="badge bg-danger" style="font-size: 0.85rem; padding: 5px 10px;">Belum Bayar</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr style="background-color: #f9fafb; font-weight: 600;">
                                <td colspan="2" style="padding: 12px 15px;">Total</td>
                                <td style="padding: 12px 15px; text-align: right;">Rp{{ number_format($total_tagihan, 0, ',', '.') }}</td>
                                <td style="padding: 12px 15px; text-align: center;">
                                    @if($lunas)
                                        <span class="badge bg-success">Lunas</span>
                                    @else
                                        <span class="badge bg-warning">Belum Lunas</span>
                                    @endif
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const ctx = document.getElementById('ChartPerforma');
        if (ctx) {
            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: ['Matematika', 'IPA', 'B.Indo', 'B.Inggris', 'Sejarah', 'PJOK', 'Seni', 'Agama'],
                    datasets: [{
                        label: 'Nilai',
                        data: [88, 90, 85, 92, 80, 95, 87, 93],
                        backgroundColor: '#3C50E0',
                        borderColor: '#3C50E0',
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true,
                            max: 100
                        }
                    },
                    plugins: {
                        legend: { display: false }
                    }
                }
            });
        }
    </script>

    <style>
        .progress { height: 12px; border-radius: 6px; }
        .progress-bar {
            font-size: 0.7rem;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 0;
        }
        .card-style {
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.05);
            border: 1px solid #eee;
        }
        .text-gray { color: #888; }
        .icon-card .icon {
            width: 48px;
            height: 48px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 12px;
        }
        .icon.primary { background-color: #e0f0ff; color: #1d4ed8; }
        .icon.success { background-color: #e6f7e6; color: #16a34a; }
        .icon.warning { background-color: #fff8e1; color: #b45309; }
        .icon.purple { background-color: #f3e8ff; color: #7e22ce; }
        .activity-item i { font-size: 1.1rem; }

        /* Google Sheet Style */
        .table-borderless th,
        .table-borderless td {
            border: none !important;
        }
        .table-borderless thead th {
            color: #374151;
            font-weight: 600;
        }
        .badge {
            border-radius: 50px;
        }
    </style>
@endsection