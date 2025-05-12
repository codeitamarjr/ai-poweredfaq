<div>
    <div class="flex flex-col flex-auto flex-shrink-0 rounded-2xl bg-gray-100 dark:bg-gray-800 h-full p-4">
        <div class="flex flex-col h-full overflow-x-auto mb-4">
            <div class="flex flex-col h-full">
                <div class="grid grid-cols-12 gap-y-2">
                    @foreach ($messages as $interaction)
                        @if ($interaction->question)
                            <div class="col-start-1 col-end-8 p-3 rounded-lg">
                                <div class="flex flex-row items-center">
                                    <div
                                        class="flex items-center justify-center size-8 rounded-full bg-gray-500 dark:bg-gray-600 flex-shrink-0 text-white dark:text-gray-200">
                                        {{ Auth::user()->initials() }}
                                    </div>
                                    <div
                                        class="relative ml-3 text-sm bg-white dark:bg-gray-700 py-2 px-4 shadow rounded-xl">
                                        <div>{{ $interaction->question }}</div>
                                    </div>
                                </div>
                            </div>
                        @endif
                        @if ($interaction->answer)
                            <div class="col-start-6 col-end-13 p-3 rounded-lg">
                                <div class="flex items-center justify-start flex-row-reverse">
                                    <div
                                        class="flex items-center justify-center size-8 rounded-full bg-indigo-500 dark:bg-indigo-600 flex-shrink-0">
                                        AI
                                    </div>
                                    <div
                                        class="relative mr-3 text-sm bg-indigo-100 dark:bg-indigo-800 py-2 px-4 shadow rounded-xl">
                                        <div>{{ $interaction->answer }}</div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    @endforeach
                    <div wire:loading wire:target="askQuestion" class="col-start-1 col-end-13 p-3 rounded-lg">
                        <div class="flex items-center justify-start flex-row-reverse">
                            <div
                                class="flex items-center justify-center size-8 rounded-full bg-indigo-500 flex-shrink-0">
                                AI
                            </div>
                            <div
                                class="relative mr-3 text-sm bg-indigo-100 dark:bg-indigo-800 py-2 px-4 shadow rounded-xl">
                                <div class="flex justify-center space-x-1 h-2.5">
                                    <div class="size-2 bg-blue-500 dark:bg-blue-400 rounded-full animate-bounce">
                                    </div>
                                    <div
                                        class="size-2 bg-blue-500 dark:bg-blue-400 rounded-full animate-bounce delay-100">
                                    </div>
                                    <div
                                        class="size-2 bg-blue-500 dark:bg-blue-400 rounded-full animate-bounce delay-200">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="flex flex-row items-center h-16 rounded-xl bg-white dark:bg-gray-700 w-full px-4"
            wire:loading.class="hidden" x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 transform -translate-y-4"
            x-transition:enter-end="opacity-100 transform translate-y-0"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100 transform translate-y-0"
            x-transition:leave-end="opacity-0 transform -translate-y-4">
            <div class="flex-grow ml-4">
                <div class="relative w-full">
                    <input type="text" wire:model="question" placeholder="Type your question..." required
                        wire:keydown.enter="askQuestion" wire:target="askQuestion"
                        class="flex w-full border rounded-xl focus:outline-none focus:border-indigo-300 dark:border-gray-600 pl-4 h-10" />
                </div>
            </div>
            <div class="ml-4">
                <button wire:click="askQuestion" wire:target="askQuestion" wire:loading.class="cursor-not-allowed"
                    class="flex items-center justify-center bg-indigo-500 dark:bg-indigo-600 hover:bg-indigo-600 dark:hover:bg-indigo-700 rounded-xl text-white dark:text-gray-200 px-4 py-1 flex-shrink-0 transition duration-200 ease-in-out">
                    <span>Send</span>
                    <span class="ml-2">
                        <div wire:target="askQuestion">
                            <svg class="size-4 transform rotate-45 -mt-px" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                            </svg>
                        </div>
                    </span>
                </button>
            </div>
        </div>
        <div class="text-center" wire:loading wire:target="askQuestion">
            <div role="status">
                <svg aria-hidden="true"
                    class="inline w-8 h-8 text-gray-200 animate-spin dark:text-gray-600 fill-blue-600"
                    viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path
                        d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z"
                        fill="currentColor" />
                    <path
                        d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z"
                        fill="currentFill" />
                </svg>
                <span class="sr-only">Loading...</span>
            </div>
        </div>
    </div>
</div>
