<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Brand;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    public function index()
    {
        return view('admin.index');
    }

    public function dashboard()
    {
        return view('admin.dashboard');
    }

    public function brands(Request $request)
{
    $query = Brand::query();

    if ($request->filled('search')) {
        $query->where('name', 'like', '%' . $request->search . '%');
    }

    if (in_array($request->status, ['active', 'inactive'])) {
        $query->where('status', $request->status);
    }

    $brands = $query->orderBy('id', 'DESC')->paginate(10);

    $brands->appends($request->query());

    return view('admin.brands', compact('brands'));
}

    public function addBrand()
    {
        return view('admin.add-brand');
    }

    public function storeBrand(Request $request)
{
    $slug = Str::slug($request->slug ?: $request->name);

    $request->merge([
        'slug' => $slug
    ]);

    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'slug' => 'required|string|max:255|unique:brands,slug',
        'image' => 'required|image|mimes:png,jpg,jpeg,webp|max:2048',
    ]);

    try {
        $imagePath = $request->file('image')->store('brands', 'public');

        Brand::create([
            'name' => $validated['name'],
            'slug' => $validated['slug'],
            'image' => $imagePath,
            'status' => $request->boolean('is_active') ? 'active' : 'inactive',
        ]);

        return redirect()->route('admin.brands')
            ->with('success', 'Brand berhasil ditambahkan aseli cuy');

    } catch (QueryException $e) {
        if ($e->getCode() == '45000') {
            $message = $e->errorInfo[2] ?? 'Validasi brand gagal bre';

            return back()->withInput()->with('trigger_error', $message);
        }

        throw $e;
    }
}
    public function brandEdit($brandId)
    {
        $brand = Brand::findOrFail($brandId);

        return view('admin.brand-edit', compact('brand'));
    }

    public function updateBrand(Request $request, $id)
    {
        $brand = Brand::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:png,jpg,jpeg,webp|max:2048',
        ]);

        try {
            $brand->name = $validated['name'];
            $brand->slug = Str::slug($validated['name']);

            if ($request->hasFile('image')) {
                $brand->image = $request->file('image')->store('brands', 'public');
            }

            if ($request->has('is_active')) {
    $brand->status = $request->boolean('is_active') ? 'active' : 'inactive';
}

            $brand->save();

            return redirect()->route('admin.brands')
                ->with('success', 'Brand berhasil diperbarui oi');

        } catch (QueryException $e) {
            if ($e->getCode() == '45000') {
                $message = $e->errorInfo[2] ?? 'Validasi brand gagal';

                return back()->withInput()->with('trigger_error', $message);
            }

            throw $e;
        }
    }

    public function deleteBrand($id)
    {
        $brand = Brand::findOrFail($id);

        $imagePath = $brand->image;

        $brand->delete();

        if ($imagePath) {
            Storage::disk('public')->delete($imagePath);
        }

        return redirect()->route('admin.brands')
            ->with('success', 'Brand berhasil dihapus');
    }
}
