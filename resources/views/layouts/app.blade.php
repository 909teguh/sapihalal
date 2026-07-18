<x-layouts::app.sidebar :title="$title ?? null">
    <flux:main class="flex flex-col">
        <div class="flex-1">
            {{ $slot }}
        </div>

        <footer class="shrink-0 border-t border-zinc-200 bg-zinc-50 py-3 text-center text-xs text-zinc-500 dark:border-zinc-700 dark:bg-zinc-900 dark:text-zinc-400">
            &copy; {{ date('Y') }} DINAS PERTANIAN KOTA PADANG
        </footer>
    </flux:main>
</x-layouts::app.sidebar>
