@extends('layouts.auth')

@section('content')
    <div
        class="flex flex-col-reverse items-center justify-center gap-4 mx-auto bg-white lg:h-screen lg:flex-row lg:max-w-7xl">
        <section class="max-w-xl mx-auto space-y-2">
            <h1 class="text-2xl font-medium">Welcome Back 👋</h1>
            <p class="text-sm leading-relaxed text-gray-500 lg:text-base font-extralight">
                Hari yang baru telah tiba. Inilah harinya untuk mengatur pemasukan, pengeluaran, dan tabungan kamu!
            </p>
            <div class="flex flex-col w-full max-w-sm">
                <form action="{{ route('login') }}" method="POST" class="space-y-4">
                    @csrf
                    <div class="space-y-2">
                        <label for="email" class="text-sm">Email</label>
                        <input type="text" name="email" placeholder="johndoe@gmail.com"
                            class="flex flex-col w-full px-4 py-2 transition duration-500 border rounded-lg outline-none bg-indigo-50 focus:border-indigo-500 focus:bg-white hover:bg-white">
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
                                <svg id="eye-icon-password" xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-gray-500"
                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
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
                    {{-- <a href="#"
                        class="block text-indigo-500 transition duration-300 hover:underline hover:text-indigo-600 text-end">Lupa
                        Password</a> --}}
                    <button type="submit"
                        class="w-full py-2 font-light text-white transition duration-500 bg-indigo-500 rounded-lg hover:bg-indigo-600">Masuk</button>
                </form>
                <div class="flex items-center my-8">
                    <hr class="flex-grow border-t border-gray-300">
                    <span class="px-3 text-sm text-gray-500">Atau</span>
                    <hr class="flex-grow border-t border-gray-300">
                </div>
                <a href="{{ route('redirect.google') }}"
                    class="flex items-center justify-center w-full px-4 py-2 space-x-3 transition duration-500 border rounded-lg bg-indigo-50 hover:bg-white">
                    <svg version="1.1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 48 48"
                        xmlns:xlink="http://www.w3.org/1999/xlink" style="display: block;" class="size-6">
                        <path fill="#EA4335"
                            d="M24 9.5c3.54 0 6.71 1.22 9.21 3.6l6.85-6.85C35.9 2.38 30.47 0 24 0 14.62 0 6.51 5.38 2.56 13.22l7.98 6.19C12.43 13.72 17.74 9.5 24 9.5z">
                        </path>
                        <path fill="#4285F4"
                            d="M46.98 24.55c0-1.57-.15-3.09-.38-4.55H24v9.02h12.94c-.58 2.96-2.26 5.48-4.78 7.18l7.73 6c4.51-4.18 7.09-10.36 7.09-17.65z">
                        </path>
                        <path fill="#FBBC05"
                            d="M10.53 28.59c-.48-1.45-.76-2.99-.76-4.59s.27-3.14.76-4.59l-7.98-6.19C.92 16.46 0 20.12 0 24c0 3.88.92 7.54 2.56 10.78l7.97-6.19z">
                        </path>
                        <path fill="#34A853"
                            d="M24 48c6.48 0 11.93-2.13 15.89-5.81l-7.73-6c-2.15 1.45-4.92 2.3-8.16 2.3-6.26 0-11.57-4.22-13.47-9.91l-7.98 6.19C6.51 42.62 14.62 48 24 48z">
                        </path>
                        <path fill="none" d="M0 0h48v48H0z"></path>
                    </svg>
                    <span class="text-sm font-medium">Sign in with Google</span>
                </a>
                <p class="block mt-8 text-sm text-center">Belum memiliki akun? <a href="{{ route('register') }}"
                        class="text-indigo-500 transition duration-300 hover:text-indigo-300">Daftar Sekarang</a></p>
            </div>
        </section>
        <section class="flex items-center mx-auto">
            <img src="https://images.unsplash.com/photo-1593672715438-d88a70629abe?q=80&w=774&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D"
                alt="Illustration" class="aspect-[16/6] lg:aspect-[4/5] lg:max-w-lg rounded-2xl object-cover">
        </section>
    </div>
@endsection
