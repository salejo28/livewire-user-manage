<div>
    @include('livewire.user-form')

    <div class="container w-full md:w-4/5  mx-auto px-2">
        <h1 class="flex items-center font-sans font-bold break-normal text-indigo-500 px-2 py-8 text-xl md:text-2xl">
            Users
        </h1>
        <div class="overflow-x-auto shadow-md sm:rounded-lg">
            <div class="p-4">
                <div class="mb-10 flex justify-between items-center">
                    <div>
                        <label for="table-search" class="sr-only">Search</label>
                        <div class="relative mt-1 z-[1]">
                            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                <svg class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="currentColor"
                                    viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd"
                                        d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
                                        clip-rule="evenodd"></path>
                                </svg>
                            </div>
                            <input type="text" id="table-search"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-80 pl-10 p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                placeholder="Search user by email or name" wire:model="search">
                        </div>
                    </div>
                    <div>
                        <button type="button"
                            class="w-full text-white bg-primary-600 hover:bg-primary-700 focus:ring-4 focus:outline-none focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800"
                            wire:click="toggleShowModal('user-form')">Add
                            New</button>
                    </div>
                </div>
                {{-- Table --}}
                <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th scope="col" class="px-6 py-3">
                                ID
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Name
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Email
                            </th>
                            {{-- <th scope="col" class="px-6 py-3">
                                Password
                            </th> --}}
                            <th scope="col" class="px-6 py-3">
                                Created At
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Updated At
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Action
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                            <tr class="bg-white border-b dark:bg-gray-900 dark:border-gray-700">
                                <th scope="row"
                                    class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                    {{ $user['id'] }}
                                </th>
                                <td class="px-6 py-4">
                                    {{ $user['name'] }}
                                </td>
                                <td class="px-6 py-4">
                                    {{ $user['email'] }}
                                </td>
                                {{-- <td class="px-6 py-4">
                                    <a href="#"
                                        class="font-medium text-blue-600 dark:text-blue-500 hover:underline">Change
                                        Password</a>
                                </td> --}}
                                <td class="px-6 py-4">
                                    {{ date('Y-m-d H:i:s', strtotime($user['created_at'])) }}
                                </td>
                                <td class="px-6 py-4">
                                    {{ date('Y-m-d H:i:s', strtotime($user['updated_at'])) }}
                                </td>
                                <td class="px-6 py-4 flex items-center">
                                    <a wire:click.prevent="handleUpdate({{ $user['id'] }}, '{{ $user['name'] }}', '{{ $user['email'] }}')"
                                        class="font-medium text-blue-600 dark:text-blue-500 hover:underline cursor-pointer">Edit</a>
                                    <a wire:click.prevent="handleDelete({{ $user['id'] }})"
                                        class="font-medium text-red-600 dark:text-red-500 hover:underline ml-5 cursor-pointer">Delete</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                {{-- pagination --}}
                <nav class="mt-5 mb-5 float-right">
                    <ul class="flex items-center -space-x-px h-10 text-base">
                        <li>
                            <a wire:click.prevent="next('{{ intval($page) - 1 }}')"
                                class="@if ($page === '1') cursor-not-allowed pointer-events-none opacity-50 @else cursor-pointer pointer-events-auto @endif flex items-center justify-center px-4 h-10 ml-0 leading-tight text-gray-500 bg-white border border-gray-300 rounded-l-lg hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
                                <span class="sr-only">Previous</span>
                                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                    fill="none" viewBox="0 0 6 10">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2" d="M5 1 1 5l4 4" />
                                </svg>
                            </a>
                        </li>
                        @foreach ($links as $link)
                            <li>
                                <a wire:click.prevent="next({{ $link['label'] }})"
                                    class="z-10 cursor-pointer flex items-center justify-center px-4 h-10 leading-tight @if ($link['active']) text-blue-600 border border-blue-300 bg-blue-50 hover:bg-blue-100 hover:text-blue-700 dark:border-gray-700 dark:bg-gray-700 dark:text-white @else text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white @endif">
                                    {{ $link['label'] }}
                                </a>
                            </li>
                        @endforeach
                        <li>
                            <a wire:click.prevent="next('{{ intval($page) + 1 }}')"
                                class="@if ($page === $lastPage) cursor-not-allowed pointer-events-none opacity-50 @else cursor-pointer pointer-events-auto @endif flex items-center justify-center px-4 h-10 leading-tight text-gray-500 bg-white border border-gray-300 rounded-r-lg hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
                                <span class="sr-only">Next</span>
                                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                    fill="none" viewBox="0 0 6 10">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2" d="m1 9 4-4-4-4" />
                                </svg>
                            </a>
                        </li>
                    </ul>
                </nav>

            </div>
        </div>
    </div>

    {{-- delete modal --}}
    <div wire:ignore.self id="overlay-delete-user-modal"
        class="hidden absolute inset-0 bg-black bg-opacity-30 h-screen w-full flex justify-center items-start md:items-center pt-10 md:pt-0 z-[2]">
        <div wire:ignore.self id="user-delete-modal"
            class="pacity-0 transform -translate-y-full scale-150 relative w-full max-w-2xl h-auto md:h-auto bg-white rounded shadow-lg transition-opacity transition-transform duration-300">
            <div class="relative p-4 w-full h-full md:h-auto">
                <div class="relative p-4 text-center bg-white rounded-lg shadow dark:bg-gray-800 sm:p-5">
                    <button type="button"
                        class="text-gray-400 absolute top-2.5 right-2.5 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white"
                        wire:click="$emit('hideAlert')">
                        <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"
                            xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd"
                                d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                clip-rule="evenodd"></path>
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                    <svg class="text-gray-400 dark:text-gray-500 w-11 h-11 mb-3.5 mx-auto" aria-hidden="true"
                        fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd"
                            d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z"
                            clip-rule="evenodd"></path>
                    </svg>
                    <p class="mb-4 text-gray-500 dark:text-gray-300">Are you sure you want to delete this item?</p>
                    <div class="flex justify-center items-center space-x-4">
                        <button type="button"
                            class="py-2 px-3 text-sm font-medium text-gray-500 bg-white rounded-lg border border-gray-200 hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-primary-300 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600"
                            wire:click="$emit('hideAlert')">
                            No, cancel
                        </button>
                        <button wire:click="delete"
                            class="py-2 px-3 text-sm font-medium text-center text-white bg-red-600 rounded-lg hover:bg-red-700 focus:ring-4 focus:outline-none focus:ring-red-300 dark:bg-red-500 dark:hover:bg-red-600 dark:focus:ring-red-900">
                            Yes, I'm sure
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('livewire:load', function() {
            Livewire.on('show-alert-delete', function(response) {
                if (!response.show)
                    @this.uid = null
                showAlert(response.show)
            });
        });


        const showAlert = (show) => {
            const modal = document.getElementById('user-delete-modal')
            const overlay = document.getElementById('overlay-delete-user-modal')
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
</div>
