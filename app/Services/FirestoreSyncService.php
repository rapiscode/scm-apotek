<?php

namespace App\Services;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;
use Kreait\Firebase\Factory;
use Throwable;

class FirestoreSyncService
{
    protected $database = null;

    public function enabled(): bool
    {
        return (bool) config('firebase.sync_enabled', true)
            && filled(config('firebase.credentials'))
            && file_exists(config('firebase.credentials'));
    }

    public function syncModel(Model $model): void
    {
        if (! $this->enabled()) {
            return;
        }

        try {
            $collection = $this->collectionName($model);
            $documentId = (string) $model->getKey();

            $data = $model->attributesToArray();
            $data['id'] = $model->getKey();
            $data['laravel_table'] = $model->getTable();
            $data['synced_at'] = now()->toIso8601String();

            $this->firestore()
                ->collection($collection)
                ->document($documentId)
                ->set($data, ['merge' => true]);
        } catch (Throwable $e) {
            Log::warning('Gagal sync data ke Firestore', [
                'model' => get_class($model),
                'id' => $model->getKey(),
                'message' => $e->getMessage(),
            ]);
        }
    }

    public function deleteModel(Model $model): void
    {
        if (! $this->enabled()) {
            return;
        }

        try {
            $this->firestore()
                ->collection($this->collectionName($model))
                ->document((string) $model->getKey())
                ->delete();
        } catch (Throwable $e) {
            Log::warning('Gagal hapus data di Firestore', [
                'model' => get_class($model),
                'id' => $model->getKey(),
                'message' => $e->getMessage(),
            ]);
        }
    }

    protected function firestore()
    {
        if ($this->database) {
            return $this->database;
        }

        $factory = (new Factory)->withServiceAccount(config('firebase.credentials'));

        if (filled(config('firebase.project_id'))) {
            $factory = $factory->withProjectId(config('firebase.project_id'));
        }

        return $this->database = $factory->createFirestore()->database();
    }

    protected function collectionName(Model $model): string
    {
        return $model->getTable();
    }
}
