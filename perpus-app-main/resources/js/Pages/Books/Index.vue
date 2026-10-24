<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, router, usePage } from '@inertiajs/vue3';
import { ref } from 'vue';

// 'books' dan 'search' dikirim dari BookController@index
const props = defineProps({
    books: Object,
    search: String,
});

const page = usePage();

// Nilai awal kotak pencarian diambil dari props.search
const keyword = ref(props.search ?? '');

// Dijalankan saat pengguna menekan Enter pada kotak pencarian
function cari() {
    router.get('/books', { search: keyword.value }, { preserveState: true });
}

// Dijalankan saat tombol Hapus diklik
function hapus(book) {
    // Kode di dalam if hanya berjalan jika pengguna menekan 'OK'
    if (confirm(`Yakin ingin menghapus buku "${book.judul}"?`)) {
        router.delete(route('books.destroy', book.id));
    }
}
</script>

<template>
    <Head title="Data Buku" />

    <AuthenticatedLayout>
        <h1 class="mb-6 text-2xl font-bold text-gray-800">Data Buku</h1>

        <!-- Flash message (tersedia karena HandleInertiaRequests) -->
        <div
            v-if="page.props.flash?.success"
            class="mb-4 rounded-md bg-green-100 px-4 py-3 text-green-800"
        >
            {{ page.props.flash.success }}
        </div>
        <div
            v-if="page.props.flash?.error"
            class="mb-4 rounded-md bg-red-100 px-4 py-3 text-red-800"
        >
            {{ page.props.flash.error }}
        </div>

        <div class="mb-4 flex flex-wrap items-center gap-3">
            <Link
                href="/books/create"
                class="rounded-md bg-blue-600 px-4 py-2 font-semibold text-white hover:bg-blue-700"
            >
                + Tambah Buku
            </Link>

            <!-- @keyup.enter memanggil cari() hanya saat Enter ditekan -->
            <input
                v-model="keyword"
                @keyup.enter="cari"
                type="text"
                placeholder="Cari kode, judul, atau pengarang..."
                class="w-72 rounded-md border border-gray-300 px-3 py-2"
            />
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
                        <th class="px-4 py-3">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="book in books.data" :key="book.id" class="border-t">
                        <td class="px-4 py-3">{{ book.kode_buku }}</td>
                        <td class="px-4 py-3">{{ book.judul }}</td>
                        <td class="px-4 py-3">{{ book.penulis }}</td>
                        <td class="px-4 py-3">{{ book.tahun_terbit ?? '-' }}</td>
                        <td class="px-4 py-3">{{ book.stok }}</td>
                        <td class="px-4 py-3">
                            <div class="flex gap-3">
                                <Link
                                    :href="route('books.edit', book.id)"
                                    class="font-medium text-blue-600 hover:underline"
                                >
                                    Edit
                                </Link>
                                <button
                                    type="button"
                                    class="font-medium text-red-600 hover:underline"
                                    @click="hapus(book)"
                                >
                                    Hapus
                                </button>
                            </div>
                        </td>
                    </tr>

                    <tr v-if="books.data.length === 0">
                        <td colspan="6" class="px-4 py-6 text-center text-gray-500">
                            Tidak ada data buku.
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Paginasi -->
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