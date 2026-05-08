<div>
    <div class="p-4 sm:p-6">
        <nav class="flex mb-4 text-sm text-gray-500" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-3">
                <li><a href="{{ route('admin.dashboard') }}" class="hover:text-blue-600">Dashboard</a></li>
                <li><i class="fa-solid fa-chevron-right mx-2 text-xs text-gray-400"></i> <a href="{{ route('admin.appointments.index') }}" class="hover:text-blue-600">Citas</a></li>
                <li class="text-gray-900 font-semibold"><i class="fa-solid fa-chevron-right mx-2 text-xs text-gray-400"></i> {{ isset($appointment) ? 'Editar' : 'Nuevo' }}</li>
            </ol>
        </nav>
        <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-6">{{ isset($appointment) ? 'Editar Cita' : 'Nuevo' }}</h2>

        <form wire:submit.prevent="save">
            <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">
                
                <div class="lg:col-span-3 space-y-6">
                    
                    <div class="bg-white dark:bg-gray-800 p-6 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700">
                        <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-1">Buscar disponibilidad</h3>
                        <p class="text-sm text-gray-500 mb-4">Encuentra el horario perfecto para tu cita.</p>
                        
                        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 items-end">
                            <div>
                                <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Fecha</label>
                                <input type="date" wire:model.live="date" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                            </div>
                            <div>
                                <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Hora (opcional)</label>
                                <select class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                                    <option value="">Todas</option>
                                    <option value="morning">Mañana (08:00 - 12:00)</option>
                                    <option value="afternoon">Tarde (12:00 - 18:00)</option>
                                </select>
                            </div>
                            <div>
                                <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Especialidad</label>
                                <select wire:model.live="specialty" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                                    <option value="">Todas</option>
                                    @foreach($specialties as $spec)
                                        <option value="{{ $spec }}">{{ $spec }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <button type="button" class="text-white bg-indigo-600 hover:bg-indigo-700 focus:ring-4 focus:ring-indigo-300 font-medium rounded-lg text-sm px-5 py-2.5 transition">
                                Buscar disponibilidad
                            </button>
                        </div>
                    </div>

                    <div class="space-y-4">
                        @if(count($doctors) == 0)
                            <div class="bg-white p-6 rounded-xl border border-gray-200 text-center text-gray-500">
                                No se encontraron doctores disponibles para esta fecha y especialidad.
                            </div>
                        @else
                            @foreach($doctors as $doctor)
                            <div class="bg-white dark:bg-gray-800 p-6 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 flex flex-col sm:flex-row items-start sm:space-x-4 transition-all duration-300 hover:shadow-md {{ $selectedDoctorId == $doctor->id ? 'ring-2 ring-indigo-500 border-indigo-500' : '' }}">
                                <div class="flex-shrink-0 w-14 h-14 bg-indigo-100 text-indigo-600 rounded-full flex items-center justify-center font-bold text-xl mb-4 sm:mb-0">
                                    {{ strtoupper(substr($doctor->user->name, 0, 1)) }}
                                </div>
                                <div class="flex-1 w-full">
                                    <h4 class="text-lg font-bold text-gray-900 dark:text-white">Dr. {{ $doctor->user->name }}</h4>
                                    <p class="text-sm text-indigo-600 font-medium mb-4">{{ $doctor->specialty }}</p>
                                    
                                    <div class="border-t border-gray-100 my-4"></div>

                                    <p class="text-sm font-semibold text-gray-900 dark:text-white mb-3">Horarios disponibles:</p>
                                    <div class="flex flex-wrap gap-2">
                                        @foreach($doctor->available_times as $time)
                                        @php
                                            $isSelected = ($selectedDoctorId == $doctor->id && $selectedTime == $time);
                                        @endphp
                                        <button 
                                            type="button"
                                            wire:click="selectTime({{ $doctor->id }}, '{{ $time }}')"
                                            class="px-4 py-2 rounded-lg text-sm font-medium border transition-colors {{ $isSelected ? 'bg-indigo-600 text-white border-indigo-600 shadow-md' : 'bg-white text-gray-700 border-gray-300 hover:border-indigo-400 hover:text-indigo-600' }}">
                                            {{ substr($time, 0, 5) }}
                                        </button>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        @endif
                    </div>
                </div>

                <div class="lg:col-span-1">
                    <div class="bg-white dark:bg-gray-800 p-6 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 sticky top-20">
                        <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4">Resumen de la cita</h3>
                        
                        <div class="space-y-4 text-sm mb-6 bg-gray-50 p-4 rounded-lg border border-gray-100">
                            <div class="flex justify-between items-center border-b border-gray-200 pb-2">
                                <span class="text-gray-500 font-medium">Doctor:</span>
                                <span class="font-bold text-gray-900">{{ $this->selectedDoctor ? 'Dr. ' . $this->selectedDoctor->user->name : '--' }}</span>
                            </div>
                            <div class="flex justify-between items-center border-b border-gray-200 pb-2">
                                <span class="text-gray-500 font-medium">Fecha:</span>
                                <span class="font-bold text-gray-900">{{ Carbon\Carbon::parse($date)->format('d M, Y') }}</span>
                            </div>
                            <div class="flex justify-between items-center border-b border-gray-200 pb-2">
                                <span class="text-gray-500 font-medium">Horario:</span>
                                @if($selectedTime)
                                    @php
                                        $endTime = Carbon\Carbon::parse($selectedTime)->addMinutes(15)->format('H:i');
                                        $startTime = substr($selectedTime, 0, 5);
                                    @endphp
                                    <span class="font-bold text-indigo-600">{{ $startTime }} - {{ $endTime }}</span>
                                @else
                                    <span class="font-bold text-gray-900">--</span>
                                @endif
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-gray-500 font-medium">Duración:</span>
                                <span class="font-bold text-gray-900">15 minutos</span>
                            </div>
                        </div>

                        <div class="space-y-4">
                            <div>
                                <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Paciente <span class="text-red-500">*</span></label>
                                <select wire:model="patient_id" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-indigo-500 focus:border-indigo-500 block w-full p-2.5">
                                    <option value="">Seleccione un paciente</option>
                                    @foreach($patients as $patient)
                                        <option value="{{ $patient->id }}">{{ $patient->user->name }}</option>
                                    @endforeach
                                </select>
                                @error('patient_id') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                            </div>

                            <div>
                                <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Motivo de la cita</label>
                                <textarea wire:model="reason" rows="4" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-indigo-500 focus:border-indigo-500" placeholder="Escriba el motivo..."></textarea>
                            </div>

                            <button type="submit" class="w-full text-white bg-indigo-600 hover:bg-indigo-700 focus:ring-4 focus:ring-indigo-300 font-medium rounded-lg text-sm px-5 py-3 transition shadow-md disabled:opacity-50" {{ !$selectedDoctorId || !$selectedTime ? 'disabled' : '' }}>
                                {{ isset($appointment) ? 'Actualizar cita' : 'Confirmar cita' }}
                            </button>
                            @if(!$selectedDoctorId || !$selectedTime)
                                <p class="text-xs text-center text-gray-500 mt-2">Seleccione un doctor y horario primero</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
