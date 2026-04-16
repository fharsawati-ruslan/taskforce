<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        @keyframes marquee {
            0% { transform: translateX(100%); }
            100% { transform: translateX(-100%); }
        }

        .marquee {
            display: inline-block;
            min-width: 100%;
            animation: marquee 20s linear infinite;
        }
    </style>
</head>

<body class="bg-gray-100">

<div class="min-h-screen flex flex-col items-center justify-center px-4">

    <!-- CLOCK -->
    <div class="text-center mb-6">
        <div id="clock" class="text-4xl md:text-5xl font-semibold text-gray-800"></div>
        <div id="date" class="text-base mt-2 text-gray-500"></div>
    </div>

    <!-- RUNNING TEXT -->
    <div class="w-full max-w-xl overflow-hidden whitespace-nowrap mb-8">
        <div class="marquee text-sm text-gray-600">
            🚀 PT Trinet Prima Solusi | Smart Monitoring | IoT | Command Center | Digital Transformation | Web & Mobile App Development | Reliable & Scalable System 🚀
        </div>
    </div>

    <!-- LOGIN CARD -->
    <div class="w-full max-w-md bg-white p-8 rounded-xl shadow">

        <h2 class="text-2xl font-semibold mb-6 text-center">
            Sign in
        </h2>

        <!-- FORM -->
        {{ $this->form }}

        <!-- BUTTON -->
        <div class="mt-6">
            {{ $this->getCachedFormActions()[0]->extraAttributes(['class' => 'w-full']) }}
        </div>

    </div>

</div>

<script>
function updateClock() {
    const now = new Date();

    const time = now.toLocaleTimeString('id-ID', {
        hour: '2-digit',
        minute: '2-digit',
        second: '2-digit'
    });

    const date = now.toLocaleDateString('id-ID', {
        weekday: 'long',
        year: 'numeric',
        month: 'long',
        day: 'numeric'
    });

    document.getElementById('clock').innerText = time;
    document.getElementById('date').innerText = date;
}

setInterval(updateClock, 1000);
updateClock();
</script>

</body>
</html>
