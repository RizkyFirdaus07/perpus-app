<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, usePage } from '@inertiajs/vue3';

// 'books' menerima data yang dikirim dari BookController@index
defineProps({
    books: Object,
});

const page = usePage();
</script>

<template>
    <Head title="Data Buku" />

    <AuthenticatedLayout>
        <div class="mb-6 flex items-center justify-between">
            <h1 class="text-2xl font-bold text-gray-800">Data Buku</h1>

            <Link
                href="/books/create"
                class="rounded-md bg-blue-600 px-4 py-2 font-semibold text-white hover:bg-blue-700"
            >
                + Tambah Buku
            </Link>
        </div>

        <!-- Pesan sukses setelah menambah buku -->
        <div
            v-if="page.props.flash?.success"
            class="mb-4 rounded-md bg-green-100 px-4 py-3 text-green-800"
        >
            {{ page.props.flash.success }}
        </div>

        <div class="overflow-hidden rounded-lg bg-white shadow-sm">
            <table class="w-full text-left text-sm">
                <thead class="bg-gray-50 text-gray-700">
                    <tr>
                        <th class="px-4 py-3">Kode</th>
                        <th class="px-4 py-3">Judul</th>
                        <th class="px-4 py-3">Pengarang</th>
                        <th class="px-4 py-3">Tahun</th>
                        <th class="px-4 py-3">Stok</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- v-for mengulang setiap data buku, sama seperti foreach -->
                    <tr
                        v-for="book in books.data"
                        :key="book.id"
                        class="border-t"
                    >
                        <td class="px-4 py-3">{{ book.kode_buku }}</td>
                        <td class="px-4 py-3">{{ book.judul }}</td>
                        <td class="px-4 py-3">{{ book.penulis }}</td>
                        <td class="px-4 py-3">{{ book.tahun_terbit ?? '-' }}</td>
                        <td class="px-4 py-3">{{ book.stok }}</td>
                    </tr>

                    <tr v-if="books.data.length === 0">
                        <td colspan="5" class="px-4 py-6 text-center text-gray-500">
                            Belum ada data buku.
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Paginasi (hasil paginate(10) dari Controller) -->
        <div v-if="books.links.length > 3" class="mt-4 flex flex-wrap gap-1">
            <template v-for="link in books.links" :key="link.label">
                <Link
                    v-if="link.url"
                    :href="link.url"
                    class="rounded border px-3 py-1 text-sm"
                    :class="link.active ? 'bg-blue-600 text-white' : 'bg-white hover:bg-gray-100'"
                    v-html="link.label"
                />
                <span
                    v-else
                    class="rounded border px-3 py-1 text-sm text-gray-400"
                    v-html="link.label"
                />
            </template>
        </div>
    </AuthenticatedLayout>
</template>
