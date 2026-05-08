<x-admin-layout title="Usuarios">

  <div class="mb-6 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
      <!-- Lado Izquierdo: Breadcrumbs -->
      <nav class="flex text-sm text-gray-500" aria-label="Breadcrumb">
          <ol class="inline-flex items-center space-x-1 md:space-x-3">
              <li>
                  <a href="{{ route('admin.dashboard') }}" class="hover:text-blue-600">Dashboard</a>
              </li>
              <li class="text-gray-900 font-semibold">
                  <i class="fa-solid fa-chevron-right mx-2 text-xs text-gray-400"></i> 
                  Usuarios
              </li>
          </ol>
      </nav>

      <!-- Lado Derecho: Botón de Acción -->
      <div>
          <x-wire-button blue href="{{ route('admin.users.create') }}">
              <i class="fa-solid fa-plus mr-1"></i>
              Nuevo Usuario
          </x-wire-button>
      </div>
  </div>

  @livewire('admin.datatables.user-table')

</x-admin-layout>