<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard') - {{ config('app.name') }}</title>
    <link rel="icon" type="image/png" href="{{ asset('logo-pondok.png') }}">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    @stack('css')
    <style>
        :root {
            --primary-color: #3b82f6;
            --primary-hover: #2563eb;
            --bg-color: #f8fafc;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: var(--bg-color);
            scrollbar-width: none;
            -ms-overflow-style: none;
        }

        body::-webkit-scrollbar,
        *::-webkit-scrollbar {
            display: none;
        }

        * {
            scrollbar-width: none;
            -ms-overflow-style: none;
        }

        .navbar-custom {
            background: white;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        }

        .navbar-brand {
            font-weight: 700;
            color: var(--primary-color) !important;
        }

        .stat-card {
            background: white;
            border-radius: 16px;
            padding: 1.5rem;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
            border: 1px solid #f1f5f9;
        }

        .stat-icon {
            width: 50px;
            height: 50px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.25rem;
        }

        .stat-value {
            font-size: 2rem;
            font-weight: 700;
            color: #1e293b;
        }

        .stat-label {
            font-size: 0.85rem;
            color: #64748b;
        }

        .card-custom {
            background: white;
            border-radius: 16px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
            border: 1px solid #f1f5f9;
            overflow: hidden;
        }

        .card-header-custom {
            padding: 1.25rem;
            border-bottom: 1px solid #f1f5f9;
            font-weight: 600;
        }

        .main-content {
            margin-left: 250px;
            padding: 2rem;
            padding-top: 90px;
        }

        /* Mobile Responsive - Tablet */
        @media (max-width: 991px) {
            .main-content {
                margin-left: 0;
                padding: 1rem;
                padding-top: 80px;
            }

            .stat-card {
                padding: 1rem;
            }

            .stat-value {
                font-size: 1.5rem;
            }

            .stat-icon {
                width: 40px;
                height: 40px;
                font-size: 1rem;
            }

            .card-custom {
                border-radius: 12px;
            }

            .navbar-brand {
                font-size: 0.9rem;
            }

            .navbar-brand .me-2 {
                display: none;
            }

            .table-responsive {
                font-size: 0.85rem;
            }

            .btn-sm {
                padding: 0.25rem 0.5rem;
                font-size: 0.75rem;
            }

            .modal-dialog {
                margin: 0.5rem;
            }

            .modal-body {
                padding: 1rem !important;
            }

            .form-control-custom,
            .form-control,
            .form-select {
                font-size: 16px !important;
            }

            .card-custom.p-4 {
                padding: 1rem !important;
            }

            h4.fw-bold,
            .fw-bold.mb-4 {
                font-size: 1.25rem;
            }

            .row.g-4 {
                --bs-gutter-x: 1rem;
                --bs-gutter-y: 1rem;
            }
        }

        /* Mobile Responsive - Phone */
        @media (max-width: 767px) {
            .main-content {
                padding: 0.75rem;
                padding-top: 75px;
            }

            h4,
            .h4,
            h4.fw-bold {
                font-size: 1.1rem;
                margin-bottom: 0.75rem !important;
            }

            h5,
            .h5 {
                font-size: 1rem;
            }

            h6,
            .h6 {
                font-size: 0.9rem;
            }

            .card-custom {
                border-radius: 10px;
            }

            .card-custom.p-4,
            .card-custom.p-3 {
                padding: 0.875rem !important;
            }

            .stat-card {
                padding: 0.875rem;
            }

            .stat-value {
                font-size: 1.35rem;
            }

            .stat-label {
                font-size: 0.75rem;
            }

            .stat-icon {
                width: 36px;
                height: 36px;
                font-size: 0.9rem;
                border-radius: 8px;
            }

            .table {
                font-size: 0.8rem;
            }

            .table th,
            .table td {
                padding: 0.5rem 0.4rem;
            }

            .table-responsive {
                font-size: 0.8rem;
            }

            .btn {
                font-size: 0.85rem;
                padding: 0.4rem 0.75rem;
            }

            .btn-sm {
                font-size: 0.7rem;
                padding: 0.2rem 0.4rem;
            }

            .btn-lg {
                font-size: 0.95rem;
                padding: 0.5rem 1rem;
            }

            .form-label {
                font-size: 0.85rem;
                margin-bottom: 0.3rem;
            }

            .form-control,
            .form-select {
                font-size: 0.9rem;
                padding: 0.5rem 0.75rem;
            }

            .form-control-lg,
            .form-select-lg {
                font-size: 0.95rem;
                padding: 0.5rem 0.75rem;
            }

            .alert {
                font-size: 0.85rem;
                padding: 0.75rem;
            }

            .badge {
                font-size: 0.7rem;
                padding: 0.25rem 0.5rem;
            }

            .modal-dialog {
                margin: 0.5rem;
                max-width: calc(100% - 1rem);
            }

            .modal-header {
                padding: 0.875rem 1rem;
            }

            .modal-title {
                font-size: 1rem;
            }

            .modal-body {
                padding: 1rem !important;
            }

            .modal-footer {
                padding: 0.75rem 1rem;
            }

            .pagination {
                flex-wrap: wrap;
                justify-content: center;
                gap: 4px;
                margin: 0;
            }

            .pagination .page-item {
                margin: 0;
            }

            .pagination .page-link {
                padding: 0.4rem 0.75rem;
                font-size: 0.85rem;
                border-radius: 6px;
                border: 1px solid #e2e8f0;
                color: #64748b;
                background: white;
                transition: all 0.2s;
            }

            .pagination .page-link:hover {
                background: #f1f5f9;
                border-color: #cbd5e1;
                color: var(--primary-color);
            }

            .pagination .page-item.active .page-link {
                background: var(--primary-color);
                border-color: var(--primary-color);
                color: white;
            }

            .pagination .page-item.disabled .page-link {
                background: #f8fafc;
                color: #cbd5e1;
                cursor: not-allowed;
            }

            /* Simple pagination (Previous/Next links) */
            nav[role="navigation"] {
                display: flex;
                flex-wrap: wrap;
                align-items: center;
                justify-content: space-between;
                gap: 0.5rem;
            }

            nav[role="navigation"] > div {
                display: flex;
                flex-wrap: wrap;
                align-items: center;
                gap: 0.5rem;
            }

            nav[role="navigation"] a,
            nav[role="navigation"] span:not(.relative) {
                padding: 0.4rem 0.75rem;
                font-size: 0.85rem;
                border-radius: 6px;
                border: 1px solid #e2e8f0;
                color: #64748b;
                background: white;
                text-decoration: none;
                transition: all 0.2s;
            }

            nav[role="navigation"] a:hover {
                background: #f1f5f9;
                border-color: #cbd5e1;
                color: var(--primary-color);
            }

            nav[role="navigation"] span[aria-current="page"] span,
            nav[role="navigation"] .bg-blue-50 {
                background: var(--primary-color) !important;
                border-color: var(--primary-color) !important;
                color: white !important;
            }

            nav[role="navigation"] p {
                font-size: 0.85rem;
                color: #64748b;
                margin: 0;
            }

            @media (max-width: 640px) {
                nav[role="navigation"] {
                    flex-direction: column;
                    text-align: center;
                }
            }

            .row.g-4 {
                --bs-gutter-x: 0.75rem;
                --bs-gutter-y: 0.75rem;
            }

            .row.g-3 {
                --bs-gutter-x: 0.5rem;
                --bs-gutter-y: 0.5rem;
            }

            .d-flex.gap-2 {
                gap: 0.4rem !important;
            }

            .d-flex.gap-3 {
                gap: 0.5rem !important;
            }

            .filter-section .form-control,
            .filter-section .form-select {
                font-size: 0.85rem;
            }
        }

        /* Mobile Responsive - Small Phone */
        @media (max-width: 575px) {
            .main-content {
                padding: 0.5rem;
                padding-top: 70px;
            }

            h4,
            .h4,
            h4.fw-bold {
                font-size: 1rem;
            }

            .d-flex.justify-content-between {
                flex-direction: column !important;
                gap: 0.5rem !important;
                align-items: stretch !important;
            }

            .d-flex.justify-content-between .btn {
                width: 100%;
            }

            .btn-action-text {
                display: none;
            }

            .card-custom {
                border-radius: 8px;
            }

            .card-custom.p-4,
            .card-custom.p-3 {
                padding: 0.75rem !important;
            }

            .col-6 .stat-card,
            .col-sm-6 .stat-card {
                padding: 0.75rem;
            }

            .stat-value {
                font-size: 1.2rem;
            }

            .stat-label {
                font-size: 0.7rem;
            }

            .stat-icon {
                width: 32px;
                height: 32px;
                font-size: 0.8rem;
            }

            .table {
                font-size: 0.75rem;
            }

            .table th,
            .table td {
                padding: 0.4rem 0.3rem;
            }

            .btn {
                font-size: 0.8rem;
                padding: 0.35rem 0.6rem;
            }

            .btn-sm {
                font-size: 0.65rem;
                padding: 0.15rem 0.35rem;
            }

            .form-label {
                font-size: 0.8rem;
            }

            .form-control,
            .form-select {
                font-size: 0.85rem;
                padding: 0.4rem 0.6rem;
            }

            .mb-3 {
                margin-bottom: 0.75rem !important;
            }

            .mb-4 {
                margin-bottom: 1rem !important;
            }

            .alert {
                font-size: 0.8rem;
                padding: 0.6rem;
            }

            .alert ul {
                padding-left: 1.25rem;
                margin-bottom: 0;
            }

            .modal-dialog {
                margin: 0.25rem;
                max-width: calc(100% - 0.5rem);
            }

            .modal-header {
                padding: 0.75rem;
            }

            .modal-title {
                font-size: 0.95rem;
            }

            .modal-body {
                padding: 0.75rem !important;
            }

            .table .hide-xs {
                display: none !important;
            }

            .page-link {
                padding: 0.3rem 0.5rem;
                font-size: 0.75rem;
            }

            .row.g-4 {
                --bs-gutter-x: 0.5rem;
                --bs-gutter-y: 0.5rem;
            }
        }

        /* Hamburger button */
        .btn-hamburger {
            display: none;
            background: none;
            border: none;
            font-size: 1.25rem;
            color: var(--primary-color);
            padding: 0.5rem;
        }

        @media (max-width: 991px) {
            .btn-hamburger {
                display: block;
            }
        }

        /* Sortable Table Styles */
        .table-sortable thead th {
            cursor: pointer;
            user-select: none;
            position: relative;
            padding-right: 25px !important;
            transition: background-color 0.15s;
        }

        .table-sortable thead th:hover {
            background-color: #f1f5f9;
        }

        .table-sortable thead th::after {
            content: '\f0dc';
            font-family: 'Font Awesome 5 Free';
            font-weight: 900;
            position: absolute;
            right: 8px;
            top: 50%;
            transform: translateY(-50%);
            opacity: 0.3;
            font-size: 0.75rem;
        }

        .table-sortable thead th.sort-asc::after {
            content: '\f0de';
            opacity: 1;
            color: var(--primary-color);
        }

        .table-sortable thead th.sort-desc::after {
            content: '\f0dd';
            opacity: 1;
            color: var(--primary-color);
        }

        .table-sortable thead th.no-sort {
            cursor: default;
            padding-right: 12px !important;
        }

        .table-sortable thead th.no-sort::after {
            display: none;
        }
    </style>
    @stack('styles')
