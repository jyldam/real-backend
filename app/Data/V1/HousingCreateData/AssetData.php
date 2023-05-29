<?php

namespace App\Data\V1\HousingCreateData;

use App\Models\HousingAsset;
use Illuminate\Http\UploadedFile;
use Spatie\LaravelData\Attributes\Validation\Image;
use Spatie\LaravelData\Attributes\Validation\In;
use Spatie\LaravelData\Data;

class AssetData extends Data
{
    public function __construct(
        #[In(
            HousingAsset::TYPE_REGULAR_IMAGE,
            HousingAsset::TYPE_LAYOUT_IMAGE
        )]
        public int          $type,

        #[Image]
        public UploadedFile $file,
    )
    {
    }

    public static function attributes(): array
    {
        return [
            'type' => 'тип вложения',
            'file' => 'файл вложения',
        ];
    }
}
