
<x-admin-layout title="Pacientes | Healthify">

<div class="mb-4">
    <nav class="flex text-sm text-gray-500" aria-label="Breadcrumb">
        <ol class="inline-flex items-center space-x-1 md:space-x-3">
            <li><a href="{{ route('admin.dashboard') }}" class="hover:text-blue-600">Dashboard</a></li>
            <li><i class="fa-solid fa-chevron-right mx-2 text-xs text-gray-400"></i> <a href="{{ route('admin.patients.index') }}" class="hover:text-blue-600">Pacientes</a></li>
            <li class="text-gray-900 font-semibold"><i class="fa-solid fa-chevron-right mx-2 text-xs text-gray-400"></i> Detalle</li>
        </ol>
    </nav>
</div>

</x-admin-layout>