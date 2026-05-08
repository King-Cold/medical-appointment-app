<x-admin-layout title="Roles">

<div class="mb-4">
    <nav class="flex text-sm text-gray-500" aria-label="Breadcrumb">
        <ol class="inline-flex items-center space-x-1 md:space-x-3">
            <li><a href="{{ route('admin.dashboard') }}" class="hover:text-blue-600">Dashboard</a></li>
            <li><i class="fa-solid fa-chevron-right mx-2 text-xs text-gray-400"></i> <a href="{{ route('admin.roles.index') }}" class="hover:text-blue-600">Roles</a></li>
            <li class="text-gray-900 font-semibold"><i class="fa-solid fa-chevron-right mx-2 text-xs text-gray-400"></i> Editar</li>
        </ol>
    </nav>
</div>

<x-wire-card>
  <form action="{{ route('admin.roles.update',$role) }}" method="POST">
@csrf
@method('PUT')
<x-wire-input label="Nombre" name="name" placeholder="Nombre del rol" value="{{ old('name' , $role->name) }}"></x-wire-input>
<div class="flex justify-end mt-4">
  <x-wire-button type="submit" blue>Actualizar</x-wire-button>
</div>
</form>
</x-wire-card>
</x-admin-layout>