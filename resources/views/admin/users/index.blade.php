<x-admin-layout title="Usuarios">

  <div class="mb-4">
      <nav class="flex text-sm text-gray-500" aria-label="Breadcrumb">
          <ol class="inline-flex items-center space-x-1 md:space-x-3">
              <li><a href="{{ route('admin.dashboard') }}" class="hover:text-blue-600">Dashboard</a></li>
              <li class="text-gray-900 font-semibold"><i class="fa-solid fa-chevron-right mx-2 text-xs text-gray-400"></i> Usuarios</li>
          </ol>
      </nav>
  </div>

  <x-slot name="action">
    <x-wire-button blue href="{{ route('admin.users.create') }}">
      <i class="fa-solid fa-plus">
          </i>
          Nuevo
    </x-wire-button>

  </x-slot>

    @livewire('admin.datatables.user-table')

</x-admin-layout>