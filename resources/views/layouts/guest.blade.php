<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
    <head>
        @include('partials.head')
    </head>
    <body class="h-screen flex flex-col overflow-hidden bg-white dark:bg-zinc-800">
        <header class="sticky top-0 z-50 shrink-0 border-b border-zinc-200 bg-white/90 dark:border-zinc-700 dark:bg-zinc-900/90 backdrop-blur-sm">
            <div class="mx-auto flex h-14 max-w-screen-2xl items-center justify-between px-4 lg:px-6">
                <a href="{{ route('home') }}" class="font-semibold text-lg text-zinc-900 dark:text-white" wire:navigate>
                    {{ config('app.name', 'SapiHalal') }}
                </a>

                <nav class="flex items-center gap-3 text-sm">
                    @auth
                        <a href="{{ route('dashboard') }}" class="rounded-lg px-3 py-1.5 text-zinc-600 hover:bg-zinc-100 dark:text-zinc-400 dark:hover:bg-zinc-800" wire:navigate>
                            Dashboard
                        </a>
                    @else
                        @if (Route::has('login'))
                            <a href="{{ route('login') }}" class="rounded-lg bg-zinc-900 px-4 py-2 text-white hover:bg-zinc-700 dark:bg-white dark:text-zinc-900 dark:hover:bg-zinc-200">
                                Log in
                            </a>
                        @endif
                    @endauth
                </nav>
            </div>
        </header>

        <main class="flex-1 w-full min-h-0">
            {{ $slot }}
        </main>

        @persist('toast')
            <flux:toast.group>
                <flux:toast />
            </flux:toast.group>
        @endpersist

        @fluxScripts
    </body>
</html>
