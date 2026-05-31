<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Slider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminSliderController extends Controller
{
    public function index()
    {
        $sliders = Slider::orderBy('sort_order')->get();
        return view('admin.sliders.index', compact('sliders'));
    }

    public function create()
    {
        return view('admin.sliders.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title'       => 'nullable|string|max:200',
            'subtitle'    => 'nullable|string|max:400',
            'button_text' => 'nullable|string|max:80',
            'button_url'  => 'nullable|string|max:400',
            'bg_color'    => 'nullable|string|max:20',
            'sort_order'  => 'nullable|integer|min:0',
            'is_active'   => 'nullable|boolean',
            'image'       => 'nullable|image|max:3072',
        ]);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('sliders', 'public');
        }

        $data['is_active'] = $request->boolean('is_active');
        $data['bg_color']  = $data['bg_color'] ?? '#1d1d1d';

        Slider::create($data);

        return redirect()->route('admin.sliders.index')->with('success', 'Slider eklendi.');
    }

    public function edit(Slider $slider)
    {
        return view('admin.sliders.edit', compact('slider'));
    }

    public function update(Request $request, Slider $slider)
    {
        $data = $request->validate([
            'title'       => 'nullable|string|max:200',
            'subtitle'    => 'nullable|string|max:400',
            'button_text' => 'nullable|string|max:80',
            'button_url'  => 'nullable|string|max:400',
            'bg_color'    => 'nullable|string|max:20',
            'sort_order'  => 'nullable|integer|min:0',
            'is_active'   => 'nullable|boolean',
            'image'       => 'nullable|image|max:3072',
        ]);

        if ($request->hasFile('image')) {
            if ($slider->image) {
                Storage::disk('public')->delete($slider->image);
            }
            $data['image'] = $request->file('image')->store('sliders', 'public');
        }

        $data['is_active'] = $request->boolean('is_active');
        $data['bg_color']  = $data['bg_color'] ?? $slider->bg_color;

        $slider->update($data);

        return redirect()->route('admin.sliders.index')->with('success', 'Slider güncellendi.');
    }

    public function destroy(Slider $slider)
    {
        if ($slider->image) {
            Storage::disk('public')->delete($slider->image);
        }
        $slider->delete();

        return redirect()->route('admin.sliders.index')->with('success', 'Slider silindi.');
    }
}
