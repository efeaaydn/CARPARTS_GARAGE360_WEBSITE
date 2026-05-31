<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AdminProductController extends Controller
{
    const VEHICLE_MAKES = [
        'BMW','Mercedes-Benz','Audi','Volkswagen','Toyota','Honda','Ford',
        'Fiat','Renault','Opel','Peugeot','Citroën','Hyundai','Kia','Nissan',
        'Volvo','Skoda','Seat','Dacia','Mitsubishi','Suzuki','Mazda','Subaru',
        'Jeep','Land Rover','Porsche','Alfa Romeo','Chevrolet','Dodge','Tesla',
    ];

    const PART_BRANDS = [
        'Bosch','Valeo','Denso','NGK','Mann-Filter','Mahle','Brembo','Monroe',
        'Sachs','SKF','FAG','Gates','Continental','Dayco','Delphi','Hella',
        'Philips','Febi','Lemförder','ZF','TRW','ATE','Pagid','Ferodo',
        'Textar','Pirelli','Michelin','Bridgestone','Goodyear','Özel Marka',
    ];
    public function index()
    {
        $products = Product::with('category')->latest()->paginate(20);
        return view('admin.products.index', compact('products'));
    }

    public function create()
    {
        $rootCategories = Category::whereNull('parent_id')->where('is_active', true)->orderBy('sort_order')->get();
        return view('admin.products.create', compact('rootCategories'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'category_id'       => 'required|exists:categories,id',
            'name'              => 'required|string|max:255',
            'sku'               => 'required|string|unique:products',
            'description'       => 'nullable|string',
            'short_description' => 'nullable|string|max:500',
            'price'             => 'required|numeric|min:0',
            'sale_price'        => 'nullable|numeric|min:0',
            'currency'          => 'required|in:TRY,EUR',
            'stock'             => 'required|integer|min:0',
            'brand'             => 'nullable|string|max:100',
            'oem_number'        => 'nullable|string|max:100',
            'vehicle_make'      => 'nullable|string|max:100',
            'vehicle_model'     => 'nullable|string|max:100',
            'part_brand'        => 'nullable|string|max:100',
            'condition'         => 'nullable|in:Sıfır,İkinci El',
            'image'             => 'nullable|image|max:2048',
        ]);

        $data['slug']        = Str::slug($data['name']) . '-' . Str::random(5);
        $data['is_active']   = $request->boolean('is_active');
        $data['is_featured'] = $request->boolean('is_featured');
        $data['condition']   = $data['condition'] ?? 'Sıfır';

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('products', 'public');
        }

        if ($request->hasFile('gallery')) {
            $gallery = [];
            foreach ($request->file('gallery') as $file) {
                $gallery[] = $file->store('products/gallery', 'public');
            }
            $data['gallery'] = $gallery;
        }

        Product::create($data);
        return redirect()->route('admin.products.index')->with('success', 'Ürün eklendi.');
    }

    public function show(Product $urunler)
    {
        return redirect()->route('admin.products.edit', $urunler);
    }

    public function edit(Product $urunler)
    {
        $rootCategories = Category::whereNull('parent_id')->where('is_active', true)->orderBy('sort_order')->get();

        // Ürünün seçili kategorisinin ebeveynini bul (alt kategoriyse)
        $selectedCategory = $urunler->category;
        $selectedParentId = null;
        $selectedSubId    = null;

        if ($selectedCategory) {
            if ($selectedCategory->parent_id) {
                $selectedParentId = $selectedCategory->parent_id;
                $selectedSubId    = $selectedCategory->id;
            } else {
                $selectedParentId = $selectedCategory->id;
            }
        }

        // Seçili üst kategorinin alt kategorilerini yükle
        $subCategories = $selectedParentId
            ? Category::where('parent_id', $selectedParentId)->where('is_active', true)->orderBy('sort_order')->get()
            : collect();

        return view('admin.products.edit', [
            'product'         => $urunler,
            'rootCategories'  => $rootCategories,
            'subCategories'   => $subCategories,
            'selectedParentId'=> $selectedParentId,
            'selectedSubId'   => $selectedSubId,
        ]);
    }

    public function update(Request $request, Product $urunler)
    {
        $data = $request->validate([
            'category_id'       => 'required|exists:categories,id',
            'name'              => 'required|string|max:255',
            'sku'               => 'required|string|unique:products,sku,' . $urunler->id,
            'description'       => 'nullable|string',
            'short_description' => 'nullable|string|max:500',
            'price'             => 'required|numeric|min:0',
            'sale_price'        => 'nullable|numeric|min:0',
            'currency'          => 'required|in:TRY,EUR',
            'stock'             => 'required|integer|min:0',
            'brand'             => 'nullable|string|max:100',
            'oem_number'        => 'nullable|string|max:100',
            'vehicle_make'      => 'nullable|string|max:100',
            'vehicle_model'     => 'nullable|string|max:100',
            'part_brand'        => 'nullable|string|max:100',
            'condition'         => 'nullable|in:Sıfır,İkinci El',
            'image'             => 'nullable|image|max:2048',
            'gallery.*'         => 'nullable|image|max:2048',
        ]);

        $data['is_active']   = $request->boolean('is_active');
        $data['is_featured'] = $request->boolean('is_featured');
        $data['condition']   = $data['condition'] ?? 'Sıfır';

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('products', 'public');
        }

        if ($request->hasFile('gallery')) {
            $existing = $urunler->gallery ?? [];
            foreach ($request->file('gallery') as $file) {
                $existing[] = $file->store('products/gallery', 'public');
            }
            $data['gallery'] = array_slice($existing, 0, 6);
        }

        $urunler->update($data);
        return redirect()->route('admin.products.edit', $urunler)->with('success', 'Ürün güncellendi.');
    }

    public function deleteGalleryImage(Product $urunler, int $index)
    {
        $gallery = $urunler->gallery ?? [];

        if (isset($gallery[$index])) {
            \Illuminate\Support\Facades\Storage::disk('public')->delete($gallery[$index]);
            array_splice($gallery, $index, 1);
            $urunler->update(['gallery' => array_values($gallery)]);
        }

        return back()->with('success', 'Galeri fotoğrafı silindi.');
    }

    public function destroy(Product $urunler)
    {
        $urunler->delete();
        return redirect()->route('admin.products.index')->with('success', 'Ürün silindi.');
    }
}
