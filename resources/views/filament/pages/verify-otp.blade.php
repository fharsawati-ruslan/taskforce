<x-filament-panels::page>
    <div class="max-w-md mx-auto text-center">

        <h2 class="text-xl font-bold mb-4">Verifikasi OTP</h2>

        <form wire:submit.prevent="verify">

            <!-- INPUT OTP -->
            <input type="text" wire:model.defer="otp"
                class="border rounded p-3 w-full mb-4 text-center text-2xl tracking-widest" placeholder="Masukkan OTP">

            <!-- ERROR -->
            @error('otp')
                <div class="text-red-500 mb-2">{{ $message }}</div>
            @enderror

            <!-- BUTTON -->
            <button type="submit" class="bg-primary-600 text-white px-4 py-2 rounded w-full">
                Verifikasi OTP
            </button>

        </form>

    </div>
</x-filament-panels::page>