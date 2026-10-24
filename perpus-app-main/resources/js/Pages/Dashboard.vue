
<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <div class="mb-6">
            <h1 class="text-2xl font-bold text-gray-800">
                Dashboard
            </h1>
            <p class="mt-1 text-gray-600">
                Sistem Informasi Peminjaman Buku Perpustakaan Mini
            </p>
        </div>

        <div class="grid gap-4 md:grid-cols-3">
            <div class="rounded-lg bg-white p-5 shadow-sm">
                <p class="text-sm text-gray-500">Total Buku</p>
                <h2 class="mt-2 text-2xl font-bold text-slate-800">Data Buku</h2>
                <Link href="/books" class="mt-3 inline-block text-sm text-blue-600 hover:underline">
                    Lihat Data Buku
                </Link>
            </div>

            <div class="rounded-lg bg-white p-5 shadow-sm">
                <p class="text-sm text-gray-500">Pengelolaan</p>
                <h2 class="mt-2 text-xl font-bold text-slate-800">Tambah Buku</h2>
                <Link href="/books/create" class="mt-3 inline-block text-sm text-blue-600 hover:underline">
                    Tambah Data
                </Link>
            </div>

            <div class="rounded-lg bg-white p-5 shadow-sm">
                <p class="text-sm text-gray-500">Aplikasi</p>
                <h2 class="mt-2 text-xl font-bold text-slate-800">Perpustakaan Mini</h2>
                <p class="mt-3 text-sm text-gray-600">Kelola informasi buku perpustakaan.</p>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
