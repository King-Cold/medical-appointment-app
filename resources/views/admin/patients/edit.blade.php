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
    ]"
>
</x-admin-layout>