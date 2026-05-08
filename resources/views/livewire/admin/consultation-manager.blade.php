<div class="bg-white shadow-sm sm:rounded-lg dark:bg-gray-800 p-6">
    <div class="flex justify-between items-center mb-6 border-b pb-4 dark:border-gray-700">
        <div>
            <h2 class="text-2xl font-bold text-gray-800 dark:text-white">Consulta Médica</h2>
            <p class="text-gray-600 dark:text-gray-400 mt-1">Paciente: <span class="font-semibold">{{ $appointment->patient->user->name ?? 'N/A' }}</span></p>
            <p class="text-sm text-gray-500 dark:text-gray-500 mt-1"><i class="fa-regular fa-calendar mr-1"></i> Fecha: {{ $appointment->date->format('d/m/Y') }} | <i class="fa-regular fa-clock mr-1"></i> Hora: {{ $appointment->start_time }}</p>
        </div>
        <div class="flex space-x-2">
            <button wire:click="openMedicalSummary" class="text-gray-900 bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-100 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-gray-800 dark:text-white dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-600 dark:focus:ring-gray-700 transition shadow-sm">
                <i class="fa-solid fa-file-medical mr-2 text-blue-600"></i> Ver Historia
            </button>
            <button wire:click="loadHistory" class="text-gray-900 bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-100 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-gray-800 dark:text-white dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-600 dark:focus:ring-gray-700 transition shadow-sm">
                <i class="fa-solid fa-clock-rotate-left mr-2 text-indigo-600"></i> Consultas Anteriores
            </button>
        </div>
    </div>

    @if (session()->has('message'))
        <div class="p-4 mb-6 text-sm text-green-800 rounded-lg bg-green-50 dark:bg-gray-700 dark:text-green-400 border border-green-200 dark:border-green-800" role="alert">
            <span class="font-medium">Éxito!</span> {{ session('message') }}
        </div>
    @endif

    <div class="bg-gray-50 dark:bg-gray-900 border border-gray-200 dark:border-gray-700 shadow-sm rounded-lg overflow-hidden">
        <!-- Tabs Navigation -->
        <div class="border-b border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800">
            <ul class="flex flex-wrap -mb-px text-sm font-medium text-center text-gray-500 dark:text-gray-400">
                <li class="me-2">
                    <button wire:click="setTab('consulta')" class="inline-flex items-center justify-center p-4 border-b-2 rounded-t-lg group {{ $activeTab === 'consulta' ? 'text-blue-600 border-blue-600 dark:text-blue-500 dark:border-blue-500 bg-gray-50 dark:bg-gray-900' : 'border-transparent hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300' }}">
                        <i class="fa-solid fa-stethoscope mr-2"></i> Consulta
                    </button>
                </li>
                <li class="me-2">
                    <button wire:click="setTab('receta')" class="inline-flex items-center justify-center p-4 border-b-2 rounded-t-lg group {{ $activeTab === 'receta' ? 'text-blue-600 border-blue-600 dark:text-blue-500 dark:border-blue-500 bg-gray-50 dark:bg-gray-900' : 'border-transparent hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300' }}">
                        <i class="fa-solid fa-pills mr-2"></i> Receta
                    </button>
                </li>
            </ul>
        </div>

        <div class="p-6">
            <!-- Tab: Consulta -->
            @if($activeTab === 'consulta')
                <div class="space-y-6">
                    <div>
                        <label for="diagnosis" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Diagnóstico</label>
                        <textarea wire:model="diagnosis" id="diagnosis" rows="4" class="block p-2.5 w-full text-sm text-gray-900 bg-white rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-800 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 shadow-sm" placeholder="Escriba el diagnóstico..."></textarea>
                    </div>
                    <div>
                        <label for="treatment" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Tratamiento</label>
                        <textarea wire:model="treatment" id="treatment" rows="4" class="block p-2.5 w-full text-sm text-gray-900 bg-white rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-800 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 shadow-sm" placeholder="Describa el tratamiento sugerido..."></textarea>
                    </div>
                    <div>
                        <label for="notes" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Notas Adicionales</label>
                        <textarea wire:model="notes" id="notes" rows="3" class="block p-2.5 w-full text-sm text-gray-900 bg-white rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-800 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 shadow-sm" placeholder="Observaciones adicionales..."></textarea>
                    </div>
                </div>
            @endif

            <!-- Tab: Receta -->
            @if($activeTab === 'receta')
                <div class="space-y-6">
                    <div class="bg-white dark:bg-gray-800 p-5 rounded-lg border border-gray-200 dark:border-gray-700 shadow-sm">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4"><i class="fa-solid fa-plus-circle text-blue-600 mr-2"></i>Añadir Medicamento</h3>
                        <div class="grid gap-4 md:grid-cols-3">
                            <div>
                                <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Medicamento</label>
                                <input type="text" wire:model="medicationName" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white shadow-sm" placeholder="Ej: Paracetamol 500mg">
                                @error('medicationName') <span class="text-xs text-red-600">{{ $message }}</span> @enderror
                            </div>
                            <div>
                                <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Dosis</label>
                                <input type="text" wire:model="dosage" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white shadow-sm" placeholder="Ej: 1 pastilla">
                                @error('dosage') <span class="text-xs text-red-600">{{ $message }}</span> @enderror
                            </div>
                            <div>
                                <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Frecuencia / Duración</label>
                                <div class="flex">
                                    <input type="text" wire:model="frequency" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-none rounded-s-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white shadow-sm" placeholder="Ej: Cada 8 hrs por 5 días">
                                    <button wire:click="addMedication" class="inline-flex items-center px-4 text-sm font-medium text-white bg-blue-600 border border-blue-600 rounded-e-lg hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800 transition">
                                        <i class="fa-solid fa-plus mr-1"></i> Añadir
                                    </button>
                                </div>
                                @error('frequency') <span class="text-xs text-red-600">{{ $message }}</span> @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Lista de medicamentos -->
                    @if(count($prescriptions) > 0)
                        <div class="relative overflow-x-auto shadow-sm sm:rounded-lg border border-gray-200 dark:border-gray-700">
                            <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                    <tr>
                                        <th scope="col" class="px-6 py-3">Medicamento</th>
                                        <th scope="col" class="px-6 py-3">Dosis</th>
                                        <th scope="col" class="px-6 py-3">Frecuencia</th>
                                        <th scope="col" class="px-6 py-3 w-20 text-center">Acción</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($prescriptions as $index => $prescription)
                                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 transition">
                                            <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                                {{ $prescription['name'] }}
                                            </th>
                                            <td class="px-6 py-4">{{ $prescription['dosage'] }}</td>
                                            <td class="px-6 py-4">{{ $prescription['frequency'] }}</td>
                                            <td class="px-6 py-4 text-center">
                                                <button wire:click="removeMedication({{ $index }})" class="text-red-600 hover:text-red-800 dark:text-red-500 dark:hover:text-red-400 focus:outline-none transition" title="Eliminar medicamento">
                                                    <i class="fa-solid fa-trash"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-8 text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 shadow-sm">
                            <i class="fa-solid fa-pills text-3xl mb-3 text-gray-300 dark:text-gray-600"></i>
                            <p>No hay medicamentos en la receta actual.</p>
                        </div>
                    @endif
                </div>
            @endif
            
            <div class="mt-8 pt-6 flex justify-end">
                <button wire:click="saveConsultation" class="text-white bg-indigo-600 hover:bg-indigo-700 focus:ring-4 focus:ring-indigo-300 font-medium rounded-lg text-sm px-6 py-3 dark:bg-indigo-600 dark:hover:bg-indigo-700 focus:outline-none dark:focus:ring-indigo-800 shadow-md transition">
                    <i class="fa-solid fa-save mr-2"></i> Guardar Consulta
                </button>
            </div>
        </div>
    </div>

    <!-- Modal Consultas Anteriores -->
    @if($showHistoryModal)
        <div class="fixed inset-0 z-50 flex items-center justify-center overflow-y-auto overflow-x-hidden bg-gray-900 bg-opacity-60 backdrop-blur-sm transition-opacity">
            <div class="relative p-4 w-full max-w-4xl max-h-full">
                <!-- Modal content -->
                <div class="relative bg-white rounded-xl shadow-2xl dark:bg-gray-800">
                    <!-- Modal header -->
                    <div class="flex items-center justify-between p-5 border-b rounded-t dark:border-gray-700 bg-gray-50 dark:bg-gray-800/50">
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white">
                            <i class="fa-solid fa-clock-rotate-left mr-2 text-indigo-600 dark:text-indigo-400"></i> Historial de Consultas: {{ $appointment->patient->user->name ?? 'N/A' }}
                        </h3>
                        <button wire:click="closeHistoryModal" type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white transition">
                            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                            </svg>
                            <span class="sr-only">Cerrar modal</span>
                        </button>
                    </div>
                    <!-- Modal body -->
                    <div class="p-6 space-y-5 max-h-[65vh] overflow-y-auto">
                        @forelse($pastConsultations as $past)
                            <div class="p-5 bg-white rounded-xl border border-gray-200 shadow-sm dark:bg-gray-900 dark:border-gray-700">
                                <div class="flex justify-between items-start mb-4 pb-3 border-b border-gray-100 dark:border-gray-800">
                                    <div>
                                        <h4 class="font-bold text-lg text-gray-900 dark:text-white flex items-center">
                                            <i class="fa-regular fa-calendar-check mr-2 text-blue-500"></i> 
                                            {{ $past->date->format('d/m/Y') }} a las {{ \Carbon\Carbon::parse($past->start_time)->format('H:i') }}
                                        </h4>
                                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400 mt-1">Atendido por: <span class="text-gray-700 dark:text-gray-300">{{ $past->doctor->user->name ?? 'N/A' }}</span></p>
                                    </div>
                                </div>
                                <div class="text-sm text-gray-700 dark:text-gray-300 space-y-2">
                                    <p><span class="font-semibold text-gray-900 dark:text-white">Diagnóstico:</span> {{ $past->diagnosis ?: 'No registrado' }}</p>
                                    <p><span class="font-semibold text-gray-900 dark:text-white">Tratamiento:</span> {{ $past->treatment ?: 'No registrado' }}</p>
                                    @if($past->notes)
                                        <p><span class="font-semibold text-gray-900 dark:text-white">Notas:</span> {{ $past->notes }}</p>
                                    @endif
                                    
                                    @if($past->prescriptions && count($past->prescriptions) > 0)
                                        <div class="mt-4 bg-gray-50 dark:bg-gray-800 rounded-lg p-4 border border-gray-100 dark:border-gray-700">
                                            <span class="font-semibold text-gray-900 dark:text-white flex items-center mb-2"><i class="fa-solid fa-prescription-bottle-medical mr-2"></i> Receta:</span>
                                            <ul class="list-disc pl-5 space-y-1 text-gray-600 dark:text-gray-400">
                                                @foreach($past->prescriptions as $med)
                                                    <li><span class="font-medium text-gray-800 dark:text-gray-200">{{ $med['name'] }}</span> - {{ $med['dosage'] }} ({{ $med['frequency'] }})</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-10">
                                <i class="fa-solid fa-folder-open text-4xl text-gray-300 dark:text-gray-600 mb-3"></i>
                                <p class="text-gray-500 dark:text-gray-400">No hay consultas anteriores registradas.</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
