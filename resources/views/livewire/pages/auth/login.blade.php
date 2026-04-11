<?php

use App\Livewire\Forms\LoginForm;
use Illuminate\Support\Facades\Session;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component
{
    public LoginForm $form;

    /**
     * Handle an incoming authentication request.
     */
    public function login(): void
    {
        $this->validate();

        $this->form->authenticate();

        Session::regenerate();

        $this->redirectIntended(default: route('dashboard', absolute: false), navigate: true);
    }
}; ?>

<div>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form wire:submit="login">
        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input wire:model="form.email" id="email" class="block mt-1 w-full" type="email" name="email" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('form.email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input wire:model="form.password" id="password" class="block mt-1 w-full"
                type="password"
                name="password"
                required autocomplete="current-password" />

            <x-input-error :messages="$errors->get('form.password')" class="mt-2" />
        </div>

        <!-- Remember Me & Forgot Password -->
        <div class="flex items-center justify-between mt-6">
            <label for="remember" class="inline-flex items-center group cursor-pointer">
                <div class="relative flex items-center justify-center">
                    <input wire:model="form.remember" id="remember" type="checkbox" class="peer rounded-md border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500 transition-all duration-300 z-10 cursor-pointer" name="remember">
                    <!-- Subtle ping effect when clicked -->
                    <div class="absolute inset-0 rounded-md bg-indigo-500/20 scale-0 peer-checked:scale-150 opacity-0 peer-checked:opacity-0 transition-all duration-500"></div>
                </div>
                <span class="ms-2 text-sm text-gray-600 group-hover:text-gray-900 transition-colors duration-300">{{ __('Remember me') }}</span>
            </label>

            @if (Route::has('password.request'))
            <a class="text-sm font-medium text-indigo-600 hover:text-indigo-500 transition-colors duration-300 relative group focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 rounded-sm" href="{{ route('password.request') }}" wire:navigate>
                {{ __('Forgot password?') }}
                <span class="absolute -bottom-0.5 left-0 w-0 h-[2px] bg-indigo-500 transition-all duration-300 group-hover:w-full rounded-full"></span>
            </a>
            @endif
        </div>

        <!-- Submit Button: Minlish Floating -->
        <div class="mt-8 flex justify-center">
            <button type="submit" class="group relative inline-flex justify-center items-center py-2.5 px-8 border border-transparent text-sm font-bold rounded-xl text-white bg-gradient-to-r from-indigo-600 via-purple-600 to-indigo-600 bg-[length:200%_auto] hover:bg-[center_right_1rem] shadow-[0_4px_15px_rgb(99,102,241,0.4)] hover:shadow-[0_8px_25px_rgb(99,102,241,0.6)] hover:-translate-y-1 transition-all duration-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 overflow-hidden z-10">
                <div class="absolute inset-0 w-full h-full bg-white/20 scale-x-0 group-hover:scale-x-100 origin-left transition-transform duration-500 ease-in-out z-0"></div>
                <span class="relative z-20 flex items-center gap-2">
                    {{ __('Log in') }}
                    <svg class="w-4 h-4 group-hover:translate-x-1.5 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                    </svg>
                </span>
            </button>
        </div>

        <!-- Sign Up Link -->
        <div class="mt-6 text-center text-sm">
            <span class="text-gray-500">{{ __("Don't have an account?") }}</span>
            <a href="{{ Route::has('register') ? route('register') : '#' }}" class="ml-1 font-semibold text-indigo-600 hover:text-indigo-500 transition-colors duration-300 relative group inline-block focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 rounded-sm" wire:navigate>
                {{ __('Sign up') }}
                <span class="absolute -bottom-0.5 left-0 w-0 h-[2px] bg-indigo-500 transition-all duration-300 group-hover:w-full rounded-full"></span>
            </a>
        </div>

        <!-- Minlish Design Google Login -->
        <div class="mt-6">
            <div class="relative mb-6">
                <div class="absolute inset-0 flex items-center">
                    <div class="w-full border-t border-gray-200"></div>
                </div>
                <div class="relative flex justify-center text-sm">
                    <span class="px-3 bg-[#f3f4f6]  rounded-full">{{ __('Hoặc tiếp tục với') }}</span>
                </div>
            </div>

            <a href="{{ route('google.login') }}"
                class="group relative flex w-full items-center justify-center gap-3 px-4 py-3 bg-white/80 backdrop-blur-md border border-slate-200 font-semibold text-slate-700 rounded-xl shadow-sm hover:shadow-[0_8px_30px_rgb(0,0,0,0.06)] hover:border-slate-300 hover:-translate-y-0.5 transition-all duration-300 overflow-hidden outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#4285F4]">
                <!-- Border Bottom Gradient Line -->
                <span class="absolute inset-x-0 bottom-0 h-[3px] opacity-0 group-hover:opacity-100 transition-opacity duration-300" style="background: linear-gradient(to right, #4285F4, #34A853, #FBBC05, #EA4335);"></span>

                <!-- Shine Reflection (Minlish Glossy Effect) -->
                <div class="absolute inset-0 w-full h-full bg-gradient-to-t from-slate-50/80 to-transparent scale-y-0 group-hover:scale-y-100 origin-bottom transition-transform duration-500 ease-out z-0"></div>

                <div class="relative flex items-center gap-3 z-10">
                    <svg class="h-5 w-5 drop-shadow-sm group-hover:scale-110 transition-transform duration-300" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" fill="#4285F4" />
                        <path d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" fill="#34A853" />
                        <path d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z" fill="#FBBC05" />
                        <path d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" fill="#EA4335" />
                    </svg>
                    <span>Đăng nhập bằng Google</span>
                </div>
            </a>
        </div>
    </form>
</div>