<div>
    <x-dialog-modal wire:model="open">

        <x-slot name="title">
            <i class="fas fa-{{ $isEdit ? 'edit' : 'plus' }}"></i>
            {{ $isEdit ? 'Edit Service' : 'Create New Service' }}
        </x-slot>

        <x-slot name="content">
            <div class="w-full flex flex-col gap-2">
               <div class="flex flex-col gap-2">
                   <div class="w-full">
                        <x-label value="Name" />
                        <x-input type="text" class="w-full" wire:model="service.name" />
                        <x-input-error for='service.name' />
                    </div>
               </div>
            </div>
        </x-slot>

        <x-slot name="footer">
            <x-secondary-button wire:click="closeModal" wire:loading.attr="disabled" class="mr-2">
                Cancelar
            </x-secondary-button>

            <x-button wire:click="submit" wire:loading.attr="disabled" class="disabled:opacity-25">
                {{ $isEdit ? 'Edit Service' : 'Create Service' }}
            </x-button>
        </x-slot>

    </x-dialog-modal>
</div>
