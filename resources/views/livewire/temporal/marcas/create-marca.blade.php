<div>
    <x-dialog-modal wire:model="open">

        <x-slot name="title">
            <i class="fas fa-{{ $isEdit ? 'edit' : 'plus' }}"></i>
            {{ $isEdit ? 'Edit Marca' : 'Create New Marca' }}
        </x-slot>

        <x-slot name="content">
            <div class="w-full flex flex-col gap-2">
               <div class="flex flex-col gap-2">
                   <div class="w-full">
                        <x-label value="Name" />
                        <x-input type="text" class="w-full" wire:model="marca.name" />
                        <x-input-error for='marca.name' />
                    </div>
               </div>
            </div>
        </x-slot>

        <x-slot name="footer">
            <x-secondary-button wire:click="closeModal" wire:loading.attr="disabled" class="mr-2">
                Cancelar
            </x-secondary-button>

            <x-button wire:click="submit" wire:loading.attr="disabled" class="disabled:opacity-25">
                {{ $isEdit ? 'Edit Marca' : 'Create Marca' }}
            </x-button>
        </x-slot>

    </x-dialog-modal>
</div>
