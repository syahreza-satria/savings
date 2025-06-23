@extends('layouts.auth')

@section('content')
    <div
        class="flex flex-col-reverse items-center justify-center gap-4 mx-auto bg-white lg:h-screen lg:flex-row-reverse lg:max-w-7xl">
        <section class="max-w-xl mx-auto space-y-2">
            <h1 class="text-2xl font-medium">Registrasi Akun 👋</h1>
            <p class="text-sm leading-relaxed text-gray-500 lg:text-base font-extralight">
                Silahkan lengkapi data kamu untuk melakukan pendaftaran akun
            </p>
            <div class="flex flex-col w-full max-w-sm">
                <form action="{{ route('register') }}" method="POST">
                    @csrf
                    <div class="mb-6 space-y-2">
                        <div class="space-y-2">
                            <label for="name" class="text-sm">Nama Lengkap</label>
                            <input type="text" name="name" placeholder="John Doe"
                                class="flex flex-col w-full px-4 py-2 transition duration-500 border rounded-lg outline-none bg-indigo-50 focus:border-indigo-500 focus:bg-white hover:bg-white"
                                required>
                        </div>
                        <div class="space-y-2">
                            <label for="username" class="text-sm">Username</label>
                            <input type="text" name="username" placeholder="noobmaster69"
                                class="flex flex-col w-full px-4 py-2 transition duration-500 border rounded-lg outline-none bg-indigo-50 focus:border-indigo-500 focus:bg-white hover:bg-white"
                                required>
                        </div>
                        <div class="space-y-2">
                            <label for="email" class="text-sm">Email</label>
                            <input type="text" name="email" placeholder="johndoe@gmail.com"
                                class="flex flex-col w-full px-4 py-2 transition duration-500 border rounded-lg outline-none bg-indigo-50 focus:border-indigo-500 focus:bg-white hover:bg-white"
                                required>
                        </div>
                        <div class="relative space-y-2">
                            <label for="password" class="text-sm">Password</label>
                            <div class="relative">
                                <input type="password" name="password" id="password" placeholder="••••••••"
                                    class="flex flex-col w-full px-4 py-2 pr-10 transition duration-500 border rounded-lg outline-none bg-indigo-50 focus:border-indigo-500 focus:bg-white hover:bg-white"
                                    required>
                                <button type="button"
                                    onclick="togglePassword('password', 'eye-icon-password', 'eye-slash-icon-password')"
                                    class="absolute inset-y-0 right-0 flex items-center pr-3 focus:outline-none">
                                    <svg id="eye-icon-password" xmlns="http://www.w3.org/2000/svg"
                                        class="w-5 h-5 text-gray-500" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                    <svg id="eye-slash-icon-password" xmlns="http://www.w3.org/2000/svg"
                                        class="hidden w-5 h-5 text-gray-500" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                        <div class="relative space-y-2">
                            <label for="password_confirmation" class="text-sm">Masukkan Ulang Password</label>
                            <div class="relative">
                                <input type="password" name="password_confirmation" id="password_confirmation"
                                    placeholder="••••••••"
                                    class="flex flex-col w-full px-4 py-2 pr-10 transition duration-500 border rounded-lg outline-none bg-indigo-50 focus:border-indigo-500 focus:bg-white hover:bg-white"
                                    required>
                                <button type="button"
                                    onclick="togglePassword('password_confirmation', 'eye-icon-confirm', 'eye-slash-icon-confirm')"
                                    class="absolute inset-y-0 right-0 flex items-center pr-3 focus:outline-none">
                                    <svg id="eye-icon-confirm" xmlns="http://www.w3.org/2000/svg"
                                        class="w-5 h-5 text-gray-500" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                    <svg id="eye-slash-icon-confirm" xmlns="http://www.w3.org/2000/svg"
                                        class="hidden w-5 h-5 text-gray-500" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                    <button type="submit"
                        class="w-full py-2 font-light text-white transition duration-500 bg-indigo-500 rounded-lg hover:bg-indigo-600">Masuk</button>
                </form>
                <p class="block mt-8 text-sm text-center">Sudah memiliki akun? <a href="{{ route('login') }}"
                        class="text-indigo-500 transition duration-300 hover:text-indigo-300">Masuk Sekarang</a></p>
            </div>
        </section>
        <section class="flex items-center mx-auto">
            <img src="https://images.unsplash.com/photo-1484807352052-23338990c6c6?q=80&w=1740&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D"
                alt="Illustration" class="aspect-[16/6] lg:aspect-[4/5] lg:max-w-lg rounded-2xl object-cover ">
        </section>
    </div>
@endsection
