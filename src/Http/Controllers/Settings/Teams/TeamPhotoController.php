<?php

namespace Laravel\Spark\Http\Controllers\Settings\Teams;

use Intervention\Image\ImageManager;
use Illuminate\Support\Facades\Storage;
use Laravel\Spark\Http\Controllers\Controller;
use Laravel\Spark\Http\Requests\Settings\Teams\UpdateTeamPhotoRequest;

class TeamPhotoController extends Controller
{
    /**
     * The image manager instance.
     *
     * @var ImageManager
     */
    protected $images;

    /**
     * Create a new controller instance.
     *
     * @param  ImageManager  $images
     * @return void
     */
    public function __construct(ImageManager $images)
    {
        $this->images = $images;

        $this->middleware('auth');
    }

    /**
     * Update the given team's photo.
     *
     * @param  UpdateTeamPhotoRequest  $request
     * @param  \Laravel\Spark\Team  $team
     * @return Response
     */
    public function update(UpdateTeamPhotoRequest $request, $team)
    {
        // We will store the profile photos on the "public" disk, which is a convention
        // for where to place assets we want to be publicly accessible. Then, we can
        // grab the URL for the image to store with this user in the database row.
        $file = $request->file('photo');

        $disk = Storage::disk('public');

        $path = $file->hashName('profiles');

        // We will use an image manipulation library to resize the given team photo and
        // get it ready for storage. We'll also get the "hash name" of this photo as
        // it serves as a unique identifier for the image and is safe for storage.
        $disk->put(
            $path, $this->toImage($file)
        );

        $team->forceFill([
            'photo_url' => $disk->url($path),
        ])->save();
    }

    /**
     * Format the given file into a resized image.
     *
     * @param  \Symfony\Component\HttpFoundation\File\UploadedFile  $file
     * @return string
     */
    protected function toImage($file)
    {
        return (string) $this->images->make($file->path())
                            ->fit(300)->encode();
    }
}
