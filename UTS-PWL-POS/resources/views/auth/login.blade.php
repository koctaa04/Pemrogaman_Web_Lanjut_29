<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sign In</title>
    {{-- SweetAlert2 --}}
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #667eea, #764ba2);
            height: 100vh;
            display: flex;
            align-items: flex-start;
            justify-content: center;
            font-family: 'Segoe UI', sans-serif;
            overflow: hidden;
            padding-top: 80px;
        }

        .flip-container {
            perspective: 1000px;
            width: 400px;
            max-height: 550px;
        }

        .flipper {
            position: relative;
            width: 100%;
            height: 100%;
            transition: transform 0.6s;
            transform-style: preserve-3d;
        }

        .flip-container.flip .flipper {
            transform: rotateY(180deg);
        }

        .card-face {
            position: absolute;
            width: 100%;
            backface-visibility: hidden;
            padding: 2rem;
            border-radius: 1rem;
            background-color: white;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        }

        .card-front {
            z-index: 2;
        }

        .card-back {
            transform: rotateY(180deg);
        }

        /* Toggle Switch */
        .toggle-wrapper {
            display: flex;
            justify-content: center;
            align-items: center;
            margin-bottom: 1.5rem;
        }

        .switch-container {
            background: #e0e0e0;
            border-radius: 30px;
            padding: 5px;
            width: 200px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: relative;
            cursor: pointer;
        }

        .switch-label {
            flex: 1;
            text-align: center;
            font-weight: 500;
            z-index: 2;
            padding: 5px 0;
        }

        .switch-button {
            position: absolute;
            width: 50%;
            height: 100%;
            background-color: #0d6efd;
            border-radius: 30px;
            transition: left 0.4s ease;
            z-index: 1;
        }

        .switch-left .switch-button {
            left: 0;
        }

        .switch-right .switch-button {
            left: 50%;
        }

        .switch-label span {
            position: relative;
            z-index: 3;
            color: white;
        }
    </style>
</head>

<body>

    <div class="flip-container" id="flipCard">
        <div class="toggle-wrapper switch-left" id="formToggle">
            <div class="switch-container" onclick="toggleFlip()">
                <div class="switch-button"></div>
                <div class="switch-label"><span>Sign In</span></div>
                <div class="switch-label"><span>Sign Up</span></div>
            </div>
        </div>

        <div class="flipper">
            <!-- Sign In Card -->

            <div class="card-face card-front">
                <h3 class="text-center mb-3">Welcome Back! 👋</h3>
                <p class="text-center text-muted">Please login to your account</p>
                <form action="{{ url('login') }}" method="POST" id="form-login">
                    @csrf
                    <div class="mb-3">
                        <label for="username" class="form-label">Username</label>
                        <input type="text" name="username" class="form-control" id="username">
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" name="password" class="form-control" id="loginPassword">
                    </div>
                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary">Login</button>
                    </div>
                </form>
            </div>

            <!-- Sign Up Card -->
            <div class="card-face card-back">
                <h3 class="text-center mb-3">Join Us Today! 🎉</h3>
                <p class="text-center text-muted">Create your account in seconds</p>
                <form action="{{ url('register') }}" method="POST" id="form-register">
                    @csrf
                    <div class="mb-3">
                        <label for="level_id" class="form-label">Level</label>
                        <select id="level_id" name="level_id" class="form-control">
                            <option value="">Pilih Level</option>
                            @foreach ($levels as $level)
                                <option value="{{ $level->level_id }}">{{ $level->level_nama }}</option>
                            @endforeach
                        </select>
                        <small id="error-level_id" class="error-text text-danger"></small>
                    </div>
                    <div class="mb-3">
                        <label for="username" class="form-label">Username</label>
                        <input type="text" id="username" name="username" class="form-control" placeholder="Username"
                            required>
                        <small id="error-username" class="error-text text-danger"></small>
                    </div>

                    <div class="mb-3">
                        <label for="nama" class="form-label">Nama Lengkap</label>
                        <input type="text" id="nama" name="nama" class="form-control"
                            placeholder="Nama Lengkap" required>
                        <small id="error-nama" class="error-text text-danger"></small>
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" id="password" name="password" class="form-control"
                            placeholder="Password" required>
                        <small id="error-password" class="error-text text-danger"></small>
                    </div>

                    <div class="mb-3">
                        <label for="password_confirmation" class="form-label">Konfirmasi Password</label>
                        <input type="password" id="password_confirmation" name="password_confirmation"
                            class="form-control" placeholder="Konfirmasi Password" required>
                        <small id="error-password_confirmation" class="error-text text-danger"></small>
                    </div>
                    <div class="d-grid">
                        <button type="submit" class="btn btn-success">Register</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function toggleFlip() {
            const flipCard = document.getElementById('flipCard');
            const formToggle = document.getElementById('formToggle');

            flipCard.classList.toggle('flip');
            formToggle.classList.toggle('switch-left');
            formToggle.classList.toggle('switch-right');
        }
    </script>
    <!-- jQuery -->
    <script src="{{ asset('adminlte/plugins/jquery/jquery.min.js') }}"></script>
    <!-- jquery-validation -->
    <script src="{{ asset('adminlte/plugins/jquery-validation/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('adminlte/plugins/jquery-validation/additional-methods.min.js') }}"></script>
    <!-- SweetAlert2 -->
    <script src="{{ asset('adminlte/plugins/sweetalert2/sweetalert2.min.js') }}"></script>
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $(document).ready(function() {
            $("#form-login").validate({
                rules: {
                    username: {
                        required: true,
                        minlength: 4,
                        maxlength: 20
                    },
                    password: {
                        required: true,
                        minlength: 6,
                        maxlength: 20
                    }
                },
                submitHandler: function(form) { // ketika valid, maka bagian yg akan dijalankan
                    $.ajax({
                        url: form.action,
                        type: form.method,
                        data: $(form).serialize(),
                        success: function(response) {
                            if (response.status) { // jika sukses
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Berhasil',
                                    text: response.message,
                                }).then(function() {
                                    window.location = response.redirect;
                                });
                            } else { // jika error
                                $('.error-text').text('');
                                $.each(response.msgField, function(prefix, val) {
                                    $('#error-' + prefix).text(val[0]);
                                });
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Login gagal!',
                                    text: response.message
                                });
                            }
                        }
                    });
                    return false;
                },
                errorElement: 'span',
                errorPlacement: function(error, element) {
                    error.addClass('invalid-feedback');
                    element.closest('.input-group').append(error);
                },
                highlight: function(element, errorClass, validClass) {
                    $(element).addClass('is-invalid');
                },
                unhighlight: function(element, errorClass, validClass) {
                    $(element).removeClass('is-invalid');
                }
            });
            $('#form-register').on('submit', function(e) {
                e.preventDefault(); // cegah submit biasa

                var form = this;

                $.ajax({
                    url: $(form).attr('action'),
                    method: $(form).attr('method'),
                    data: $(form).serialize(),
                    dataType: 'json',
                    success: function(response) {
                        if (response.status) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Sukses!',
                                text: response.message
                            }).then(() => {
                                window.location.href = response.redirect;
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Registrasi Gagal!',
                                text: response.message
                            });
                        }
                    },
                    error: function(xhr) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Terjadi Kesalahan!',
                            text: 'Coba lagi nanti.'
                        });
                    }
                });
            });
        });
    </script>
    @if (session('logout_success'))
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil Logout',
                    text: '{{ session('logout_success') }}',
                    confirmButtonText: 'OK'
                }).then(function() {
                    window.location.href = "{{ url('/') }}";
                });
            });
        </script>
    @endif

</body>

</html>
