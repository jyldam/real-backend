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
            [
                'name'       => 'Фотография не соответствует объекту недвижимости',
                'rules'      => json_encode(['message' => 'required|min:20|max:1000']),
                'attributes' => json_encode(['message' => 'сообщение']),
            ],
            [
                'name'       => 'Фотография плохо обработана',
                'rules'      => json_encode(['message' => 'required|min:20|max:1000']),
                'attributes' => json_encode(['message' => 'сообщение']),
            ],
            [
                'name'       => 'Планировка не соответствует объекту недвижимости',
                'rules'      => json_encode(['message' => 'required|min:20|max:1000']),
                'attributes' => json_encode(['message' => 'сообщение']),
            ],
            [
                'name'       => 'В описании присутствуют грамматические/пунктуационные/иные ошибки',
                'rules'      => json_encode(['message' => 'required|min:20|max:1000']),
                'attributes' => json_encode(['message' => 'сообщение']),
            ],
            [
                'name'       => 'Описание не соответствует объекту недвижимости',
                'rules'      => json_encode(['message' => 'required|min:20|max:1000']),
                'attributes' => json_encode(['message' => 'сообщение']),
            ],
            [
                'name'       => 'Риелтор этого объекта не отвечает',
                'rules'      => json_encode([
                    'message' => 'required|min:20|max:1000',
                    'phone'   => 'required|min:10|max:10',
                ]),
                'attributes' => json_encode([
                    'message' => 'сообщение',
                    'phone'   => 'телефон',
                ]),
            ],
            [
                'name'       => 'Объект уже продан/сдан',
                'rules'      => json_encode(['message' => 'required|min:20|max:1000']),
                'attributes' => json_encode(['message' => 'сообщение']),
            ],
            [
                'name'       => 'Метка на карте не соответствует реальному расположению',
                'rules'      => json_encode(['message' => 'required|min:20|max:1000']),
                'attributes' => json_encode(['message' => 'сообщение']),
            ],
            [
                'name'       => 'Дубль другого объявления',
                'rules'      => json_encode(['url' => 'required|url']),
                'attributes' => json_encode(['url' => 'ссылка']),
            ],
            [
                'name'       => 'Я собственник этого объекта, уберите его',
                'rules'      => json_encode(['phone' => 'required|min:10|max:10']),
                'attributes' => json_encode(['phone' => 'телефон']),
            ],
            [
                'name'       => 'Другая причина',
                'rules'      => json_encode(['message' => 'required|min:20|max:1000']),
                'attributes' => json_encode(['message' => 'сообщение']),
            ],
            [
                'name'       => 'Неправильный тип недвижимости или комнатности',
                'rules'      => json_encode(['message' => 'required|min:20|max:1000']),
                'attributes' => json_encode(['message' => 'сообщение']),
            ],
            [
                'name'       => 'Я собственник, прошу изменить информацию об объекте',
                'rules'      => json_encode([
                    'phone'   => 'required|min:10|max:10',
                    'message' => 'required|min:20|max:1000',
                ]),
                'attributes' => json_encode([
                    'phone'   => 'телефон',
                    'message' => 'сообщение',
                ]),
            ],
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
