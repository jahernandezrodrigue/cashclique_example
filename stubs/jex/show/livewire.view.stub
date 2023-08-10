<div>
    @php
        $first_letters = "";
    @endphp
    
    @if ($contact['names'])
        @php
            $words = explode(" ", $contact['names']);
            if (count($words) > 1) {
                $first_letters = substr($words[0], 0, 1) . substr($words[1], 0, 1);
            } else {
                $first_letters = substr($words[0], 0, 2);
            }
        @endphp
        
    @endif
    <x-dialog-modal wire:model="open">
        
        <x-slot name="title">
            <div>
                 <p>{{ $contact['names'] }}</p>
            </div>
        </x-slot>

        <x-slot name="content">
            <div class="w-full flex gap-2 justify-center items-center">
                <div class="w-1/4 flex justify-center gap-2">
                    <div class="h-24 w-24 flex justify-center items-center bg-blue-500 rounded-full">
                        <p class="text-blue-800 text-4xl font-bold">{{$first_letters}}</p>
                    </div>
                </div>
                <div class="w-full text-xl text-slate-900 bg-slate-200 p-3 rounded-md mt-4">
                    <div class="w-full flex gap-2">
                        <p class="text-uppercase font-bold">Nombres: </p>
                        <p>{{ $contact['names'] }}</p>
                    </div>
                    <div class="w-full flex gap-2">
                        <p class="text-uppercase font-bold">surnames: </p>
                        <p>{{ $contact['surnames'] }}</p>
                    </div>
                    <div class="w-full flex gap-2">
                        <p class="text-uppercase font-bold">phone: </p>
                        <p>{{ $contact['phone'] }}</p>
                    </div>
                    <div class="w-full flex gap-2">
                        <p class="text-uppercase font-bold">email: </p>
                        <p>{{ $contact['email'] }}</p>
                    </div>
                    <div class="w-full flex gap-2">
                        <p class="text-uppercase font-bold">description: </p>
                        <p>{{ $contact['description'] }}</p>
                    </div>
                    <div class="w-full flex gap-2">
                        <p class="text-uppercase font-bold">status: </p>
                        <div>
                            @if ($contact['status'] == 1) 
                                <span class="py-0.5 h-5 px-2 bg-emerald-400 text-emerald-950 text-xs rounded-md">Contacto reciente</span>
                            @endif
                            @if ($contact['status'] == 2)
                                <span class="py-0.5 h-5 px-2 bg-yellow-400 text-yellow-950 text-xs rounded-md">Contacto mas o menos</span>
                            @endif
                            @if ($contact['status'] == 3)
                                <span class="py-0.5 h-5 px-2 bg-red-400 text-red-950 text-xs rounded-md">Sin contacto</span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </x-slot>

        <x-slot name="footer">
            <x-danger-button wire:click="$toggle('open')" wire:loading.attr="disabled" class="mr-2">
                Ok
            </x-danger-button>
        </x-slot>

    </x-dialog-modal>
</div>
