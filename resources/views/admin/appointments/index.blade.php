<x-admin-layout title="Citas Médicas">
    <div class="mb-4 px-6 pt-6">
        <nav class="flex text-sm text-gray-500" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-3">
                <li><a href="{{ route('admin.dashboard') }}" class="hover:text-blue-600">Dashboard</a></li>
                <li class="text-gray-900 font-semibold"><i class="fa-solid fa-chevron-right mx-2 text-xs text-gray-400"></i> Citas</li>
            </ol>
        </nav>
    </div>
    <div class="bg-white shadow-sm sm:rounded-lg dark:bg-gray-800 p-6 mx-6 mb-6">
        
        <div class="flex justify-between items-center mb-6 border-b pb-4 dark:border-gray-700">
            <div>
                <h2 class="text-2xl font-bold text-gray-800 dark:text-white">Citas Médicas</h2>
                <p class="text-sm text-gray-500 mt-1">Gestiona las citas médicas programadas del sistema.</p>
            </div>
            <a href="{{ route('admin.appointments.create') }}" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800 transition">
                <i class="fa-solid fa-plus mr-2"></i> Nueva Cita
            </a>
        </div>

        @if(session('success'))
            <div class="p-4 mb-6 text-sm text-green-800 rounded-lg bg-green-50 dark:bg-gray-700 dark:text-green-400 border border-green-200 dark:border-green-800" role="alert">
                <span class="font-medium">Éxito!</span> {{ session('success') }}
            </div>
        @endif

        <div class="relative overflow-x-auto shadow-sm sm:rounded-lg border border-gray-200 dark:border-gray-700">
            <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-6 py-3">Paciente</th>
                        <th scope="col" class="px-6 py-3">Doctor</th>
                        <th scope="col" class="px-6 py-3">Fecha</th>
                        <th scope="col" class="px-6 py-3">Hora de Inicio</th>
                        <th scope="col" class="px-6 py-3">Hora de Finalización</th>
                        <th scope="col" class="px-6 py-3">Estatus</th>
                        <th scope="col" class="px-6 py-3 text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($appointments as $appointment)
                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 transition">
                            <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                {{ $appointment->patient->user->name ?? 'N/A' }}
                            </th>
                            <td class="px-6 py-4">
                                {{ $appointment->doctor->user->name ?? 'N/A' }}
                            </td>
                            <td class="px-6 py-4">
                                {{ $appointment->date->format('d/m/Y') }}
                            </td>
                            <td class="px-6 py-4">
                                {{ \Carbon\Carbon::parse($appointment->start_time)->format('H:i') }}
                            </td>
                            <td class="px-6 py-4">
                                {{ \Carbon\Carbon::parse($appointment->start_time)->addMinutes(15)->format('H:i') }}
                            </td>
                            <td class="px-6 py-4">
                                @if($appointment->status == 1)
                                    <span class="bg-blue-100 text-blue-800 text-xs font-medium me-2 px-2.5 py-1 rounded dark:bg-blue-900 dark:text-blue-300"><i class="fa-regular fa-clock mr-1"></i> Programada</span>
                                @else
                                    <span class="bg-green-100 text-green-800 text-xs font-medium me-2 px-2.5 py-1 rounded dark:bg-green-900 dark:text-green-300"><i class="fa-solid fa-check mr-1"></i> Completada</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 flex justify-center space-x-3">
                                @include('admin.appointments.actions', ['appointment' => $appointment])
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-8 text-center text-gray-500 dark:text-gray-400">
                                <div class="flex flex-col items-center justify-center">
                                    <i class="fa-regular fa-calendar-xmark text-4xl mb-3 text-gray-400"></i>
                                    <p>No hay citas registradas.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
    </div>
</x-admin-layout>
