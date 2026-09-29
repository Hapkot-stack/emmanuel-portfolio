<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class Profile extends Model
{
    protected $fillable = [
        'name',
        'title',
        'subtitle',
        'bio',
        'bio_short',
        'email',
        'phone',
        'location',
        'avatar',
        'github_url',
        'linkedin_url',
        'whatsapp',
        'website_url',
        'years_experience',
        'open_to',
        'resume_headline',
        'tech_stack',
        'titles',
    ];

    protected $casts = [
        'tech_stack' => 'array',
        'titles'     => 'array',
    ];

    protected static function booted(): void
    {
        static::saved(function (Profile $profile): void {
            if (
                $profile->avatar &&
                Str::startsWith($profile->avatar, 'avatars/') &&
                ($profile->wasRecentlyCreated || $profile->wasChanged('avatar') || $profile->avatarVariantsNeedRefresh())
            ) {
                $profile->generateAvatarVariants();
            }
        });
    }

    public function avatarVariantPath(string $size = 'large'): ?string
    {
        if (! $this->avatar) {
            return null;
        }

        $variant = $this->avatarPathForSize($size);

        return Storage::disk('public')->exists($variant) ? $variant : $this->avatar;
    }

    public function avatarUrl(string $size = 'large'): ?string
    {
        $path = $this->avatarVariantPath($size);

        if (! $path) {
            return null;
        }

        if (Str::startsWith($path, 'avatars/')) {
            $version = Storage::disk('public')->lastModified($path);

            return asset('storage/' . $path) . '?v=' . $version;
        }

        return asset($path);
    }

    public function avatarFilePath(string $size = 'large'): ?string
    {
        $path = $this->avatarVariantPath($size);

        if (! $path) {
            return null;
        }

        return Str::startsWith($path, 'avatars/')
            ? Storage::disk('public')->path($path)
            : public_path($path);
    }

    private function generateAvatarVariants(): void
    {
        $disk = Storage::disk('public');

        if (! Str::startsWith($this->avatar, 'avatars/') || ! $disk->exists($this->avatar)) {
            return;
        }

        $sourcePath = $disk->path($this->avatar);
        $imageInfo = @getimagesize($sourcePath);

        if (! $imageInfo || ! in_array($imageInfo['mime'], ['image/jpeg', 'image/png', 'image/webp'], true)) {
            return;
        }

        $source = @imagecreatefromstring(file_get_contents($sourcePath));

        if (! $source) {
            return;
        }

        $sourceWidth = imagesx($source);
        $sourceHeight = imagesy($source);
        $cropSize = min($sourceWidth, $sourceHeight);
        $cropX = (int) (($sourceWidth - $cropSize) / 2);
        $cropY = (int) (($sourceHeight - $cropSize) / 2);
        $extension = strtolower(pathinfo($this->avatar, PATHINFO_EXTENSION));

        foreach (['large' => 1600, 'medium' => 800, 'thumbnail' => 240] as $size => $targetSize) {
            $variantSize = min($targetSize, $cropSize);
            $variant = imagecreatetruecolor($variantSize, $variantSize);

            if ($extension !== 'jpg' && $extension !== 'jpeg') {
                imagealphablending($variant, false);
                imagesavealpha($variant, true);
                $transparent = imagecolorallocatealpha($variant, 0, 0, 0, 127);
                imagefill($variant, 0, 0, $transparent);
            }

            imagecopyresampled(
                $variant,
                $source,
                0,
                0,
                $cropX,
                $cropY,
                $variantSize,
                $variantSize,
                $cropSize,
                $cropSize,
            );

            $variantPath = $this->avatarPathForSize($size);

            match ($extension) {
                'jpg', 'jpeg' => imagejpeg($variant, $disk->path($variantPath), 95),
                'png' => imagepng($variant, $disk->path($variantPath), 6),
                'webp' => imagewebp($variant, $disk->path($variantPath), 95),
            };

            imagedestroy($variant);
        }

        imagedestroy($source);
    }

    private function avatarVariantsNeedRefresh(): bool
    {
        $disk = Storage::disk('public');

        if (! $disk->exists($this->avatar)) {
            return false;
        }

        $sourcePath = $disk->path($this->avatar);
        $sourceInfo = @getimagesize($sourcePath);

        if (! $sourceInfo || ! in_array($sourceInfo['mime'], ['image/jpeg', 'image/png', 'image/webp'], true)) {
            return false;
        }

        $cropSize = min($sourceInfo[0], $sourceInfo[1]);

        foreach (['large' => 1600, 'medium' => 800, 'thumbnail' => 240] as $size => $targetSize) {
            $variantPath = $this->avatarPathForSize($size);

            if (! $disk->exists($variantPath)) {
                return true;
            }

            if ($disk->lastModified($this->avatar) > $disk->lastModified($variantPath)) {
                return true;
            }

            $variantInfo = @getimagesize($disk->path($variantPath));
            $expectedSize = min($targetSize, $cropSize);

            if (! $variantInfo || $variantInfo[0] !== $expectedSize || $variantInfo[1] !== $expectedSize) {
                return true;
            }
        }

        return false;
    }

    private function avatarPathForSize(string $size): string
    {
        $extension = pathinfo($this->avatar, PATHINFO_EXTENSION);
        $filename = pathinfo($this->avatar, PATHINFO_FILENAME);
        $directory = pathinfo($this->avatar, PATHINFO_DIRNAME);

        return ($directory === '.' ? '' : $directory . '/') . $filename . '-' . $size . '.' . $extension;
    }

    public function getTechStackArrayAttribute(): array
    {
        return $this->tech_stack ?? [
            'Laravel',
            'PHP',
            'MySQL',
            'JavaScript',
            'Tailwind CSS',
            'API Development',
            'Git',
            'Figma',
            'Excel',
            'PowerPoint',
        ];
    }

    public function getTitlesArrayAttribute(): array
    {
        return $this->titles ?? [
            'Software Developer',
            'Information Systems Student',
            'Trading Systems Builder',
        ];
    }
}
