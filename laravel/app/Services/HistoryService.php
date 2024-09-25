<?php

namespace App\Services;

use App\Models\History;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;
use Ramsey\Uuid\Uuid;

class HistoryService
{
    public function logAction(string $modelId, string $modelName, array $before, array $after, string $action): void
    {

        History::create([
            'id' => Uuid::uuid6(),
            'model_id' => $modelId,
            'model_name' => $modelName,
            'before' => $before,
            'after' => $after,
            'action' => $action,
        ]);

        Cache::forget("history:{$modelName}:{$modelId}");
    }

    public function getHistory(string $modelName, string $modelId)
    {
        return Cache::remember("history:{$modelName}:{$modelId}", 3600, function () use ($modelName, $modelId) {
            return History::where('model_name', $modelName)
                ->where('model_id', $modelId)
                ->orderBy('created_at', 'desc')
                ->get();
        });
    }
}
