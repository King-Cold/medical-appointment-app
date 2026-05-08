<x-admin-layout title="Horarios | Healthify">

<div class="mb-4">
    <nav class="flex text-sm text-gray-500" aria-label="Breadcrumb">
        <ol class="inline-flex items-center space-x-1 md:space-x-3">
            <li><a href="{{ route('admin.dashboard') }}" class="hover:text-blue-600">Dashboard</a></li>
            <li><i class="fa-solid fa-chevron-right mx-2 text-xs text-gray-400"></i> <a href="{{ route('admin.doctors.index') }}" class="hover:text-blue-600">Doctores</a></li>
            <li class="text-gray-900 font-semibold"><i class="fa-solid fa-chevron-right mx-2 text-xs text-gray-400"></i> Horarios</li>
        </ol>
    </nav>
</div>

<!-- Central Form Container -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200">
            <div class="p-5 border-b border-gray-100 flex items-center justify-between">
                <h2 class="text-xl font-semibold text-gray-800">Gestor de horarios</h2>
                <button type="button" class="text-white bg-indigo-600 hover:bg-indigo-700 focus:ring-4 focus:ring-indigo-300 font-medium rounded-lg text-sm px-5 py-2.5 shadow-sm transition-colors duration-200">
                    Guardar horario
                </button>
            </div>
            
            <div class="p-0 overflow-x-auto">
                <table class="w-full text-sm text-left">
                    <thead class="text-xs text-gray-500 uppercase bg-white border-b border-gray-100">
                        <tr>
                            <th scope="col" class="px-6 py-4 font-medium min-w-[120px]">
                                DÍA/HORA
                            </th>
                            @foreach($days as $day)
                            <th scope="col" class="px-6 py-4 font-medium min-w-[180px]">
                                {{ strtoupper($day) }}
                            </th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach($hours as $hourKey => $intervals)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-6 whitespace-nowrap bg-white border-r border-gray-50">
                                <div class="flex items-center">
                                    <input type="checkbox" class="w-4 h-4 text-indigo-600 bg-gray-100 border-gray-300 rounded focus:ring-indigo-500 mr-3">
                                    <span class="font-medium text-gray-900 text-base">{{ $hourKey }}</span>
                                </div>
                            </td>
                            @foreach($days as $day)
                            <td class="px-6 py-4 align-top">
                                <div class="flex flex-col space-y-3">
                                    <div class="flex items-center mb-1">
                                        <input type="checkbox" class="w-4 h-4 text-indigo-600 bg-gray-100 border-gray-300 rounded focus:ring-indigo-500">
                                        <label class="ml-2 text-sm font-medium text-gray-700">Todos</label>
                                    </div>
                                    @foreach($intervals as $interval)
                                    <div class="flex items-center">
                                        <input type="checkbox" class="w-4 h-4 text-indigo-600 bg-gray-100 border-gray-300 rounded focus:ring-indigo-500" {{ rand(0, 10) > 8 ? 'checked' : '' }}>
                                        <label class="ml-2 text-sm text-gray-600">{{ $interval }}</label>
                                    </div>
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
</x-admin-layout>
