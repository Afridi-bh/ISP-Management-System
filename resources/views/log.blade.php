@vite(['resources/css/app.css', 'resources/js/app.js'])

<x-app-layout>
    <div class="py-10 bg-gradient-to-br from-blue-600 via-purple-600 to-indigo-700 min-h-screen">

        <div class="max-w-7xl mx-auto px-6">

            <!-- Card -->
            <div class="bg-white/20 backdrop-blur-md border border-white/30 shadow-xl rounded-2xl p-8">

                <!-- Title + Error Message -->
                <div class="mb-6">
                    @if(session('error'))
                        <div class="mb-4 bg-red-500/20 border border-red-600 text-red-200 p-3 rounded-lg">
                            {{ session('error') }}
                        </div>
                    @endif

                    <h2 class="font-bold text-3xl text-white tracking-wide">
                        {{ __('Mikrotik Log') }}
                    </h2>
                    <p class="text-gray-200 mt-1">Real-time logs from your Mikrotik router</p>
                </div>

                <!-- Table Wrapper -->
                <div class="overflow-x-auto mt-6">
                    <table class="min-w-full border border-white/20 bg-white/10 backdrop-blur-md rounded-xl">

                        <thead>
                            <tr class="bg-white/20 text-white">
                                <th class="px-4 py-3 border border-white/20 text-left font-semibold">Time</th>
                                <th class="px-4 py-3 border border-white/20 text-left font-semibold">Topics</th>
                                <th class="px-4 py-3 border border-white/20 text-left font-semibold">Message</th>
                            </tr>
                        </thead>

                        <tbody class="text-gray-100">
                            @foreach($logs as $log)
                                <tr class="hover:bg-white/20 transition">
                                    <td class="border border-white/10 px-4 py-2">{{ $log['time'] }}</td>
                                    <td class="border border-white/10 px-4 py-2">{{ $log['topics'] }}</td>
                                    <td class="border border-white/10 px-4 py-2">{{ $log['message'] }}</td>
                                </tr>
                            @endforeach
                        </tbody>

                    </table>
                </div>

            </div>

        </div>

    </div>
</x-app-layout>
