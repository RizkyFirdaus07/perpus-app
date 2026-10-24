
<script setup>
import { Link, usePage } from '@inertiajs/vue3';

const page = usePage();
</script>

<template>
    <div class="min-h-screen bg-gray-100">
        <div class="flex min-h-screen">
            <aside class="w-56 shrink-0 bg-slate-800 text-white">
                <div class="border-b border-slate-700 px-5 py-5">
                    <h1 class="text-lg font-bold">Perpustakaan Mini</h1>
                </div>

                <nav class="space-y-1 p-3">
                    <Link
                        href="/dashboard"
                        class="block rounded px-3 py-2 hover:bg-slate-700"
                        :class="{ 'bg-slate-700': page.url === '/dashboard' }"
                    >
                        Dashboard
                    </Link>

                    <Link
                        href="/"
                        class="block rounded px-3 py-2 hover:bg-slate-700"
                    >
                        Beranda
                    </Link>

                    <Link
                        href="/books"
                        class="block rounded px-3 py-2 hover:bg-slate-700"
                        :class="{ 'bg-slate-700': page.url.startsWith('/books') }"
                    >
                        Data Buku
                    </Link>
                </nav>
            </aside>

            <div class="min-w-0 flex-1">
                <header class="flex h-16 items-center justify-between bg-white px-6 shadow-sm">
                    <span class="font-medium text-gray-700">Dashboard</span>
                    <span class="text-sm text-gray-600">
                        {{ page.props.auth?.user?.name ?? 'Pengguna' }}
                    </span>
                </header>

                <main class="p-6">
                    <slot />
                </main>
            </div>
        </div>
    </div>
</template>
