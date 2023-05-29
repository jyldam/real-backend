<?php

namespace App\Data\V1;

use App\Models\CallBack;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Attributes\Validation\In;

class CallBackUpdateData extends Data
{
    public function __construct(
        #[In(
            CallBack::STATUS_CREATED,
            CallBack::STATUS_RESOLVED,
            CallBack::STATUS_ARCHIVED,
        )]
        public int $status,
    ) {}
}
