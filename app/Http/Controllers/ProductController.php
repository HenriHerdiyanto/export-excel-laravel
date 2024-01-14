<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categori = Category::all();
        $products = Product::all();
        return view("admin.product", compact("products", "categori"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validate = $request->validate([
            'name' => 'required|string',
            'description' => 'required|string',
            'price' => 'required|numeric',
            'image' => 'file|mimes:pdf|max:2048|nullable',
            'categori_id' => 'required|exists:categories,id', // Perbaiki nama kolom menjadi 'categori_id'
            'status' => 'required',
        ]);

        $nama_file = null;

        if ($request->hasFile('image')) {
            $file = $request->file('image');

            if ($file->isValid()) {
                $nama_file = time() . "_" . $file->getClientOriginalName();
                $tujuan_upload = public_path('image');

                if (!file_exists($tujuan_upload)) {
                    mkdir($tujuan_upload, 0755, true);
                }

                $file->move($tujuan_upload, $nama_file);
            } else {
                return redirect()->back()->withErrors(['error' => 'Gagal mengunggah gambar. File tidak valid.']);
            }
        }

        $product = new Product();
        $product->name = $validate['name'];
        $product->description = $validate['description'];
        $product->price = $validate['price'];
        $product->image = $nama_file;
        $product->categori_id = $validate['categori_id']; // Perbaiki nama kolom menjadi 'categori_id'
        $product->status = $validate['status'];
        $product->save();

        return redirect()->back()->with('success', 'Produk berhasil ditambahkan.');
    }



    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // Temukan produk berdasarkan ID
        $product = Product::find($id);

        // Validasi data yang diterima dari formulir
        $validate = $request->validate([
            'name' => 'nullable|string',
            'description' => 'nullable|string',
            'price' => 'nullable|numeric',
            'image' => 'file|mimes:pdf|max:2048|nullable',
            'categori_id' => 'nullable|exists:categories,id',
            'status' => 'nullable',
        ]);

        // Inisialisasi $nama_file sebagai null
        $nama_file = null;

        // Cek apakah ada file gambar yang diunggah
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $nama_file = time() . "_" . $file->getClientOriginalName();
            $tujuan_upload = 'image';
            $file->move(public_path($tujuan_upload), $nama_file);

            // Hapus foto lama jika ada
            if ($product->image) {
                // Pastikan foto lama ada sebelum menghapus
                if (file_exists(public_path($tujuan_upload . '/' . $product->image))) {
                    unlink(public_path($tujuan_upload . '/' . $product->image));
                }
            }
        }

        // Update atribut produk dengan data yang divalidasi
        $product->name = $validate['name'];
        $product->description = $validate['description'];
        $product->price = $validate['price'];
        $product->categori_id = $validate['categori_id'];
        $product->status = $validate['status'];

        // Jika ada file gambar yang diunggah, update atribut image
        if ($nama_file) {
            $product->image = $nama_file;
        }

        // Simpan perubahan
        $product->save();

        return redirect()->back()->with('success', 'Product updated successfully.');
    }




    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $product = Product::find($id);

        // Hapus file gambar jika ada
        if ($product->image) {
            $imagePath = public_path('image/' . $product->image);

            // Pastikan file gambar ada sebelum dihapus
            if (file_exists($imagePath)) {
                unlink($imagePath);
            }
        }

        $product->delete();

        return redirect()->back()->with('success', 'Product deleted successfully.');
    }

    public function exportData()
    {
        $products = Product::with('category')->get();
        return response()->json($products);
    }
}