</head>

<body>
    <!-- Navbar -->
    @include('partials.header')

    <!-- Sidebar -->
    @include('partials.sidebar')

    <!-- Main Content -->
    <div class="main-content">
        @yield('content')
    </div>

    <!-- Scripts -->
    @include('partials.footer')
    @stack('scripts')

    <!-- Biometric Registration Modal -->
    @auth
    <div class="modal fade" id="biometricOfferModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg rounded-4" style="overflow: hidden;">
                <div class="modal-body text-center p-4">
                    <div style="width: 80px; height: 80px; background: linear-gradient(135deg, #10b981 0%, #059669 100%); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 1.5rem;">
                        <i class="fas fa-fingerprint text-white" style="font-size: 2.5rem;"></i>
                    </div>
                    <h5 class="fw-bold mb-2">Aktifkan Login Biometrik</h5>
                    <p class="text-muted mb-4">Login lebih cepat dan aman menggunakan sidik jari atau Face ID di perangkat ini.</p>
                    <button type="button" class="btn btn-success w-100 py-3 fw-bold rounded-3 mb-3" onclick="registerBiometric()">
                        <i class="fas fa-fingerprint me-2"></i> Ya, Aktifkan Sekarang
                    </button>
                    <button type="button" class="btn btn-light w-100 py-2 rounded-3" data-bs-dismiss="modal">
                        Nanti Saja
                    </button>
                    <div class="form-check mt-3">
                        <input class="form-check-input" type="checkbox" id="dontRemindAgain">
                        <label class="form-check-label text-muted small" for="dontRemindAgain">
                            Jangan ingatkan lagi
                        </label>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
    // WebAuthn Registration Script
    document.addEventListener('DOMContentLoaded', async function() {
        const isMobile = /Android|iPhone|iPad|iPod/i.test(navigator.userAgent);
        if (!isMobile) return;
        
        // Check WebAuthn support
        if (!window.PublicKeyCredential) return;
        
        try {
            const available = await PublicKeyCredential.isUserVerifyingPlatformAuthenticatorAvailable();
            if (!available) return;
            
            // Check if user needs to see the offer
            const res = await fetch('/api/webauthn/check-support');
            const data = await res.json();
            
            if (!data.has_credential && !data.reminder_dismissed) {
                // Show offer modal after short delay
                setTimeout(() => {
                    new bootstrap.Modal(document.getElementById('biometricOfferModal')).show();
                }, 1000);
            }
        } catch (e) {
            console.log('Error checking biometric:', e);
        }
    });

    // Handle modal dismiss
    document.getElementById('biometricOfferModal')?.addEventListener('hidden.bs.modal', async function() {
        if (document.getElementById('dontRemindAgain').checked) {
            await fetch('/api/webauthn/dismiss-reminder', { 
                method: 'POST',
                headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content }
            });
        }
    });

    async function registerBiometric() {
        try {
            // Get registration options
            const optRes = await fetch('/api/webauthn/register/options', {
                method: 'POST',
                headers: { 
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content 
                }
            });
            const optData = await optRes.json();
            
            if (optData.status !== 'success') {
                alert('Gagal mendapatkan opsi registrasi');
                return;
            }

            const publicKey = optData.publicKey;
            publicKey.challenge = base64UrlDecode(publicKey.challenge);
            publicKey.user.id = base64UrlDecode(publicKey.user.id);

            // Create credential
            const credential = await navigator.credentials.create({ publicKey });

            // Send to server
            const verifyRes = await fetch('/api/webauthn/register/verify', {
                method: 'POST',
                headers: { 
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content 
                },
                body: JSON.stringify({
                    id: credential.id,
                    response: {
                        clientDataJSON: base64UrlEncode(new Uint8Array(credential.response.clientDataJSON)),
                        attestationObject: base64UrlEncode(new Uint8Array(credential.response.attestationObject))
                    }
                })
            });

            const verifyData = await verifyRes.json();
            bootstrap.Modal.getInstance(document.getElementById('biometricOfferModal')).hide();
            
            if (verifyData.status === 'success') {
                alert('Biometrik berhasil didaftarkan! Selanjutnya Anda bisa login dengan sidik jari.');
            } else {
                alert(verifyData.message || 'Gagal mendaftarkan biometrik');
            }
        } catch (e) {
            console.error('Register biometric error:', e);
            if (e.name !== 'NotAllowedError') {
                alert('Gagal mendaftarkan: ' + e.message);
            }
        }
    }

    function base64UrlEncode(buffer) {
        let str = '';
        const bytes = new Uint8Array(buffer);
        for (let i = 0; i < bytes.length; i++) {
            str += String.fromCharCode(bytes[i]);
        }
        return btoa(str).replace(/\+/g, '-').replace(/\//g, '_').replace(/=/g, '');
    }

    function base64UrlDecode(str) {
        str = str.replace(/-/g, '+').replace(/_/g, '/');
        while (str.length % 4) str += '=';
        const binStr = atob(str);
        const bytes = new Uint8Array(binStr.length);
        for (let i = 0; i < binStr.length; i++) {
            bytes[i] = binStr.charCodeAt(i);
        }
        return bytes.buffer;
    }
    </script>
    @endauth
</body>

</html>