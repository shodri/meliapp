<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Banner;
use App\Http\Requests\BannerRequest;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\File;

class BannerController extends Controller
{
    public function index()
    {
        return view('banners.index')->with([
            'banners' => Banner::without('images')->get(),
        ]);
    }

    public function create()
    {
        return view('banners.create');
    }

    public function store(BannerRequest $request)
    {

        $banner = Banner::create( $request->validated());
        
        // Verificar si se subió una imagen de escritorio
        if ($request->hasFile('image_lg')) {
            $imageLg = $request->file('image_lg');
            $imageLgPath = 'images/' . $imageLg->store('banners', 'images');
            $banner->images()->create([
                'path' => $imageLgPath,
                'screen' => 'lg',
            ]);
        }
        
        // Verificar si se subió una imagen de móvil
        if ($request->hasFile('image_sm')) {
            $imageSm = $request->file('image_sm');
            $imageSmPath = 'images/' . $imageSm->store('banners', 'images');
            $banner->images()->create([
                'path' => $imageSmPath,
                'screen' => 'sm',
            ]);
        }


        return redirect()
                ->route('banners.index')
                ->withSuccess("El banner id {$banner->id} fue creado exitosamente");

    }

    public function edit(Banner $banner)
    {
        return view('banners.edit')->with([
            'banner' => $banner,
        ]);
    }

    public function update(BannerRequest $request, Banner $banner)
    {
        if ($request->hasFile('image_lg')) {
            //Borrar imagen anterior
            $imageLg = $banner->images->where('screen', 'lg')->first();
            if ($imageLg) {
                $path = storage_path("app/public/images/banners/{$imageLg->path}");
                if (File::exists($path)) {
                    File::delete($path);
                }
                $imageLg->delete();
            }
            //Subir imagen nueva
            $imageLg = $request->file('image_lg');
            $imageLgPath = 'images/' . $imageLg->store('banners', 'images');
            $banner->images()->create([
                'path' => $imageLgPath,
                'screen' => 'lg',
            ]);

        }
        
        // Verificar si se subió una imagen de móvil
        if ($request->hasFile('image_sm')) {
            //Borrar imagen anterior
            $imageSm = $banner->images->where('screen', 'sm')->first();
            if ($imageSm) {
                $path = storage_path("app/public/images/banners/{$imageSm->path}");
                if (File::exists($path)) {
                    File::delete($path);
                }
                $imageSm->delete();
            }
            $imageSm = $request->file('image_sm');
            $imageSmPath = 'images/' . $imageSm->store('banners', 'images');
            $banner->images()->create([
                'path' => $imageSmPath,
                'screen' => 'sm',
            ]);
        }
        return view('banners.edit');
    }
    public function destroy(Banner $banner){

        foreach ($banner->images as $image){
            $path = storage_path("app/public/images/banners/{$image->path}");

            File::delete($path);

            $image->delete();
        }

        $banner->delete();

        return redirect()
                ->route('banners.index')
                ->withSuccess("El banner {$banner->title} fue eliminado correctamente");;


    }
}
