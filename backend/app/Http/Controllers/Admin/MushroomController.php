<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\AddMushroomRequest;
use App\Http\Requests\UpdateMushroomRequest;
use App\Models\Mushroom;
use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\Writer\PngWriter;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class MushroomController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $mushrooms = Mushroom::with(['positives', 'negatives'])->latest()->get();
        return view('admin.mushrooms.index', compact('mushrooms'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('admin.mushrooms.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AddMushroomRequest $request)
    {
        if ($request->validated()) {
            $data = $request->validated();
            $data['image_path'] = $this->saveImage($request->file('image_path'));

            $mushroom = Mushroom::create($data);

            // Save QR Code and update the model with its path
            $mushroom->qr_code_path = $this->saveMushroomQRCode($mushroom->id);
            $mushroom->save();

            // Merge mushroom image with QR code using absolute paths
            $this->mergeMushroomImageWithQRCode($mushroom);

            return redirect()->route('admin.mushrooms.index')->with([
                'success' => 'Mushroom added successfully'
            ]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Mushroom $mushroom)
    {
        //
        abort(404);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Mushroom $mushroom)
    {
        //
        return view('admin.mushrooms.edit')->with([
            'mushroom' => $mushroom
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateMushroomRequest $request, Mushroom $mushroom)
    {
        if ($request->validated()) {
            $data = $request->validated();
            if ($request->hasFile('image_path')) {
                $this->removeMushroomFromStorage($mushroom->image_path);

                $data['image_path'] = $this->saveImage($request->file('image_path'));
                // update QR code merge after changing the image
                $this->mergeMushroomImageWithQRCode($mushroom);
            }
            $mushroom->update($data);
            return redirect()->route('admin.mushrooms.index')->with([
                'success' => 'Mushroom Updated successfully'
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Mushroom $mushroom)
    {
        //
        $this->removeMushroomFromStorage($mushroom->image_path);
        $this->removeMushroomFromStorage($mushroom->qr_code_path);
        $mushroom->delete();
        return redirect()->route('admin.mushrooms.index')->with([
            'success' => 'Mushroom deleted successfully'
        ]);
    }

    /**
     * upload and save mushroom image
     */
    public function saveImage($file)
    {
        $image_name = time() . '_' . $file->getClientOriginalName();
        $file->storeAs('images/mushrooms', $image_name, 'public');
        return 'storage/images/mushrooms/' . $image_name;
    }

    /**
     * save the mushroom qrcode and return its path
     */
    public function saveMushroomQRCode($mushroom_id)
    {
        $builder = new Builder(
            writer: new PngWriter(),
            data: $mushroom_id,
            size: 60,
        );
        $qrCode = $builder->build();
        $qrCodePath = 'qr_codes/' . $mushroom_id . '.png';

        Storage::disk('public')->put($qrCodePath, $qrCode->getString());

        // Return full accessible path for QR code image file
        return 'storage/' . $qrCodePath;
    }

    /**
     * Merge mushroom image with QR code image using absolute paths
     */
    public function mergeMushroomImageWithQRCode($mushroom)
    {
        $mushroomImagePath = public_path($mushroom->image_path);
        $qrCodePath = public_path($mushroom->qr_code_path);

        if (!file_exists($mushroomImagePath)) {
            // Handle error if mushroom image doesn't exist
            throw new \Exception("Mushroom image file not found at: " . $mushroomImagePath);
        }
        if (!file_exists($qrCodePath)) {
            // Handle error if QR code image doesn't exist
            throw new \Exception("QR code image file not found at: " . $qrCodePath);
        }

        if (mime_content_type($mushroomImagePath) == 'image/png') {
            $createMushroomImage = imagecreatefrompng($mushroomImagePath);
        } elseif (mime_content_type($mushroomImagePath) == 'image/jpeg') {
            $createMushroomImage = imagecreatefromjpeg($mushroomImagePath);
        } else {
            throw new \Exception("Unsupported mushroom image MIME type.");
        }

        $qrImage = imagecreatefrompng($qrCodePath);

        $mushroomWidth = imagesx($createMushroomImage);
        $mushroomHeight = imagesy($createMushroomImage);

        $qrWidth = imagesx($qrImage);
        $qrHeight = imagesy($qrImage);

        $dstX = ($mushroomWidth - $qrWidth) / 2;
        $dstY = ($mushroomHeight - $qrHeight) / 2;

        imagecopy($createMushroomImage, $qrImage, $dstX, $dstY, 0, 0, $qrWidth, $qrHeight);

        imagesavealpha($createMushroomImage, true);

        imagepng($createMushroomImage, $mushroomImagePath);

        imagedestroy($createMushroomImage);
        imagedestroy($qrImage);
    }

    /**
     * Remove file from storage
     */
    public function removeMushroomFromStorage($file)
    {
        $path = public_path($file);
        if (File::exists($path)) {
            File::delete($path);
        }
    }
}

