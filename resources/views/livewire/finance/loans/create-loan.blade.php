<div>
    <x-dialog-modal wire:model="open">

        <x-slot name="title">
            <i class="fas fa-{{ $isEdit ? 'edit' : 'plus' }}"></i>
            {{ $isEdit ? 'Edit Loan' : 'Create New Loan' }}
        </x-slot>

        <x-slot name="content">
            <div class="w-full flex flex-col gap-2">
               <div class="flex flex-col gap-2">
                   <div class="w-full">
                        <x-label value="Name" />
                        <x-input type="text" class="w-full" wire:model="loan.name" />
                        <x-input-error for='loan.name' />
                    </div>
               </div>
            </div>
        </x-slot>

        <x-slot name="footer">
            <x-secondary-button wire:click="closeModal" wire:loading.attr="disabled" class="mr-2">
                Cancelar
            </x-secondary-button>

            <x-button wire:click="submit" wire:loading.attr="disabled" class="disabled:opacity-25">
                {{ $isEdit ? 'Edit Loan' : 'Create Loan' }}
            </x-button>
        </x-slot>

    </x-dialog-modal>
</div>
