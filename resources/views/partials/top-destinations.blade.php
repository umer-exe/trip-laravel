{{--
    Top Destinations Component
    Showcases popular travel destinations
--}}

<section class="py-16 bg-gradient-to-b from-gray-50 to-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">Top Destinations Around the World</h2>
            <p class="text-lg text-gray-600">Explore the most sought-after travel spots</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            {{-- Destination Card 1 - Japan --}}
            <div class="relative group overflow-hidden rounded-lg shadow-lg h-64 cursor-pointer">
                <div class="absolute inset-0 bg-gradient-to-br from-pink-400 to-red-500"></div>
                <div class="absolute inset-0 bg-black opacity-30 group-hover:opacity-40 transition"></div>
                <div class="absolute inset-0 flex flex-col justify-end p-6 text-white">
                    <h3 class="text-2xl font-bold mb-2">Japan</h3>
                    <p class="text-sm opacity-90">Land of the Rising Sun</p>
                </div>
            </div>

            {{-- Destination Card 2 - Northern Pakistan --}}
            <div class="relative group overflow-hidden rounded-lg shadow-lg h-64 cursor-pointer">
                <div class="absolute inset-0 bg-gradient-to-br from-green-400 to-teal-500"></div>
                <div class="absolute inset-0 bg-black opacity-30 group-hover:opacity-40 transition"></div>
                <div class="absolute inset-0 flex flex-col justify-end p-6 text-white">
                    <h3 class="text-2xl font-bold mb-2">Northern Pakistan</h3>
                    <p class="text-sm opacity-90">Mountains & Valleys</p>
                </div>
            </div>

            {{-- Destination Card 3 - Europe --}}
            <div class="relative group overflow-hidden rounded-lg shadow-lg h-64 cursor-pointer">
                <div class="absolute inset-0 bg-gradient-to-br from-blue-400 to-indigo-600"></div>
                <div class="absolute inset-0 bg-black opacity-30 group-hover:opacity-40 transition"></div>
                <div class="absolute inset-0 flex flex-col justify-end p-6 text-white">
                    <h3 class="text-2xl font-bold mb-2">Europe</h3>
                    <p class="text-sm opacity-90">Historic Cities & Culture</p>
                </div>
            </div>

            {{-- Destination Card 4 - Dubai --}}
            <div class="relative group overflow-hidden rounded-lg shadow-lg h-64 cursor-pointer">
                <div class="absolute inset-0 bg-gradient-to-br from-yellow-400 to-orange-500"></div>
                <div class="absolute inset-0 bg-black opacity-30 group-hover:opacity-40 transition"></div>
                <div class="absolute inset-0 flex flex-col justify-end p-6 text-white">
                    <h3 class="text-2xl font-bold mb-2">Dubai</h3>
                    <p class="text-sm opacity-90">Luxury & Innovation</p>
                </div>
            </div>

            {{-- Destination Card 5 - Thailand --}}
            <div class="relative group overflow-hidden rounded-lg shadow-lg h-64 cursor-pointer">
                <div class="absolute inset-0 bg-gradient-to-br from-purple-400 to-pink-500"></div>
                <div class="absolute inset-0 bg-black opacity-30 group-hover:opacity-40 transition"></div>
                <div class="absolute inset-0 flex flex-col justify-end p-6 text-white">
                    <h3 class="text-2xl font-bold mb-2">Thailand</h3>
                    <p class="text-sm opacity-90">Tropical Paradise</p>
                </div>
            </div>

            {{-- Destination Card 6 - Coastal Pakistan --}}
            <div class="relative group overflow-hidden rounded-lg shadow-lg h-64 cursor-pointer">
                <div class="absolute inset-0 bg-gradient-to-br from-cyan-400 to-blue-500"></div>
                <div class="absolute inset-0 bg-black opacity-30 group-hover:opacity-40 transition"></div>
                <div class="absolute inset-0 flex flex-col justify-end p-6 text-white">
                    <h3 class="text-2xl font-bold mb-2">Coastal Pakistan</h3>
                    <p class="text-sm opacity-90">Beaches & Serenity</p>
                </div>
            </div>
        </div>
    </div>
</section>
