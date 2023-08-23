<div>
    @livewire('finance.expenses.create-expense')
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Expenses') }}
        </h2>
    </x-slot>

    <div class="block justify-between items-center p-4 mx-4 mt-4 mb-6 bg-white rounded-2xl shadow-xl shadow-gray-200 lg:p-5 sm:flex">
        <div class="mb-1 w-full">
            <div class="mb-4">
                <x-breadcrumb></x-breadcrumb>
                <h1 class="text-xl font-semibold text-gray-900 sm:text-2xl">All expenses</h1>
            </div>
            <div class="block items-center sm:flex md:divide-x md:divide-gray-100">
                <form class="mb-4 sm:pr-3 sm:mb-0" action="#" method="GET">
                    <label for="products-search" class="sr-only">Search</label>
                    <div class="relative mt-1 sm:w-64 xl:w-96">
                        <input type="text" name="email" id="products-search"
                            class="border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-2 focus:ring-fuchsia-50 focus:border-fuchsia-300 block w-full p-2.5"
                            placeholder="Search for expenses" wire:model="search">
                    </div>
                </form>
                <div class="flex items-center w-full sm:justify-end">
                    <div class="hidden pl-2 space-x-1 md:flex">
                       
                    </div>
                    <x-button wire:click="$emit('createExpense')" wire:loading.attr="disabled" class="disabled:opacity-25">
                        Add Expense
                    </x-button>
                </div>
            </div>
        </div>
    </div>

    {{-- Table --}}
    <div class="flex flex-col my-6 mx-4 rounded-2xl shadow-xl shadow-gray-200">
        <div class="overflow-x-auto rounded-2xl">
            <div class="inline-block min-w-full align-middle">
                <div class="overflow-hidden">
                    <table class="min-w-full divide-y divide-gray-200 table-fixed">
                        <thead class="bg-white">
                            <tr>
                                <th scope="col" class="p-4 lg:p-5">
                                    <div class="flex items-center">
                                        <input id="checkbox-all" aria-describedby="checkbox-1" type="checkbox"
                                            class="w-5 h-5 rounded border-gray-300 focus:ring-0 checked:bg-dark-900">
                                        <label for="checkbox-all" class="sr-only">checkbox</label>
                                    </div>
                                </th>
                                <th scope="col"
                                    class="p-4 text-xs font-medium text-left text-gray-500 uppercase lg:p-5">
                                    Code
                                </th>
                                <th scope="col"
                                    class="p-4 text-xs font-medium text-left text-gray-500 uppercase lg:p-5">
                                    Expense Name
                                </th>
                                
                                <th scope="col" class="p-4 lg:p-5"></th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach ($expenses as $item)
                                <tr class="hover:bg-gray-100">
                                    <td class="p-4 w-4 lg:p-5">
                                        <div class="flex items-center">
                                            <input id="checkbox-523323" aria-describedby="checkbox-1" type="checkbox"
                                                class="w-5 h-5 rounded border-gray-300 focus:ring-0 checked:bg-dark-900">
                                            <label for="checkbox-523323" class="sr-only">checkbox</label>
                                        </div>
                                    </td>

                                    <td class="p-4 text-base font-medium text-gray-900 whitespace-nowrap lg:p-5">#{{ $item->id }}
                                    </td>

                                    <td class="p-4 text-sm font-normal text-gray-500 whitespace-nowrap lg:p-5">
                                        <div class="text-base font-semibold text-gray-900">{{ $item->name }}</div>
                                    </td>

                                    <td class="p-4 space-x-2 whitespace-nowrap lg:p-5">
                                        <button type="button" data-modal-toggle="product-modal" wire:click="$emit('editExpense', {{$item->id}})"
                                            class="inline-flex items-center py-2 px-3 text-sm font-medium text-center text-gray-700 bg-gray-200 rounded-lg hover:bg-gray-300 hover:text-gray-900 hover:scale-[1.02] transition-all">
                                            <svg class="mr-2 w-5 h-5" fill="currentColor" viewBox="0 0 20 20"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M17.414 2.586a2 2 0 00-2.828 0L7 10.172V13h2.828l7.586-7.586a2 2 0 000-2.828z">
                                                </path>
                                                <path fill-rule="evenodd"
                                                    d="M2 6a2 2 0 012-2h4a1 1 0 010 2H4v10h10v-4a1 1 0 112 0v4a2 2 0 01-2 2H4a2 2 0 01-2-2V6z"
                                                    clip-rule="evenodd"></path>
                                            </svg>
                                            
                                        </button>
                                        <button type="button" data-modal-toggle="product-modal" wire:click="delete({{$item->id}})"
                                            class="inline-flex items-center py-2 px-3 text-sm font-medium text-center text-gray-700 bg-gray-200 rounded-lg hover:bg-gray-300 hover:text-gray-900 hover:scale-[1.02] transition-all">
                                            <svg class="mr-2 w-5 h-5" fill="currentColor" viewBox="0 0 20 20"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <path fill-rule="evenodd"
                                                    d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z"
                                                    clip-rule="evenodd"></path>
                                            </svg>
                                            
                                        </button>
                                        {{-- <button type="button" data-modal-toggle="delete-product-modal"
                                            class="inline-flex items-center py-2 px-3 text-sm font-medium text-center text-white bg-gradient-to-br from-red-400 to-red-600 rounded-lg shadow-md shadow-gray-300 hover:scale-[1.02] transition-transform">
                                            <svg class="mr-2 w-5 h-5" fill="currentColor" viewBox="0 0 20 20"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <path fill-rule="evenodd"
                                                    d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z"
                                                    clip-rule="evenodd"></path>
                                            </svg>
                                            Delete item
                                        </button> --}}
                                    </td>
                                </tr>
                            @endforeach
                            @if( !count($expenses) )
                                <tr class="hover:bg-gray-100">
                                    <td colspan="5" class="p-4 bg-gray-700 text-base font-medium text-gray-300 whitespace-nowrap lg:p-5">
                                        No existen datos registrados                
                                    </td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    {{-- \Table --}}
</div>
