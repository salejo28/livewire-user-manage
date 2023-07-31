<section>
    <div class="flex flex-col items-center justify-center px-6 py-8 mx-auto md:h-screen lg:py-0">
        <div
            class="w-full bg-white rounded-lg shadow dark:border md:mt-0 sm:max-w-md xl:p-0 dark:bg-gray-800 dark:border-gray-700">
            <div class="p-6 space-y-4 md:space-y-6 sm:p-8">
                <h1 class="text-xl font-bold leading-tight tracking-tight text-gray-900 md:text-2xl dark:text-white">
                    @if ($showRegisterForm)
                        Register
                    @else
                        Login
                    @endif
                </h1>
                @if ($showRegisterForm)
                    <form class="space-y-4 md:space-y-6" wire:submit.prevent="register">
                        @if (session()->has('error'))
                            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4" role="alert">
                                <p class="font-bold">Something is wrong</p>
                                <p>{{ session('error') }}</p>
                            </div>
                        @endif
                        @foreach ($registerForm as $field)
                            <div>
                                <label for="{{ $field['name'] }}"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{ $field['label'] }}</label>
                                <input type="{{ $field['type'] }}" name="{{ $field['name'] }}" id="{{ $field['name'] }}"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                    placeholder="{{ $field['placeholder'] }}" wire:model="{{ $field['model'] }}">
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
                        <button type="submit"
                            class="w-full text-white bg-primary-600 hover:bg-primary-700 focus:ring-4 focus:outline-none focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800">Sign
                            in</button>
                        <p class="text-sm font-light text-gray-500 dark:text-gray-400">
                            Do have an account yet? <a
                                class="font-medium text-primary-600 hover:underline dark:text-primary-500 cursor-pointer"
                                wire:click.prevent="toggleForm">Sign in</a>
                        </p>
                    </form>
                @else
                    <form class="space-y-4 md:space-y-6" wire:submit.prevent="login">
                        @if (session()->has('error'))
                            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4" role="alert">
                                <p class="font-bold">Something is wrong</p>
                                <p>{{ session('error') }}</p>
                            </div>
                        @endif
                        @foreach ($loginForm as $field)
                            <div>
                                <label for="{{ $field['name'] }}"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{ $field['label'] }}</label>
                                <input type="{{ $field['type'] }}" name="{{ $field['name'] }}"
                                    id="{{ $field['name'] }}"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                    placeholder="{{ $field['placeholder'] }}" wire:model="{{ $field['model'] }}">
                                @if ($field['name'] === 'email')
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
                        {{-- <div class="flex items-center justify-between">
                            <a href="#"
                                class="text-sm font-medium text-primary-600 hover:underline dark:text-primary-500">Forgot
                                password?</a>
                        </div> --}}
                        <button type="submit"
                            class="w-full text-white bg-primary-600 hover:bg-primary-700 focus:ring-4 focus:outline-none focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800">Sign
                            in</button>
                        <p class="text-sm font-light text-gray-500 dark:text-gray-400">
                            Don’t have an account yet? <a
                                class="font-medium text-primary-600 hover:underline dark:text-primary-500 cursor-pointer"
                                wire:click.prevent="toggleForm">Sign up</a>
                        </p>
                    </form>
                @endif
            </div>
        </div>
    </div>
</section>
