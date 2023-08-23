<div>
    <x-dialog-modal wire:model="open">

        <x-slot name="title">
            <i class="fas fa-{{ $isEdit ? 'edit' : 'plus' }}"></i>
            {{ $isEdit ? 'Edit Employee' : 'Create New Employee' }}
        </x-slot>

        <x-slot name="content">
            <div class="w-full flex flex-col gap-2">
               <div class="flex flex-col gap-2">
                   <div class="flex gap-2">
                        <div class="w-full">
                            <x-label value="Name" />
                            <x-input type="text" class="w-full" wire:model="employee.name" />
                            <x-input-error for='employee.name' />
                        </div>
                        <div class="w-full">
                            <x-label value="Apellido" />
                            <x-input type="text" class="w-full" wire:model="employee.surname" />
                            <x-input-error for='employee.surname' />
                        </div>
                   </div>
                    <div class="w-full">
                        <x-label value="Telefono" />
                        <x-input type="text" class="w-full" wire:model="employee.phone" />
                        <x-input-error for='employee.phone' />
                    </div>
                    <div class="w-full">
                        <x-label value="Correo" />
                        <x-input type="text" class="w-full" wire:model="employee.email" />
                        <x-input-error for='employee.email' />
                    </div>
               </div>
            </div>
        </x-slot>

        <x-slot name="footer">
            <x-secondary-button wire:click="closeModal" wire:loading.attr="disabled" class="mr-2">
                Cancelar
            </x-secondary-button>

            <x-button wire:click="submit" wire:loading.attr="disabled" class="disabled:opacity-25">
                {{ $isEdit ? 'Edit Employee' : 'Create Employee' }}
            </x-button>
        </x-slot>

    </x-dialog-modal>
</div>
