<div>
    <x-dialog-modal wire:model="open">

        <x-slot name="title">
            <i class="fas fa-{{ $isEdit ? 'edit' : 'plus' }}"></i>
            {{ $isEdit ? 'Edit Generate' : 'Create New Generate' }}
        </x-slot>

        <x-slot name="content">
            <div class="w-full flex flex-col gap-2">
               <div class="flex flex-col gap-2">
                   <div class="flex gap-2">
                        <div class="w-full">
                            <x-label value="Folder" />
                            <x-input type="text" class="w-full" wire:model="generate.folder" />
                            <x-input-error for='generate.folder' />
                        </div>
                        <div class="w-full">
                            <x-label value="Modulo (Clase)" />
                            <x-input type="text" class="w-full" wire:model="generate.name" />
                            <x-input-error for='generate.name' />
                        </div>
                   </div>
                   <div class="flex gap-2 mb-5">
                        <div class="w-full flex gap-2 flex-col justify-center items-center">
                            <p>Migration</p>
                            <input checked id="checkbox-all" aria-describedby="checkbox-1" type="checkbox"class="w-5 h-5 rounded border-gray-900 focus:ring-0 checked:bg-dark-900">
                        </div> 
                        <div class="w-full flex gap-2 flex-col justify-center items-center">
                            <p>Model</p>
                            <input checked id="checkbox-all" aria-describedby="checkbox-1" type="checkbox"class="w-5 h-5 rounded border-gray-900 focus:ring-0 checked:bg-dark-900">
                        </div>    
                        <div class="w-full flex gap-2 flex-col justify-center items-center">
                            <p>Controller</p>
                            <input id="checkbox-all" aria-describedby="checkbox-1" type="checkbox"class="w-5 h-5 rounded border-gray-900 focus:ring-0 checked:bg-dark-900">
                        </div> 
                        <div class="w-full flex gap-2 flex-col justify-center items-center">
                            <p>Components livewire</p>
                            <input checked id="checkbox-all" aria-describedby="checkbox-1" type="checkbox"class="w-5 h-5 rounded border-gray-900 focus:ring-0 checked:bg-dark-900">
                        </div> 
                   </div>
                   <p>Campos</p>
                   <div class="flex gap-2">
                        <div class="w-full">
                           <p>Nombre del campo</p>
                        </div>
                        <div class="w-full">
                           <p>Tipo</p>
                        </div>
                        <div class="w-full">
                           <p>Restriccion</p>
                        </div>
                    </div>
                   @for ($i = 0; $i < 3; $i++)
                        <div class="flex gap-2">
                            <div class="w-full">
                                <x-input type="text" class="w-full" />
                            </div>
                            <div class="w-full">
                                <x-input type="text" class="w-full" />
                            </div>
                            <div class="w-full">
                                <x-input type="text" class="w-full" />
                            </div>
                        </div>
                   @endfor
               </div>
            </div>
        </x-slot>

        <x-slot name="footer">
            <x-secondary-button wire:click="closeModal" wire:loading.attr="disabled" class="mr-2">
                Cancelar
            </x-secondary-button>

            <x-button wire:click="submit" wire:loading.attr="disabled" class="disabled:opacity-25">
                {{ $isEdit ? 'Edit Generate' : 'Create Generate' }}
            </x-button>
        </x-slot>

    </x-dialog-modal>
</div>
