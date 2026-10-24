<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;

class BookController extends Controller
{
    public function index(Request $request)
    {
        // Pencarian hanya dijalankan jika ada kata kunci (?search=...)
        // Cocok di kode buku, judul, ATAU pengarang (kolom database: penulis)
        $books = Book::when($request->search, function ($query, $search) {
            $query->where(function ($q) use ($search) {
                $q->where('kode_buku', 'like', "%{$search}%")
                  ->orWhere('judul', 'like', "%{$search}%")
                  ->orWhere('penulis', 'like', "%{$search}%");
            });
        })
            ->latest()
            ->paginate(10)
            ->withQueryString(); // kata kunci tetap terbawa saat pindah halaman

        return inertia('Books/Index', [
            'books'  => $books,
            'search' => $request->search, // dikirim balik agar kotak pencarian tetap terisi
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

    // show() dikerjakan pada pertemuan berikutnya
    public function show(Book $book)
    {
        //
    }

    public function edit(Book $book)
    {
        // $book otomatis berisi data buku yang akan diedit (Route Model Binding).
        // Nama kolom database dipetakan ke nama input pada form.
        return inertia('Books/Edit', [
            'book' => [
                'id'        => $book->id,
                'kode_buku' => $book->kode_buku,
                'judul'     => $book->judul,
                'pengarang' => $book->penulis,
                'penerbit'  => $book->penerbit,
                'tahun'     => $book->tahun_terbit,
                'stok'      => $book->stok,
            ],
        ]);
    }

    public function update(Request $request, Book $book)
    {
        // Aturan sama seperti store(), kecuali unique pada kode_buku:
        // kode milik buku ini sendiri dikecualikan agar tidak dianggap duplikat.
        $validated = $request->validate([
            'kode_buku' => 'required|unique:books,kode_buku,' . $book->id,
            'judul'     => 'required|max:255',
            'pengarang' => 'required|max:255',
            'penerbit'  => 'nullable|max:255',
            'tahun'     => 'nullable|digits:4',
            'stok'      => 'required|integer|min:0',
        ]);

        // Petakan input form ke nama kolom database
        $book->update([
            'kode_buku'    => $validated['kode_buku'],
            'judul'        => $validated['judul'],
            'penulis'      => $validated['pengarang'],
            'penerbit'     => $validated['penerbit'] ?? null,
            'tahun_terbit' => $validated['tahun'] ?? null,
            'stok'         => $validated['stok'],
        ]);

        return redirect()->route('books.index')->with('success', 'Buku berhasil diperbarui');
    }

    public function destroy(Book $book)
    {
        // Menghapus baris data buku ini secara permanen dari tabel books
        $book->delete();

        // Kembali ke daftar buku, sertakan flash message
        return redirect()->route('books.index')->with('success', 'Buku berhasil dihapus');
    }
}