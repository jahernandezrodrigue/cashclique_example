<div>
    <x-dialog-modal wire:model="open">

        <x-slot name="title">
            <i class="fas fa-{{ $isEdit ? 'edit' : 'plus' }}"></i>
            {{ $isEdit ? 'Edit Sale' : 'Create New Sale' }}
        </x-slot>

        <x-slot name="content">
            <div class="w-full flex flex-col gap-2">
               <div class="flex flex-col gap-2">
                   <div class="flex gap-2">
                        <div class="w-full">
                            <x-label value="Fecha" />
                            <x-input type="text" class="w-full" />
                        </div>
                        <div class="w-full">
                            <x-label value="Hora" />
                            <x-input type="text" class="w-full" />
                        </div>
                   </div>
                    <div class="w-full">
                        <x-label value="Servicio" />
                        <x-input type="text" class="w-full" />
                    </div>
                    <div class="w-full">
                        <x-label value="Cliente" />
                        <x-input type="text" class="w-full" />
                    </div>
                    <div class="w-full">
                        <x-label value="Valor" />
                        <x-input type="text" class="w-full" />
                    </div>
                    <div class="w-full">
                        <x-label value="Staff" />
                        <x-input type="text" class="w-full" />
                    </div>
                    <div class="w-full">
                        <x-label value="Observaciones" />
                        <x-input type="text" class="w-full" />
                    </div>
                    <div class="w-full">
                        <x-label value="Name" />
                        <x-input type="text" class="w-full" wire:model="sale.name" />
                        <x-input-error for='sale.name' />
                    </div>
               </div>
            </div>
        </x-slot>

        <x-slot name="footer">
            <x-secondary-button wire:click="closeModal" wire:loading.attr="disabled" class="mr-2">
                Cancelar
            </x-secondary-button>

            <x-button wire:click="submit" wire:loading.attr="disabled" class="disabled:opacity-25">
                {{ $isEdit ? 'Edit Sale' : 'Create Sale' }}
            </x-button>
        </x-slot>

    </x-dialog-modal>
</div>
