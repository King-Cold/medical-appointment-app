@php
    // MAPEO DE ERRORES: Agrupamos los campos del formulario por pestaña.
    // Esto nos permite saber qué campos disparan qué pestaña de error.
    $errorGrups = [
        'datos-personales' => ['name', 'email', 'phone', 'address'],
        'antecedentes' => ['allergies', 'chronic_conditions', 'family_history', 'surgical_history'],
        'informacion-general' => ['blood_type_id', 'observations'],
        'contacto-emergencia' => ['emergency_contact_name', 'emergency_contact_phone', 'emergency_contact_relationship'],
    ];

    // LÓGICA DE PERSISTENCIA:
    // Si la validación falla, buscamos el primer error y activamos esa pestaña automáticamente.
    $initialTab = 'datos-personales';
    foreach ($errorGrups as $tabName => $fields) {
        if ($errors->hasAny($fields)) {
            $initialTab = $tabName;
            break; // Detenemos el ciclo al encontrar el primer grupo con errores.
        }
    }
@endphp

<x-admin-layout title="Editar Paciente" :breadcrumbs="[
    ['name' => 'Dashboard', 'href' => route('admin.dashboard')],
    ['name' => 'Pacientes', 'href' => route('admin.roles.index')],
    ['name' => 'Editar'],
]">

    <form action="{{ route('admin.patients.update', $patient) }}" method="POST">
        @csrf
        @method('PUT')

        {{-- Encabezado: Se mantiene fuera de los tabs porque es información fija del paciente --}}
        <x-wire-card class="mb-8">
            <div class="lg:flex lg:justify-between lg:items-center">
                <div class="flex items-center">
                    <img src="{{ $patient->user->profile_photo_url }}" alt="{{ $patient->user->name }}"
                        class="w-20 h-20 rounded-full object-cover">
                    <div>
                        <p class="text-2xl font-bold text-gray-900 ml-5">{{ $patient->user->name }}</p>
                    </div>
                </div>
                <div class="flex space-x-3 mt-6 lg:mt-0">
                    <x-wire-button outline gray href="{{ route('admin.patients.index') }}">
                        Volver
                    </x-wire-button>
                    <x-wire-button type="submit">
                        <i class="fa-solid fa-check"></i> Guardar Cambios
                    </x-wire-button>
                </div>
            </div>
        </x-wire-card>

        {{-- INICIO DE LA ESTRUCTURA DE COMPONENTES --}}
        <x-wire-card>
            {{-- Componente Principal: Inyecta el estado inicial de Alpine.js ($initialTab) --}}
            <x-tab :active="$initialTab">
                
                {{-- SLOT DE CABECERA: Aquí definimos los botones de navegación --}}
                <x-slot name="header">
                    {{-- 
                        CÓDIGO VIEJO (REEMPLAZADO):
                        Tenías que escribir el <a> manualmente con lógica de clases pesada:
                        <a href="#" x-on:click="tab = 'antecedentes'" :class="{ 'text-red-600': {{ $hasError ? 'true' : 'false' }} ... }">
                    --}}

                    {{-- NUEVO: Se usa una Prop :error para manejar el estado visual automáticamente --}}
                    <x-tab-link tab="datos-personales" :error="$errors->hasAny($errorGrups['datos-personales'])">
                        <i class="fa-solid fa-user me-2"></i> Datos Personales
                    </x-tab-link>

                    <x-tab-link tab="antecedentes" :error="$errors->hasAny($errorGrups['antecedentes'])">
                        <i class="fa-solid fa-file-medical me-2"></i> Antecedentes
                    </x-tab-link>

                    <x-tab-link tab="informacion-general" :error="$errors->hasAny($errorGrups['informacion-general'])">
                        <i class="fa-solid fa-info-circle me-2"></i> Información General
                    </x-tab-link>

                    <x-tab-link tab="contacto-emergencia" :error="$errors->hasAny($errorGrups['contacto-emergencia'])">
                        <i class="fa-solid fa-heartbeat me-2"></i> Contacto de Emergencia
                    </x-tab-link>
                </x-slot>

                {{-- CONTENIDO DE LOS TABS: Separación lógica por componente --}}
                
                {{-- 
                    CÓDIGO VIEJO (REEMPLAZADO):
                    <div x-show="tab === 'datos-personales'"> ... </div>
                --}}
                
                <x-tab-content tab="datos-personales">
                    {{-- Banner informativo usando clases de Tailwind para un diseño SaaS-moderno --}}
                    <div class="bg-blue-50 border-l-4 border-blue-500 p-4 mb-6 rounded-r-lg shadow-sm">
                        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                            <div class="flex items-start">
                                <div class="flex-shrink-0">
                                    <i class="fa-solid fa-user-gear text-blue-500 text-xl mt-1"></i>
                                </div>
                                <div class="ml-3">
                                    <h3 class="text-sm font-bold text-blue-800">Edición de cuenta de usuario</h3>
                                    <div class="mt-1 text-sm text-blue-600">
                                        <p>La <strong>información de acceso</strong> debe gestionarse desde la cuenta asociada.</p>
                                    </div>
                                </div>
                            </div>
                            <x-wire-button primary sm href="{{ route('admin.users.edit', $patient->user) }}" target="_blank">
                                Editar Usuario <i class="fa-solid fa-arrow-up-right-from-square ms-2"></i>
                            </x-wire-button>
                        </div>
                    </div>
                    {{-- Datos informativos no editables --}}
                    <div class="grid lg:grid-cols-2 gap-4">
                        <p><span class="font-semibold text-gray-600">Teléfono:</span> {{ $patient->user->phone }}</p>
                        <p><span class="font-semibold text-gray-600">Email:</span> {{ $patient->user->email }}</p>
                        <p><span class="font-semibold text-gray-600">Dirección:</span> {{ $patient->user->address }}</p>
                    </div>
                </x-tab-content>

                <x-tab-content tab="antecedentes">
                    {{-- Grid de 2 columnas para optimizar espacio en pantallas grandes --}}
                    <div class="grid lg:grid-cols-2 gap-4">
                        <x-wire-textarea label="Alergias conocidas" name="allergies">
                            {{ old('allergies', $patient->allergies) }}
                        </x-wire-textarea>
                        <x-wire-textarea label="Enfermedades crónicas" name="chronic_conditions">
                            {{ old('chronic_conditions', $patient->chronic_conditions) }}
                        </x-wire-textarea>
                        <x-wire-textarea label="Antecedentes familiares" name="family_history">
                            {{ old('family_history', $patient->family_history) }}
                        </x-wire-textarea>
                        <x-wire-textarea label="Antecedentes quirúrgicos" name="surgical_history">
                            {{ old('surgical_history', $patient->surgical_history) }}
                        </x-wire-textarea>
                    </div>
                </x-tab-content>

                <x-tab-content tab="informacion-general">
                    {{-- Uso de @selected para mantener el valor tras fallos de validación --}}
                    <x-wire-native-select label="Tipo de Sangre" class="mb-4" name="blood_type_id">
                        <option value="">Selecciona el tipo de sangre</option>
                        @foreach ($bloodTypes as $bloodType)
                            <option value="{{ $bloodType->id }}" @selected(old('blood_type_id', $patient->blood_type_id) == $bloodType->id)>
                                {{ $bloodType->name }}
                            </option>
                        @endforeach
                    </x-wire-native-select>
                    <x-wire-textarea label="Observaciones" name="observations">
                        {{ old('observations', $patient->observations) }}
                    </x-wire-textarea>
                </x-tab-content>

                <x-tab-content tab="contacto-emergencia">
                    <div class="space-y-4">
                        <x-wire-input label="Nombre del contacto" name="emergency_contact_name" value="{{ old('emergency_contact_name', $patient->emergency_contact_name) }}" />
                        {{-- Componente especializado para teléfonos con máscara --}}
                        <x-wire-phone label="Teléfono del contacto" name="emergency_contact_phone" mask="(###) ###-####" value="{{ old('emergency_contact_phone', $patient->emergency_contact_phone) }}" />
                        <x-wire-input label="Relación" name="emergency_contact_relationship" value="{{ old('emergency_contact_relationship', $patient->emergency_contact_relationship) }}" />
                    </div>
                </x-tab-content>

            </x-tab>
        </x-wire-card>
    </form>
</x-admin-layout>