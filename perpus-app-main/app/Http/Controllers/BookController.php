<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;

class BookController extends Controller
{
    public function index()
    {
        // Mengambil seluruh data buku, diurutkan dari yang terbaru, dibagi per 10 data (paginasi)
        $books = Book::latest()->paginate(10);

        // Nama halaman cukup 'Books/Index' (tanpa .vue dan tanpa path lengkap)
        return inertia('Books/Index', [
            'books' => $books,
        ]);
    }

    public function create()
    {
        return inertia('Books/Create');
    }

    public function store(Request $request)
    {
        // 1. Validasi data yang dikirim dari form
        $validated = $request->validate([
            'kode_buku' => 'required|unique:books,kode_buku', // wajib diisi, tidak boleh sama dengan kode_buku lain
            'judul'     => 'required|max:255',
            'pengarang' => 'required|max:255',
            'penerbit'  => 'nullable|max:255',                // boleh kosong
            'tahun'     => 'nullable|digits:4',               // jika diisi, harus 4 digit angka
            'stok'      => 'required|integer|min:0',          // tidak boleh negatif
        ]);

        // 2. Simpan sebagai baris baru di tabel books
        //    (nama kolom di database: penulis dan tahun_terbit)
        Book::create([
            'kode_buku'    => $validated['kode_buku'],
            'judul'        => $validated['judul'],
            'penulis'      => $validated['pengarang'],
            'penerbit'     => $validated['penerbit'] ?? null,
            'tahun_terbit' => $validated['tahun'] ?? null,
            'stok'         => $validated['stok'],
        ]);

        // 3. Arahkan kembali ke daftar buku, sertakan pesan sukses
        return redirect()->route('books.index')->with('success', 'Buku berhasil ditambahkan');
    }

    // Method di bawah ini dikerjakan pada Pertemuan 7
    public function show(Book $book)
    {
        //
    }

    public function edit(Book $book)
    {
        //
    }

    public function update(Request $request, Book $book)
    {
        //
    }

    public function destroy(Book $book)
    {
        //
    }
}
