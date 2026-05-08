<div class="flex space-x-2">
    <!-- Existing Edit Button placeholder, if any -->
    <a href="{{ route('admin.appointments.edit', $appointment->id) }}" class="text-blue-600 hover:text-blue-900 dark:text-blue-500 dark:hover:underline" title="Editar cita">
        <i class="fa-solid fa-pen-to-square"></i>
    </a>
    
    <!-- New Stethoscope Button for Consultation -->
    <a href="{{ route('admin.consultations.manager', $appointment->id) }}" class="text-green-600 hover:text-green-900 dark:text-green-500 dark:hover:underline" title="Atender Cita">
        <i class="fa-solid fa-stethoscope"></i>
    </a>
</div>
