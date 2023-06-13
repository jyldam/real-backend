<?php

namespace App\Data\V1\HousingCreateData;

use App\Models\HousingAsset;
use Spatie\LaravelData\Data;
use Illuminate\Http\UploadedFile;
use Spatie\LaravelData\Attributes\Validation\In;
use Spatie\LaravelData\Attributes\Validation\MimeTypes;

class AssetData extends Data
{
    public function __construct(
        #[In(
            HousingAsset::TYPE_REGULAR_IMAGE,
            HousingAsset::TYPE_LAYOUT_IMAGE,
            HousingAsset::TYPE_VIDEO,
        )]
        public int $type,

        #[MimeTypes('video/mp4', 'image/png', 'image/jpeg')]
        public UploadedFile $file,
    ) {}

    public static function attributes(): array
    {
        return [
            'type' => 'тип вложения',
            'file' => 'файл вложения',
        ];
    }
}
