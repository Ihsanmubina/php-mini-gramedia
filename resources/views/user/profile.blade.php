@extends('layout.app')

@section('content')
    <div class="container-xl py-4">
        <div class="row g-4">
            {{-- Kolom Kiri: Profil Summary --}}
            <div class="col-lg-3 col-md-4">
                <div class="card border shadow-none" style="border-radius: 12px; border-color: #e2e8f0 !important; background: #ffffff;">
                    <div class="card-body p-4">
                        {{-- Avatar & Nama User --}}
                        <div class="d-flex align-items-center gap-3 mb-3">
                            <span class="avatar avatar-md rounded-circle text-dark fw-bold"
                                  style="background-color: #e2e8f0; width: 48px; height: 48px; font-size: 16px; color: #475569 !important;">
                                {{ strtoupper(substr(Auth::user()->name, 0, 2)) }}
                            </span>
                            <div>
                                <h3 class="fw-bold mb-0 text-dark" style="font-size: 17px;">{{ Auth::user()->name }}</h3>
                            </div>
                        </div>

                        <hr class="my-3" style="border-color: #e2e8f0; opacity: 0.8;">

                        <h4 class="fw-bold mb-3" style="color: #0284c7; font-size: 16px;">Profil Summary</h4>

                        <div class="d-flex justify-content-between align-items-center py-2">
                            <span class="text-secondary" style="font-size: 14px;">Koleksi Buku</span>
                            <span class="fw-bold text-dark" style="font-size: 15px;">{{ $totalBooks }}</span>
                        </div>

                        <div class="d-flex justify-content-between align-items-center py-2">
                            <span class="text-secondary" style="font-size: 14px;">Langganan</span>
                            <span class="fw-bold text-dark" style="font-size: 15px;">{{ $totalSubscriptions }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-9 col-md-8">
                <div class="card border shadow-none" style="border-radius: 12px; border-color: #e2e8f0 !important; background: #ffffff;">
                    <div class="card-body p-4">
                        {{-- Header Transaksi & Dropdown Filter --}}
                        <div class="d-flex justify-content-between align-items-start mb-4">
                            <h2 class="fw-bold text-dark mb-0" style="font-size: 24px;">Transaksi</h2>
                            <div style="min-width: 180px;">
                                <label for="filterJenisTransaksi" class="form-label text-secondary small mb-1 fw-medium">
                                    Jenis Transaksi
                                </label>
                                <select id="filterJenisTransaksi" class="form-select border text-dark"
                                        style="border-color: #cbd5e1; border-radius: 8px; font-size: 14px; padding: 7px 12px;"
                                        onchange="switchTransaksi(this.value)">
                                    <option value="langganan" selected>Paket Langganan</option>
                                    <option value="buku">Buku</option>
                                </select>
                            </div>
                        </div>

                        {{-- Daftar Transaksi Paket Langganan (Default) --}}
                        <div id="section-langganan">
                            @forelse ($subscriptions as $sub)
                                <div class="border rounded-3 p-4 mb-3 bg-white" style="border-color: #e2e8f0 !important;">
                                    {{-- Baris Atas: Tanggal & Badge Status --}}
                                    <div class="d-flex justify-content-between align-items-center mb-4">
                                        <span class="text-secondary small" style="font-size: 13px;">
                                            {{ $sub->created_at ? $sub->created_at->format('d M Y, H:i') : '-' }}
                                        </span>
                                        <span class="badge fw-semibold"
                                              style="background-color: #e6f9ed; color: #16a34a; font-size: 12px; padding: 6px 14px; border-radius: 6px;">
                                            Transaksi Sukses
                                        </span>
                                    </div>

                                    {{-- Baris Bawah: Nama Paket + Masa Berlaku di Kiri, Total Pembayaran di Kanan --}}
                                    <div class="d-flex justify-content-between align-items-end flex-wrap gap-2">
                                        <div class="d-flex align-items-center gap-3 flex-wrap">
                                            <span class="fw-bold text-dark" style="font-size: 18px;">
                                                {{ $sub->subscriptionPackage->name ?? 'Paket' }}
                                            </span>
                                            <span class="badge text-white fw-medium"
                                                  style="background-color: #dc2626; border-radius: 6px; padding: 6px 12px; font-size: 12px;">
                                                Berlaku sd : {{ \Carbon\Carbon::parse($sub->expired_date)->format('d M Y') }}
                                            </span>
                                        </div>

                                        <div class="text-end">
                                            <div class="text-secondary small mb-1" style="font-size: 12px;">Total Pembayaran</div>
                                            <div class="fw-bold text-dark" style="font-size: 18px;">
                                                Rp {{ number_format($sub->subscriptionPackage->price ?? 0, 0, ',', '.') }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="text-center py-5 text-secondary border rounded-3" style="border-color: #e2e8f0 !important;">
                                    <i class="fa-solid fa-receipt fs-1 mb-2 d-block text-muted"></i>
                                    Belum ada riwayat transaksi paket langganan.
                                </div>
                            @endforelse
                        </div>

                        {{-- Daftar Transaksi Buku --}}
                        <div id="section-buku" style="display: none;">
                            @forelse ($checkouts as $checkout)
                                <div class="border rounded-3 p-4 mb-3 bg-white" style="border-color: #e2e8f0 !important;">
                                    <div class="d-flex justify-content-between align-items-center mb-4">
                                        <span class="text-secondary small" style="font-size: 13px;">
                                            {{ $checkout->created_at ? $checkout->created_at->format('d M Y, H:i') : '-' }}
                                        </span>
                                        <span class="badge fw-semibold"
                                              style="background-color: #e6f9ed; color: #16a34a; font-size: 12px; padding: 6px 14px; border-radius: 6px;">
                                            {{ $checkout->status == 'Done' ? 'Transaksi Sukses' : $checkout->status }}
                                        </span>
                                    </div>

                                    <div class="d-flex justify-content-between align-items-end flex-wrap gap-2">
                                        <div>
                                            <span class="fw-bold text-dark" style="font-size: 18px;">
                                                Pembelian {{ $checkout->total_book }} Buku
                                            </span>
                                            <div class="text-secondary small mt-1">Metode: {{ $checkout->payment_method }}</div>
                                        </div>

                                        <div class="text-end">
                                            <div class="text-secondary small mb-1" style="font-size: 12px;">Total Pembayaran</div>
                                            <div class="fw-bold text-dark" style="font-size: 18px;">
                                                Rp {{ number_format($checkout->total_price ?? 0, 0, ',', '.') }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="text-center py-5 text-secondary border rounded-3" style="border-color: #e2e8f0 !important;">
                                    <i class="fa-solid fa-book-open fs-1 mb-2 d-block text-muted"></i>
                                    Belum ada riwayat transaksi buku.
                                </div>
                            @endforelse
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        function switchTransaksi(jenis) {
            const secLangganan = document.getElementById('section-langganan');
            const secBuku = document.getElementById('section-buku');

            if (jenis === 'buku') {
                secLangganan.style.display = 'none';
                secBuku.style.display = 'block';
            } else {
                secLangganan.style.display = 'block';
                secBuku.style.display = 'none';
            }
        }
    </script>
@endpush
