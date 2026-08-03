@extends('layouts.app')

@section('content')
<div class="bg-white py-10">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="flex flex-col md:flex-row gap-8">
            <div class="w-full md:w-2/3">
                <!-- Foto Utama (Rasio 16:9 di Mobile) -->
                <img id="main-image" src="{{ $room->foto }}" alt="{{ $room->nama }}" class="w-full aspect-video md:h-[400px] object-cover rounded-xl shadow-md transition-all duration-300">
                
                <!-- Thumbnails -->
                <div class="flex gap-3 mt-4 overflow-x-auto pb-2">
                    <img src="{{ $room->foto }}" onclick="changeMainImage('{{ $room->foto }}')" class="h-20 w-24 object-cover rounded-lg shadow-sm cursor-pointer border-2 border-transparent hover:border-blue-500 transition-colors">
                    @if($room->foto2)
                    <img src="{{ $room->foto2 }}" onclick="changeMainImage('{{ $room->foto2 }}')" class="h-20 w-24 object-cover rounded-lg shadow-sm cursor-pointer border-2 border-transparent hover:border-blue-500 transition-colors">
                    @endif
                    @if($room->foto3)
                    <img src="{{ $room->foto3 }}" onclick="changeMainImage('{{ $room->foto3 }}')" class="h-20 w-24 object-cover rounded-lg shadow-sm cursor-pointer border-2 border-transparent hover:border-blue-500 transition-colors">
                    @endif
                    @if($room->foto4)
                    <img src="{{ $room->foto4 }}" onclick="changeMainImage('{{ $room->foto4 }}')" class="h-20 w-24 object-cover rounded-lg shadow-sm cursor-pointer border-2 border-transparent hover:border-blue-500 transition-colors">
                    @endif
                    @if($room->foto5)
                    <img src="{{ $room->foto5 }}" onclick="changeMainImage('{{ $room->foto5 }}')" class="h-20 w-24 object-cover rounded-lg shadow-sm cursor-pointer border-2 border-transparent hover:border-blue-500 transition-colors">
                    @endif
                </div>
                
                <script>
                    function changeMainImage(src) {
                        document.getElementById('main-image').src = src;
                    }
                </script>
                
                <div class="mt-8">
                    <h2 class="text-3xl font-bold text-gray-800 mb-2">{{ $room->nama }}</h2>
                    <span class="inline-block bg-blue-100 text-blue-800 text-sm font-semibold px-3 py-1 rounded-full mb-4">{{ $room->tipe }}</span>
                    
                    <h3 class="text-xl font-semibold mb-2 mt-6">Fasilitas Utama</h3>
                    <ul class="list-disc list-inside text-gray-600 space-y-2">
                        @foreach(explode(',', $room->fasilitas) as $fasilitas)
                            <li>{{ trim($fasilitas) }}</li>
                        @endforeach
                        <li>Kapasitas maksimal: {{ $room->kapasitas }} Dewasa</li>
                    </ul>

                    <h3 class="text-xl font-semibold mb-2 mt-8">Kebijakan</h3>
                    <div class="bg-gray-50 p-4 rounded border border-gray-200 text-sm text-gray-600">
                        <p><strong>Check-in:</strong> 14:00 - 22:00</p>
                        <p><strong>Check-out:</strong> Sebelum 12:00</p>
                        <p class="mt-2 text-red-600">Pembatalan maksimal H-3 untuk refund 100%. Refund tidak berlaku jika dibatalkan kurang dari H-3.</p>
                    </div>
                </div>
            </div>

            <!-- Booking Widget -->
            <div class="w-full md:w-1/3">
                <div class="bg-white p-6 rounded-xl shadow-lg border border-gray-200 sticky top-24">
                    <p class="text-3xl font-bold text-red-600 mb-1" id="harga-display">Rp {{ number_format($room->harga_dasar, 0, ',', '.') }}</p>
                    <p class="text-gray-500 mb-4" id="harga-label">Per malam</p>

                    @if(session('error'))
                        <div class="mb-4 bg-red-100 text-red-700 p-2 rounded text-sm">
                            {{ session('error') }}
                        </div>
                    @endif

                    <form action="{{ route('checkout', $room->id) }}" method="GET">
                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2">Tipe Pesanan</label>
                            <select id="tipe-reservasi" name="tipe_reservasi" class="w-full border-gray-300 rounded p-3 text-gray-700 border focus:border-blue-500 focus:ring-1 focus:ring-blue-500 outline-none">
                                <option value="Menginap">Menginap (Per Malam)</option>
                                @if($room->harga_transit)
                                <option value="Transit">Transit (6 Jam)</option>
                                @endif
                            </select>
                        </div>
                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2" id="label-checkin">Tanggal Check-in</label>
                            <input type="text" id="checkin-date" name="checkin" class="w-full border-gray-300 rounded p-3 text-gray-700 border focus:border-blue-500 focus:ring-1 focus:ring-blue-500 outline-none" placeholder="Pilih Check-in">
                        </div>
                        <div class="mb-4" id="checkout-container">
                            <label class="block text-gray-700 text-sm font-bold mb-2">Tanggal Check-out</label>
                            <input type="text" id="checkout-date" name="checkout" class="w-full border-gray-300 rounded p-3 text-gray-700 border focus:border-blue-500 focus:ring-1 focus:ring-blue-500 outline-none" placeholder="Pilih Check-out">
                        </div>
                        <div class="mb-6">
                            <label class="block text-gray-700 text-sm font-bold mb-2">Jumlah Tamu</label>
                            <select name="guests" class="w-full border-gray-300 rounded p-3 text-gray-700 border focus:border-blue-500 focus:ring-1 outline-none">
                                @for($i = 1; $i <= max(1, $room->kapasitas); $i++)
                                    <option value="{{ $i }}">{{ $i }} Orang Dewasa</option>
                                @endfor
                            </select>
                        </div>
                        <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-4 rounded text-lg transition duration-200">
                            Pesan Sekarang
                        </button>
                    </form>
                    <p class="text-center text-sm text-gray-400 mt-4">Anda belum akan dikenakan biaya pada tahap ini</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    const tipeSelect = document.getElementById('tipe-reservasi');
    const checkoutContainer = document.getElementById('checkout-container');
    const labelCheckin = document.getElementById('label-checkin');
    const hargaDisplay = document.getElementById('harga-display');
    const hargaLabel = document.getElementById('harga-label');
    const hargaDasar = {{ $room->harga_dasar }};
    const hargaTransit = {{ $room->harga_transit ?? 0 }};

    function calculateDynamicTotal() {
        if (tipeSelect.value === 'Transit') return;
        
        const checkinVal = document.getElementById('checkin-date').value;
        const checkoutVal = document.getElementById('checkout-date').value;
        
        if (checkinVal && checkoutVal) {
            const d1 = new Date(checkinVal);
            const d2 = new Date(checkoutVal);
            const timeDiff = d2.getTime() - d1.getTime();
            let days = Math.ceil(timeDiff / (1000 * 3600 * 24));
            if (isNaN(days) || days < 1) days = 1;
            
            const total = hargaDasar * days;
            hargaDisplay.innerText = 'Rp ' + total.toLocaleString('id-ID');
            hargaLabel.innerText = 'Total (' + days + ' Malam)';
        }
    }

    let checkinPicker = flatpickr("#checkin-date", {
        minDate: "today",
        dateFormat: "Y-m-d",
        onChange: function(selectedDates, dateStr, instance) {
            checkoutPicker.set('minDate', dateStr);
            calculateDynamicTotal();
        }
    });
    
    let checkoutPicker = flatpickr("#checkout-date", {
        minDate: "today",
        dateFormat: "Y-m-d",
        onChange: function(selectedDates, dateStr, instance) {
            calculateDynamicTotal();
        }
    });

    function updateFormMode() {
        if(tipeSelect.value === 'Transit') {
            checkoutContainer.style.display = 'none';
            labelCheckin.innerText = 'Waktu Check-in';
            hargaDisplay.innerText = 'Rp ' + hargaTransit.toLocaleString('id-ID');
            hargaLabel.innerText = 'Per 6 jam';
            
            // Re-init flatpickr to datetime
            checkinPicker.destroy();
            checkinPicker = flatpickr("#checkin-date", {
                enableTime: true,
                time_24hr: true,
                minDate: "today",
                dateFormat: "Y-m-d H:i",
            });
        } else {
            checkoutContainer.style.display = 'block';
            labelCheckin.innerText = 'Tanggal Check-in';
            hargaDisplay.innerText = 'Rp ' + hargaDasar.toLocaleString('id-ID');
            hargaLabel.innerText = 'Per malam';

            // Re-init flatpickr to date only
            checkinPicker.destroy();
            checkinPicker = flatpickr("#checkin-date", {
                enableTime: false,
                minDate: "today",
                dateFormat: "Y-m-d",
                onChange: function(selectedDates, dateStr, instance) {
                    checkoutPicker.set('minDate', dateStr);
                    calculateDynamicTotal();
                }
            });
            calculateDynamicTotal();
        }
    }

    tipeSelect.addEventListener('change', updateFormMode);
</script>
@endpush
