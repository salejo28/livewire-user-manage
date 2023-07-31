<div wire:ignore.self>
    <script>
        document.addEventListener('livewire:load', function() {
            Livewire.on('show', function(response) {            
                showModal(response.show)
            });

        });


        const showModal = (show) => {
            const modal = document.getElementById('user-form-modal')
            const overlay = document.getElementById('overlay-user-form-modal')
            if (show) {
                overlay.classList.remove('hidden')
                setTimeout(() => {
                    modal.classList.remove('opacity-0')
                    modal.classList.remove('-translate-y-full')
                    modal.classList.remove('scale-150')
                }, 100);
                return
            }

            modal.classList.add('-translate-y-full')
            setTimeout(() => {
                modal.classList.add('opacity-0')
                modal.classList.add('scale-150')
            }, 100);
            setTimeout(() => overlay.classList.add('hidden'), 300);
        }
    </script>
    <div wire:ignore.self id="overlay-user-form-modal"
        class="hidden absolute inset-0 bg-black bg-opacity-30 h-screen w-full flex justify-center items-start md:items-center pt-10 md:pt-0 z-[2]" >
        <div wire:ignore.self id="user-form-modal"
            class="pacity-0 transform -translate-y-full scale-150 relative w-full max-w-2xl h-auto md:h-auto bg-white rounded shadow-lg transition-opacity transition-transform duration-300">
            <div class="relative w-full max-w-2xl max-h-full">
                <form class="relative bg-white rounded-lg shadow dark:bg-gray-700"
                    wire:submit.prevent="@if($update) updateUser @else addNew @endif">
                    <div class="flex items-start justify-between p-4 border-b rounded-t dark:border-gray-600">
                        <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                            @if ($update)
                                Update User
                            @else
                                New User
                            @endif
                        </h3>
                        <button type="button"
                            class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ml-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                            wire:click="$emit('hideModal')">
                            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 14 14">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                            </svg>
                            <span class="sr-only">Close modal</span>
                        </button>
                    </div>
                    <div class="p-6 space-y-6">
                        @if ($update)
                            @if (session()->has('error'))
                                <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4" role="alert">
                                    <p class="font-bold">Something is wrong</p>
                                    <p>{{ session('error') }}</p>
                                </div>
                            @endif
                            @foreach ($updateUserForm as $field)
                                <div>
                                    <label for="{{ $field['name'] }}"
                                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{ $field['label'] }}</label>
                                    <input type="{{ $field['type'] }}" name="{{ $field['name'] }}"
                                        id="{{ $field['name'] }}"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                        placeholder="{{ $field['placeholder'] }}"
                                        wire:model="{{ $field['model'] }}">
                                    @if ($field['name'] === 'name')
                                        @error('name')
                                            <span class="text-sm font-medium text-red-900">{{ $message }}</span>
                                        @enderror
                                    @else
                                        @error('email')
                                            <span class="text-sm font-medium text-red-900">{{ $message }}</span>
                                        @enderror
                                    @endif
                                </div>
                            @endforeach
                        @else
                            @if (session()->has('error'))
                                <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4" role="alert">
                                    <p class="font-bold">Something is wrong</p>
                                    <p>{{ session('error') }}</p>
                                </div>
                            @endif
                            @foreach ($addUserForm as $field)
                                <div>
                                    <label for="{{ $field['name'] }}"
                                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{ $field['label'] }}</label>
                                    <input type="{{ $field['type'] }}" name="{{ $field['name'] }}"
                                        id="{{ $field['name'] }}"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                        placeholder="{{ $field['placeholder'] }}"
                                        wire:model="{{ $field['model'] }}">
                                    @if ($field['name'] === 'name')
                                        @error('name')
                                            <span class="text-sm font-medium text-red-900">{{ $message }}</span>
                                        @enderror
                                    @elseif($field['name'] === 'email')
                                        @error('email')
                                            <span class="text-sm font-medium text-red-900">{{ $message }}</span>
                                        @enderror
                                    @else
                                        @error('password')
                                            <span class="text-sm font-medium text-red-900">{{ $message }}</span>
                                        @enderror
                                    @endif
                                </div>
                            @endforeach
                        @endif
                    </div>
                    <div
                        class="flex items-center p-6 space-x-2 border-t border-gray-200 rounded-b dark:border-gray-600">
                        <button type="submit"
                            class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Save</button>
                        <button wire:click="$emit('hideModal')" type="button"
                            class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600">Cancel</button>
                    </div>
            </div>
        </div>
    </div>
</div>
