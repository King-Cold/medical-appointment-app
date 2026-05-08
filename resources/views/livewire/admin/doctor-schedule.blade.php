<div class="p-6">
    <div class="mb-6">
        <nav class="flex mb-4 text-sm text-gray-500" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-3">
                <li><a href="{{ route('admin.dashboard') }}" class="hover:text-blue-600">Dashboard</a></li>
                <li><i class="fa-solid fa-chevron-right mx-2 text-xs text-gray-400"></i> <a href="{{ route('admin.doctors.index') }}" class="hover:text-blue-600">Doctores</a></li>
                <li class="text-gray-900 font-semibold"><i class="fa-solid fa-chevron-right mx-2 text-xs text-gray-400"></i> Horario de {{ $doctor->user->name }}</li>
            </ol>
        </nav>
        <div class="flex justify-between items-center">
            <div>
                <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Gestión de Horarios</h2>
                <p class="text-sm text-gray-500 mt-1">Configura la disponibilidad semanal del Dr. {{ $doctor->user->name }}</p>
            </div>
            <button wire:click="save" class="text-white bg-indigo-600 hover:bg-indigo-700 focus:ring-4 focus:ring-indigo-300 font-medium rounded-lg text-sm px-5 py-2.5 transition shadow-sm">
                <i class="fa-solid fa-save mr-2"></i> Guardar Horario
            </button>
        </div>
    </div>

    @if(session('success'))
        <div class="p-4 mb-6 text-sm text-green-800 rounded-lg bg-green-50 dark:bg-gray-700 dark:text-green-400 border border-green-200 dark:border-green-800" role="alert">
            <span class="font-medium">¡Éxito!</span> {{ session('success') }}
        </div>
    @endif

    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-6 py-4 font-bold border-r dark:border-gray-600">Hora</th>
                        @foreach($days as $day)
                        <th scope="col" class="px-6 py-4 font-bold text-center border-r dark:border-gray-600">{{ $day }}</th>
                        @endforeach
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                    @foreach($hours as $hourKey => $intervals)
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition">
                        <td class="px-6 py-4 font-semibold text-gray-900 dark:text-white bg-gray-50/50 dark:bg-gray-700/30 border-r dark:border-gray-600">
                            <div class="flex items-center">
                                <span class="font-medium text-gray-900 text-base">{{ substr($hourKey, 0, 5) }}</span>
                            </div>
                        </td>
                        @foreach($days as $day)
                        <td class="px-6 py-4 align-top border-r dark:border-gray-600">
                            <div class="flex flex-col space-y-2">
                                @foreach($intervals as $interval)
                                <label class="flex items-center p-2 rounded hover:bg-indigo-50 dark:hover:bg-indigo-900/20 cursor-pointer transition">
                                    <input type="checkbox" wire:model="schedule.{{ $day }}.{{ $interval }}" class="w-4 h-4 text-indigo-600 bg-gray-100 border-gray-300 rounded focus:ring-indigo-500">
                                    <span class="ml-2 text-xs text-gray-600 dark:text-gray-400">{{ $interval }}</span>
                                </label>
                                @endforeach
                            </div>
                        </td>
                        @endforeach
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
