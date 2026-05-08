<x-admin-layout title="Crear Doctor | Healthify">

<div class="mb-4">
    <nav class="flex text-sm text-gray-500" aria-label="Breadcrumb">
        <ol class="inline-flex items-center space-x-1 md:space-x-3">
            <li><a href="{{ route('admin.dashboard') }}" class="hover:text-blue-600">Dashboard</a></li>
            <li><i class="fa-solid fa-chevron-right mx-2 text-xs text-gray-400"></i> <a href="{{ route('admin.doctors.index') }}" class="hover:text-blue-600">Doctores</a></li>
            <li class="text-gray-900 font-semibold"><i class="fa-solid fa-chevron-right mx-2 text-xs text-gray-400"></i> Nuevo</li>
        </ol>
    </nav>
</div>

<!-- Central Form Container -->
<div class="bg-white rounded-xl shadow-sm border border-gray-200">
    <div class="p-5 border-b border-gray-100">
        <h2 class="text-lg font-semibold text-gray-800">Información General</h2>
        <p class="text-sm text-gray-500 mt-1">Registre los datos personales y de contacto del nuevo doctor.</p>
    </div>
    
    <form action="{{ route('admin.doctors.store') }}" method="POST" class="p-6 space-y-6">
        @csrf
        
        <!-- Avatar / Photo -->
        <div class="flex items-center space-x-6">
            <div class="shrink-0">
                <div class="h-16 w-16 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-500 text-xl font-bold">
                    <i class="fa-solid fa-user-doctor"></i>
                </div>
            </div>
            <label class="block">
                <span class="sr-only">Elegir foto de perfil</span>
                <input type="file" class="block w-full text-sm text-gray-500
                file:mr-4 file:py-2 file:px-4
                file:rounded-full file:border-0
                file:text-sm file:font-semibold
                file:bg-indigo-50 file:text-indigo-700
                hover:file:bg-indigo-100
                "/>
            </label>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label for="name" class="block mb-2 text-sm font-medium text-gray-900">Nombre completo</label>
                <input type="text" id="name" name="name" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" required>
            </div>
            <div>
                <label for="email" class="block mb-2 text-sm font-medium text-gray-900">Email</label>
                <input type="email" id="email" name="email" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" required>
            </div>
            <div>
                <label for="dni" class="block mb-2 text-sm font-medium text-gray-900">DNI</label>
                <input type="text" id="dni" name="dni" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" required>
            </div>
            <div>
                <label for="phone" class="block mb-2 text-sm font-medium text-gray-900">Teléfono</label>
                <input type="text" id="phone" name="phone" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" required>
            </div>
            <div>
                <label for="specialty" class="block mb-2 text-sm font-medium text-gray-900">Especialidad</label>
                <input type="text" id="specialty" name="specialty" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" required>
            </div>
            <div>
                <label for="status" class="block mb-2 text-sm font-medium text-gray-900">Estado</label>
                <select id="status" name="status" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                    <option value="Activo" selected>Activo</option>
                    <option value="Inactivo">Inactivo</option>
                </select>
            </div>
        </div>
        
        <div class="flex items-center justify-end space-x-3 pt-4 border-t border-gray-100">
            <a href="{{ route('admin.doctors.index') }}" class="text-gray-700 bg-white border border-gray-300 focus:ring-4 focus:outline-none focus:ring-gray-100 font-medium rounded-lg text-sm px-5 py-2.5 hover:bg-gray-50 focus:z-10">Cancelar</a>
            <button type="submit" class="text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">Guardar Doctor</button>
        </div>
    </form>
</div>

</x-admin-layout>
