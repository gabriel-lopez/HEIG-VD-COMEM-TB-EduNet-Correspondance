<?php

namespace App\Http\Controllers;

use App\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class FileManagerController extends Controller
{
    const VALID_TYPES = array('image/jpeg', 'image/png', 'image/gif');
    const VALID_EXTENSIONS = array('jpg', 'png', 'gif', 'jpeg');

    function index()
    {
        $data = [
            'images' => Image::paginate(15)
        ];

        return view('images.index', $data);
    }

    function uploadImage(Request $request)
    {
        $image = $request->file('file');
        $extension = $request->file('file')->getClientOriginalExtension();

        $error = null;

        if ($_FILES['file']['error'] === UPLOAD_ERR_OK)
        {
            if(!in_array(strtolower($extension), self::VALID_EXTENSIONS))
            {
                $error[]  = "Uploaded file is not a valid image";
            }
            // PHP >= 5.3.0, PECL fileinfo >= 0.1.0
            else if(function_exists('finfo_open'))
            {
                $fileInfo = finfo_open(FILEINFO_MIME_TYPE);

                if (!in_array(finfo_file($fileInfo, $_FILES['file']['tmp_name']), self::VALID_TYPES))
                {
                    $error[]  = "Uploaded file is not a valid image";
                }
            }
            // supported by (PHP 4 >= 4.3.0, PHP 5, PHP 7)
            else if(function_exists('mime_content_type'))
            {
                if (!in_array(mime_content_type($_FILES['file']['tmp_name']), self::VALID_TYPES))
                {
                    $error[]  = "Uploaded file is not a valid image";
                }
            }
            else
            {
                // @ - for hide warning when image not valid
                if (!@getimagesize($_FILES['file']['tmp_name']))
                {
                    $error[]  = "Uploaded file is not a valid image";
                }
            }

            if($error != null)
            {
                abort('403');
            }

            $filename = 'image_' . time() . '_' . $image->hashName();

            Storage::disk('edunet')->put($filename,  File::get($image));

            $data = [
                'filename' => $filename,
                'mime' => $image->getClientMimeType(),
                'original_filename' => $image->getClientOriginalName(),
            ];

            $entry = Image::createOne($data);

            return response()->json(['location' => Storage::disk('edunet')->url($filename)]);
        }

        return response()->json(['res' => 'error']);
    }

    function downloadImage($name)
    {
        $image = Image::where('filename', '=', $name)->firstOrFail();

        $fileStream = Storage::disk('edunet')->getDriver();

        $stream = $fileStream->readStream($image->filename);

        return response()->stream(function () use ($stream) {

            fpassthru($stream);

        }, 200, ['content-type' => $image->mime]);
    }

    public function destroy($id)
    {
        $image = Image::findOrFail($id);

        $image->delete();

        return redirect()->back()->with('success', 'Item successfully deleted!'); //TODO
    }
}
