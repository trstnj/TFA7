<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();

        return view('users', compact('users'));
    }

    public function create()
    {
        return view('users.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'username' => [
                'required',
                'string',
                'max:50',
                Rule::unique('users', 'username'),
            ],
            'full_name' => 'required|string|max:100',
        ]);

        User::create($validated);

        return redirect()
            ->route('users.index')
            ->with('success', 'User added successfully.');
    }

    public function edit(User $user)
    {
        return view('users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'username' => [
                'required',
                'string',
                'max:50',
                Rule::unique('users', 'username')
                    ->ignore($user->id),
            ],
            'full_name' => 'required|string|max:100',
            'avatar' => [
                'nullable',
                'image',
                'mimes:jpeg,png,webp',
                'max:2048',
            ],
        ]);

        unset($validated['avatar']);

        if ($request->hasFile('avatar')) {
            $newPath = $this->prepareAvatar(
                $request->file('avatar')
            );

            $oldPath = $user->avatar;
            $validated['avatar'] = $newPath;
        }

        try {
            $user->update($validated);
        } catch (\Throwable $e) {
            if (isset($newPath)) {
                Storage::disk('public')->delete($newPath);
            }

            throw $e;
        }

        if (isset($newPath) && !empty($oldPath)) {
            Storage::disk('public')->delete($oldPath);
        }

        return redirect()
            ->route('users.index')
            ->with('success', 'User updated successfully.');
    }

    private function prepareAvatar($file): string
    {
        $path = $file->getRealPath();

        $imageInfo = @getimagesize($path);

        if ($imageInfo === false) {
            throw ValidationException::withMessages([
                'avatar' => 'The uploaded file is not a valid image.',
            ]);
        }

        [$width, $height, $type] = $imageInfo;

        $source = match ($type) {
            IMAGETYPE_JPEG => @imagecreatefromjpeg($path),
            IMAGETYPE_PNG => @imagecreatefrompng($path),
            IMAGETYPE_WEBP => @imagecreatefromwebp($path),
            default => false,
        };

        if ($source === false) {
            throw ValidationException::withMessages([
                'avatar' => 'The image could not be processed.',
            ]);
        }

        $size = 200;
        $destination = imagecreatetruecolor($size, $size);

        if ($destination === false) {
            imagedestroy($source);
            throw ValidationException::withMessages([
                'avatar' => 'The image could not be prepared.',
            ]);
        }

        $cropSize = min($width, $height);
        $sourceX = (int) (($width - $cropSize) / 2);
        $sourceY = (int) (($height - $cropSize) / 2);

        imagecopyresampled(
            $destination,
            $source,
            0,
            0,
            $sourceX,
            $sourceY,
            $size,
            $size,
            $cropSize,
            $cropSize
        );

        $relativePath = 'avatars/' . Str::uuid() . '.jpg';

        imageinterlace($destination, true);

        ob_start();
        $success = imagejpeg($destination, null, 85);
        $imageData = ob_get_clean();

        imagedestroy($source);
        imagedestroy($destination);

        if (!$success || !$imageData) {
            throw ValidationException::withMessages([
                'avatar' => 'The image could not be saved.',
            ]);
        }

        if (!Storage::disk('public')->put(
            $relativePath,
            $imageData
        )) {
            throw ValidationException::withMessages([
                'avatar' => 'The avatar could not be stored.',
            ]);
        }

        return $relativePath;
    }
}
