<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>OTP Verification</title>

    <style>
        body {
            font-family: Arial, sans-serif;

            background:
                linear-gradient(rgba(30, 58, 138, 0.8), rgba(59, 130, 246, 0.8)),
                url('https://images.unsplash.com/photo-1551288049-bebda4e38f71');

            background-size: cover;
            background-position: center;

            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .card {
            background: rgba(255, 255, 255, 0.95);
            padding: 35px;
            border-radius: 12px;
            text-align: center;
            width: 360px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.3);
            backdrop-filter: blur(5px);
        }

        .title {
            font-weight: bold;
            font-size: 20px;
            margin-bottom: 5px;
        }

        .subtitle {
            color: #666;
            font-size: 14px;
            margin-bottom: 10px;
        }

        .datetime {
            font-size: 13px;
            color: #555;
            margin-bottom: 15px;
        }

        .otp-info {
            font-size: 13px;
            color: #666;
            margin-bottom: 15px;
        }

        .otp-container {
            display: flex;
            justify-content: center;
        }

        .otp-input {
            width: 45px;
            height: 45px;
            font-size: 20px;
            text-align: center;
            margin: 5px;
            border-radius: 8px;
            border: 1px solid #ccc;
            transition: 0.2s;
        }

        .otp-input:focus {
            border-color: #2563eb;
            outline: none;
            box-shadow: 0 0 5px rgba(37, 99, 235, 0.7);
        }

        .btn {
            background: #2563eb;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 6px;
            cursor: pointer;
            width: 100%;
        }

        .btn:hover {
            background: #1d4ed8;
        }

        .error {
            color: red;
            margin-bottom: 10px;
            font-size: 13px;
        }

        .footer {
            font-size: 12px;
            color: gray;
            margin-top: 20px;
        }

        .wa-btn {
            display: inline-block;
            background: #25D366;
            color: white;
            padding: 10px 15px;
            border-radius: 6px;
            text-decoration: none;
            font-size: 14px;
        }

        .wa-btn:hover {
            background: #1ebe5d;
        }
    </style>
</head>

<body>

    <div class="card">

        <div class="title">TRINET PRIMA SOLUSI SYSTEM</div>

        <div class="subtitle">
            Masukkan kode OTP yang telah dikirim ke email Anda
        </div>

        <!-- 🕒 LIVE DATE TIME -->
        <div id="datetime" class="datetime"></div>

        <!-- ⏱ OTP INFO -->
        <div class="otp-info">
            ⏱ OTP berlaku selama <b>5 menit</b>
        </div>

        @if ($errors->any())
            <div class="error">
                {{ $errors->first() }}
            </div>
        @endif

        <form method="POST" action="{{ route('otp.verify') }}">
            @csrf

            <div class="otp-container">
                @for ($i = 0; $i < 6; $i++)
                    <input type="text" maxlength="1" class="otp-input" name="otp[]" required>
                @endfor
            </div>

            <br>
            <button class="btn" type="submit">Verifikasi</button>
        </form>

        <div class="footer">
            Jika mengalami kendala, hubungi <b>Developer Trinet</b><br><br>

            <a href="https://wa.me/6282297408146?text=Halo%20Developer%20Trinet,%20saya%20mengalami%20kendala%20OTP"
                target="_blank" class="wa-btn">
                💬 Hubungi via WhatsApp
            </a>

            <br><br>
            © {{ date('Y') }} PT Trinet Prima Solusi
        </div>

    </div>

    <script>
        const inputs = document.querySelectorAll('.otp-input');

        // Auto move + backspace
        inputs.forEach((input, index) => {

            input.addEventListener('input', () => {
                if (input.value.length === 1 && index < inputs.length - 1) {
                    inputs[index + 1].focus();
                }
            });

            input.addEventListener('keydown', (e) => {
                if (e.key === "Backspace" && !input.value && index > 0) {
                    inputs[index - 1].focus();
                }
            });

        });

        // Paste full OTP
        inputs[0].addEventListener('paste', function (e) {
            let pasteData = e.clipboardData.getData('text').trim();
            if (pasteData.length === inputs.length) {
                inputs.forEach((input, i) => {
                    input.value = pasteData[i];
                });
            }
        });

        // 🕒 Live DateTime
        function updateDateTime() {
            const now = new Date();

            const date = now.toLocaleDateString('id-ID', {
                weekday: 'long',
                year: 'numeric',
                month: 'long',
                day: 'numeric'
            });

            const time = now.toLocaleTimeString('id-ID');

            document.getElementById('datetime').innerHTML =
                `📅 ${date} <br> ⏰ ${time}`;
        }

        setInterval(updateDateTime, 1000);
        updateDateTime();
    </script>

</body>

</html>