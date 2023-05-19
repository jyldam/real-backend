<?php

use App\Models\HousingReportType;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $types = [
            ['name' => 'Фотография не соответствует объекту недвижимости'],
            ['name' => 'Фотография плохо обработана'],
            ['name' => 'Планировка не соответствует объекту недвижимости'],
            ['name' => 'В описании присутствуют грамматические/пунктуационные/иные ошибки'],
            ['name' => 'Описание не соответствует объекту недвижимости'],
            ['name' => 'Риэлтор этого объекта не отвечает'],
            ['name' => 'Объект уже продан/сдан'],
            ['name' => 'Метка на карте не соответствует реальному расположению'],
            ['name' => 'Дубль другого объявления'],
            ['name' => 'Я собственник этого объекта, уберите его'],
            ['name' => 'Другая причина'],
            ['name' => 'Неправильный тип недвижимости или комнатности'],
            ['name' => 'Я собственник, прошу изменить информацию об объекте'],
        ];
        HousingReportType::query()->insert($types);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        HousingReportType::query()->truncate();
    }
};
