@extends('layouts.app')

@section('content')
    <div class="p-6 mb-8 bg-white rounded-lg shadow-sm dark:bg-gray-800 dark:border dark:border-gray-700">
        <!-- Header Section -->
        <div class="mb-6">
            <h1 class="text-2xl font-semibold text-indigo-600 dark:text-indigo-400">Profile Information</h1>
            <p class="text-sm text-gray-500 dark:text-gray-400">Manage your account information and personal preferences</p>
        </div>

        <!-- Profile Overview -->
        <form action="{{ route('setting.update', $user) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="flex items-center gap-4 p-4 mb-8 rounded-lg bg-gray-50 dark:bg-gray-700/50">
                <!-- Profile Picture Container with Hover Effect -->
                <div class="relative group" x-data="{ photoPreview: '{{ $user->photo ? asset('storage/' . $user->photo) : 'https://ui-avatars.com/api/?name=' . urlencode($user->name) . '&background=random' }}' }">
                    <!-- Preview Image -->
                    <img x-bind:src="photoPreview" alt="{{ $user->name }}"
                        class="object-cover transition-opacity border-2 border-white rounded-full shadow size-20 group-hover:opacity-75 dark:border-gray-600">

                    <!-- Edit Overlay -->
                    <div
                        class="absolute inset-0 flex items-center justify-center transition-opacity opacity-0 group-hover:opacity-100">
                        <label for="photo-upload" class="cursor-pointer">
                            <div class="p-2 rounded-full bg-black/50 backdrop-blur-sm">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-white" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                            </div>
                        </label>
                        <input type="file" id="photo-upload" name="photo" class="hidden" accept="image/*"
                            x-on:change="
                   const file = $event.target.files[0];
                   if (file) {
                       if (file.size > 2097152) {
                           alert('File size should not exceed 2MB');
                           return;
                       }
                       const reader = new FileReader();
                       reader.onload = (e) => photoPreview = e.target.result;
                       reader.readAsDataURL(file);
                   }
               ">
                    </div>
                </div>

                <div>
                    <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-100">{{ $user->name }}</h2>
                    <p class="text-sm text-gray-500 dark:text-gray-400">{{ $user->email }}</p>
                    <p class="mt-1 text-xs text-gray-400 dark:text-gray-500">Member since
                        {{ $user->created_at->format('d M Y') }}</p>
                </div>
            </div>

            <hr class="my-6 border-gray-200 dark:border-gray-700">

            <!-- Personal Details Form -->
            <h2 class="mb-4 text-lg font-semibold text-indigo-600 dark:text-indigo-400">Personal Details</h2>

            <div class="grid grid-cols-1 gap-6 mb-6 md:grid-cols-2">
                <!-- Name Field -->
                <div class="space-y-2">
                    <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Full
                        Name</label>
                    <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}"
                        class="w-full px-4 py-2 text-gray-700 bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200 dark:placeholder-gray-400 dark:focus:ring-indigo-500 dark:focus:border-indigo-500">
                    @error('name')
                        <p class="text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Username Field -->
                <div class="space-y-2">
                    <label for="username"
                        class="block text-sm font-medium text-gray-700 dark:text-gray-300">Username</label>
                    <input type="text" id="username" name="username" value="{{ old('username', $user->username) }}"
                        class="w-full px-4 py-2 text-gray-700 bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200 dark:placeholder-gray-400 dark:focus:ring-indigo-500 dark:focus:border-indigo-500">
                    @error('username')
                        <p class="text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Email Field -->
                <div class="space-y-2">
                    <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Email</label>
                    <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}"
                        class="w-full px-4 py-2 text-gray-500 bg-gray-100 border border-gray-300 rounded-lg dark:bg-gray-700/50 dark:border-gray-600 dark:text-gray-400"
                        disabled>
                    <p class="text-xs text-gray-500 dark:text-gray-400">Contact admin to change email</p>
                </div>

                <!-- Phone Field -->
                <div class="space-y-2">
                    <label for="phone" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Phone
                        Number</label>
                    <input type="tel" id="phone" name="phone" value="{{ old('phone', $user->phone) }}"
                        class="w-full px-4 py-2 text-gray-700 bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200 dark:placeholder-gray-400 dark:focus:ring-indigo-500 dark:focus:border-indigo-500">
                    @error('phone')
                        <p class="text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Address Field -->
                <div class="space-y-2 md:col-span-2">
                    <label for="address" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Address</label>
                    <textarea id="address" name="address" rows="3"
                        class="w-full px-4 py-2 text-gray-700 bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200 dark:placeholder-gray-400 dark:focus:ring-indigo-500 dark:focus:border-indigo-500">{{ old('address', $user->address) }}</textarea>
                    @error('address')
                        <p class="text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <hr class="my-6 border-gray-200 dark:border-gray-700">

            <!-- Additional Information -->
            <h2 class="mb-4 text-lg font-semibold text-indigo-600 dark:text-indigo-400">Additional Information</h2>

            <div class="grid grid-cols-1 gap-6 mb-6 md:grid-cols-2">
                <!-- Gender Field -->
                <div class="space-y-2">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Gender</label>
                    <div class="flex gap-4 py-3">
                        <label class="inline-flex items-center">
                            <input type="radio" name="gender" value="M"
                                {{ old('gender', $user->gender) == 'M' ? 'checked' : '' }}
                                class="text-indigo-600 focus:ring-indigo-500 dark:text-indigo-400 dark:focus:ring-indigo-600">
                            <span class="ml-2 text-sm text-gray-700 dark:text-gray-300">Male</span>
                        </label>
                        <label class="inline-flex items-center">
                            <input type="radio" name="gender" value="F"
                                {{ old('gender', $user->gender) == 'F' ? 'checked' : '' }}
                                class="text-indigo-600 focus:ring-indigo-500 dark:text-indigo-400 dark:focus:ring-indigo-600">
                            <span class="ml-2 text-sm text-gray-700 dark:text-gray-300">Female</span>
                        </label>
                    </div>
                </div>

                <!-- Birthdate Field -->
                <div class="space-y-2">
                    <label for="birthdate" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Date of
                        Birth</label>
                    <input type="date" id="birthdate" name="birthdate"
                        value="{{ old('birthdate', $user->birthdate ? \Carbon\Carbon::parse($user->birthdate)->format('Y-m-d') : '') }}"
                        class="w-full px-4 py-2 text-gray-700 bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200 dark:placeholder-gray-400 dark:focus:ring-indigo-500 dark:focus:border-indigo-500">
                </div>
            </div>

            <!-- Form Actions -->
            <div class="flex items-center justify-between pt-6 mt-8 border-t border-gray-200 dark:border-gray-700">
                <!-- Delete Account Button with Confirmation Modal -->
                <button type="button" onclick="confirmDelete()"
                    class="px-4 py-2 text-sm font-medium text-white transition duration-300 bg-red-600 rounded-lg hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 dark:bg-red-500 dark:hover:bg-red-600">
                    Delete Account
                </button>

                <div class="flex justify-end gap-3">
                    <a href="{{ route('app') }}"
                        class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-300 dark:hover:bg-gray-600">
                        Cancel
                    </a>
                    <button type="submit"
                        class="px-4 py-2 text-sm font-medium text-white transition bg-indigo-600 rounded-lg hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:bg-indigo-500 dark:hover:bg-indigo-600">
                        Save Changes
                    </button>
                </div>
            </div>
        </form>
    </div>

    {{-- Modal --}}
    <div id="deleteModal" class="fixed inset-0 z-50 hidden overflow-y-auto">
        <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
            <!-- Background Overlay with Transition -->
            <div class="fixed inset-0 transition-opacity duration-300 ease-in-out" aria-hidden="true">
                <div id="modalBackdrop"
                    class="absolute inset-0 transition-opacity duration-300 opacity-0 bg-gray-500/75 dark:bg-gray-900/75">
                </div>
            </div>

            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

            <!-- Modal Container with Transform Transition -->
            <div id="modalContent"
                class="inline-block overflow-hidden text-left align-bottom transition-all transform translate-y-4 bg-white rounded-lg shadow-xl opacity-0 sm:translate-y-0 sm:scale-95 sm:my-8 sm:align-middle sm:max-w-lg sm:w-full dark:bg-gray-800"
                style="transition: all 0.3s ease-in-out;">
                <div class="px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div
                            class="flex items-center justify-center flex-shrink-0 w-12 h-12 mx-auto bg-red-100 rounded-full sm:mx-0 sm:h-10 sm:w-10 dark:bg-red-900/50">
                            <svg class="w-6 h-6 text-red-600 dark:text-red-400" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                            </svg>
                        </div>
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                            <h3 class="text-lg font-medium leading-6 text-gray-900 dark:text-gray-100">Delete Account</h3>
                            <div class="mt-2">
                                <p class="text-sm text-gray-500 dark:text-gray-400">Are you sure you want to delete your
                                    account? All data will be permanently removed. This action cannot be undone.</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="px-4 py-3 bg-gray-50 sm:px-6 sm:flex sm:flex-row-reverse dark:bg-gray-700/50">
                    <form id="deleteForm" action="{{ route('setting.destroy', $user) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                            class="inline-flex justify-center w-full px-4 py-2 text-base font-medium text-white bg-red-600 border border-transparent rounded-md shadow-sm hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:ml-3 sm:w-auto sm:text-sm dark:bg-red-500 dark:hover:bg-red-600 dark:focus:ring-red-600">
                            Delete
                        </button>
                    </form>
                    <button type="button" onclick="closeModal()"
                        class="inline-flex justify-center w-full px-4 py-2 mt-3 text-base font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm dark:bg-gray-600 dark:text-gray-300 dark:border-gray-600 dark:hover:bg-gray-500">
                        Cancel
                    </button>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            function confirmDelete() {
                const modal = document.getElementById('deleteModal');
                const backdrop = document.getElementById('modalBackdrop');
                const content = document.getElementById('modalContent');

                // Show modal
                modal.classList.remove('hidden');

                // Trigger reflow to enable animations
                void modal.offsetWidth;

                // Animate backdrop and content
                backdrop.classList.remove('opacity-0');
                backdrop.classList.add('opacity-75');

                content.classList.remove('opacity-0', 'translate-y-4', 'sm:scale-95');
                content.classList.add('opacity-100', 'translate-y-0', 'sm:scale-100');
            }

            function closeModal() {
                const modal = document.getElementById('deleteModal');
                const backdrop = document.getElementById('modalBackdrop');
                const content = document.getElementById('modalContent');

                // Animate out
                backdrop.classList.remove('opacity-75');
                backdrop.classList.add('opacity-0');

                content.classList.remove('opacity-100', 'translate-y-0', 'sm:scale-100');
                content.classList.add('opacity-0', 'translate-y-4', 'sm:scale-95');

                // Hide modal after animation completes
                setTimeout(() => {
                    modal.classList.add('hidden');
                }, 300); // Match this with your CSS transition duration
            }

            // Close modal when clicking outside
            window.onclick = function(event) {
                const modal = document.getElementById('deleteModal');
                if (event.target === modal) {
                    closeModal();
                }
            }
        </script>
    @endpush
@endsection
