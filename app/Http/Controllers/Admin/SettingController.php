<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Setting;
use Illuminate\Support\Facades\Storage;

class SettingController extends Controller
{
    public function index()
    {
       
        $settings = Setting::pluck('value', 'key')->toArray();
        return view('admin.settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        $data = $request->except(['_token', '_method', 'logo_image_file', 'hero_image_file']);

        
        if ($request->hasFile('logo_image_file')) {
            $file = $request->file('logo_image_file');
            
           
            $request->validate([
                'logo_image_file' => 'image|mimes:jpeg,png,jpg,svg|max:2048'
            ]);

           
            $path = $file->store('settings', 'public');
            $data['logo_image'] = $path;
        }

      
        if ($request->hasFile('hero_image_file')) {
            $file = $request->file('hero_image_file');
            
           
            $request->validate([
                'hero_image_file' => 'image|mimes:jpeg,png,jpg,svg|max:4096'
            ]);

           
            $path = $file->store('settings', 'public');
            $data['hero_image'] = $path;
        }

      
        foreach ($data as $key => $value) {
            Setting::updateOrCreate(
                ['key' => $key],
                ['value' => $value]
            );
        }

        return redirect()->route('settings.index')->with('success', 'Pengaturan berhasil disimpan!');
    }
}
