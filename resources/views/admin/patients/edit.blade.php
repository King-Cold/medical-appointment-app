<x-admin-layout 
    title="Roles" 
    :breadcrumbs="[
        [
            'name' => 'Dashboard',
            'href' => route('admin.dashboard'),
        ],
        [
            'name' => 'Pacientes',
            'href' => route('admin.roles.index'),
        ],
        [
            'name' => 'Editar',
        ],
    ]">

    <form action="{{ route('admin.patients.update', $patient) }}" method="POST">
        @csrf
        @method('PUT')
        {{-- Encabezado con foto de perfil y acciones --}}
        <x-wire-card>
            <div class=" lg:flex  lg:justify-between lg:items-center">
                <div class="flex items-center">
                <img src="{{ $patient->user->profile_photo_url}}" alt="{{$patient->user-> name }}" class="w-20 h-20 rounded-full object-cover">
                <div>
                    <p class="text-2x1 font-bold text-gray-900 ml-5">{{ $patient->user->name }}</p>
                </div>
                </div>
                <div class="flex space-x-3 mt-6 lg:mt-0">
                    <x-wire-button outline gray href="{{ route('admin.patients.index') }}">
                        Volver
                    </x-wire-button>
                    <x-wire-button type="submit">
                        <i class="fa-solid fa-check"></i>
                        Guardar Cambios
                    </x-wire-button>

                </div>
            </div>
        </x-wire-card>
        {{-- Tabs de navegación --}}
<x-wire-card>
<div x-data="{tab: 'datos-personales'}">

{{-- Menu de pestañas --}}

    <div class="border-b border-gray-200">
        <ul class="flex flex-wrap -mb-px text-sm font-medium text-center text-gray-500">
            
            {{-- Tab 1: Datos Personales --}}
            <li class="me-2">
                <a href="#" x-on:click="tab = 'datos-personales'" 
                :class="{
                    'text-blue-600 border-blue-600 active': tab === 'datos-personales',
                    'border-transparent hover:text-blue-600 hover:border-gray-300': tab !== 'datos-personales'
                    }"
                    class="inline-flex items-center justify-center p-4 border-b rounded-t-lg group transition-colors duration-200" :aria-current="tab === 'datos-personales' ? 'page' : undefined">
                    <i class="fa-solid fa-user me-2"></i>
                    Datos Personales
                </a>
            </li>
            {{-- Tab 2:Antecedentes --}}
<li class="me-2">
                <a href="#" x-on:click="tab = 'antecedentes'" 
                :class="{
                    'text-blue-600 border-blue-600 active': tab === 'antecedentes',
                    'border-transparent hover:text-blue-600 hover:border-gray-300': tab !== 'antecedentes'
                    }"
                    class="inline-flex items-center justify-center p-4 border-b rounded-t-lg group transition-colors duration-200" :aria-current="tab === 'antecedentes' ? 'page' : undefined">
                    <i class="fa-solid fa-file-medical me-2"></i>
                    Antecedentes    
                </a>
            </li>

         {{-- Tab 3:Informacion General --}}
<li class="me-2">
                <a href="#" x-on:click="tab = 'informacion-general'" 
                :class="{
                    'text-blue-600 border-blue-600 active': tab === 'informacion-general',
                    'border-transparent hover:text-blue-600 hover:border-gray-300': tab !== 'informacion-general'
                    }"
                    class="inline-flex items-center justify-center p-4 border-b rounded-t-lg group transition-colors duration-200" :aria-current="tab === 'informacion-general' ? 'page' : undefined">
                    <i class="fa-solid fa-info-circle me-2"></i>
                    Información General    
                </a>
            </li>
        {{-- Tab 4:Contacto de Emergencia --}}
                <li class="me-2">
                <a href="#" x-on:click="tab = 'contacto-emergencia'" 
                :class="{
                    'text-blue-600 border-blue-600 active': tab === 'contacto-emergencia',
                    'border-transparent hover:text-blue-600 hover:border-gray-300': tab !== 'contacto-emergencia'
                    }"
                    class="inline-flex items-center justify-center p-4 border-b rounded-t-lg group transition-colors duration-200" :aria-current="tab === 'contacto-emergencia' ? 'page' : undefined">
                    <i class="fa-solid fa-heartbeat me-2"></i>
                    Contacto de Emergencia    
                </a>
            </li>
    </ul>
</div>
{{-- Contenido de las pestañas --}}
<div class="p-4 mt-4">
    {{-- Contenido:Tab 1: Datos Personales --}}
    <div x-show="tab === 'datos-personales'">
        <div class="bg-blue-50 border-l-4 border-blue-500 p-4 mb-6 rounded-r-lg shadow-sm">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">

            {{-- Lado Izquierdo: Informacion --}}
            <div class="flex items-start">
                <div  class="flex-shrink-0">
                    <i class="fa-solid fa-user-gear text-blue-500 text-xl mt-1"></i>
                    <div class="ml-3">
                        <h3 class="text-sm font-bold text-blue-800">Edicion de cuenta de usuario</h3>
                        <div class="mt-1 text-sm text-blue-600"> <p>La <strong>información de acceso</strong>(Nombre, Email y Contraseña debe gestionarse desde la cuenta del usuario asociada:)</p>
                    </div>
                </div>
            </div>
                   {{-- Lado Derecho: Acciones --}}
                   <div class="flex-shrink-0">
                    <x-wire-button primary sm href="{{ route('admin.users.edit', $patient->user) }}" target="_blank">
                        Editar Usuario
                        <i class="fa-solid fa-arrow-up-right-from-square ms-2"></i>
                    </x-wire-button>
                   </div>
                </div>
            </div>
            </div>
        


    </div>
</div>
</x-wire-card>
    </form>
</x-admin-layout>