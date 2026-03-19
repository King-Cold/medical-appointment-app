<x-admin-layout 
    title="Usuarios" 
    :breadcrumbs="[
        [
            'name' => 'Dashboard',
            'href' => route('admin.dashboard'),
        ],
        [
            'name' => 'Usuarios',
            'href' => route('admin.users.index'),
        ],
        [
            'name' => 'Crear',
        ],
    ]"
>
<x-wire-card>
    <x-validation-errors class="mb-4"/>
  <form action="{{ route('admin.users.store') }}" method="POST">
@csrf
<div class="space-y-4">
  <div class="grid md:grid-cols-2 gap-4">
<x-wire-input label="Nombre" name="name" placeholder="Nombre del usuario" required :value=" old('name')"></x-wire-input>
<x-wire-input type="email" label="Correo electrónico" name="email" placeholder="Correo electrónico del usuario" required :value=" old('email')" autocomplete="email"></x-wire-input>
<x-wire-input type="password" label="Contraseña" name="password" placeholder="Minimo 8 caracteres" required autocomplete="new-password"></x-wire-input>

<x-wire-input type="password" label="Confirmar contraseña" name="password_confirmation" placeholder="Repita la contraseña" required autocomplete="new-password"></x-wire-input>

<x-wire-input label="Número de ID" name="id_number" placeholder="Número de ID del usuario" :value=" old('id_number')" required autocomplete="off" inputmode="numeric"></x-wire-input>
<x-wire-input label="Teléfono" name="phone" placeholder="Teléfono del usuario" :value=" old('phone')" required autocomplete="tel" inputmode="tel"></x-wire-input>

</div>
<x-wire-input label="Dirección" name="address" placeholder="Ej. Calle 90 293" required :value=" old('address')" autocomplete="street-address"></x-wire-input>
<div class="space-y-1">
    <x-wire-native-select name="role_id" label="Rol">
        <option value="">Seleccionar rol</option>
    
    @foreach ($roles as $role)
    <option value="{{ $role->id }}" @selected (old('role_id') == $role->id)>{{ $role->name }}</option>
    @endforeach 
</x-wire-native-select>
<p class="text-sm text-gray-500">Define los permisos y acecesos del usuario </p>
</div>
<div class="flex justify-end">
  <x-wire-button type="submit" blue>Guardar</x-wire-button> </div>
</div>
</form>
</x-wire-card>
</x-admin-layout>
