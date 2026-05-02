<?php

namespace App\Services;

use App\Support\FirestoreDocument;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Kreait\Firebase\Factory;
use RuntimeException;

class FirestoreService
{
    protected mixed $database = null;

    public function enabled(): bool
    {
        return filled(config('firebase.credentials')) && file_exists(config('firebase.credentials'));
    }

    public function db(): mixed
    {
        if ($this->database) {
            return $this->database;
        }

        if (! $this->enabled()) {
            throw new RuntimeException('Firebase credentials belum ditemukan. Cek FIREBASE_CREDENTIALS di .env.');
        }

        $factory = (new Factory)->withServiceAccount(config('firebase.credentials'));

        if (filled(config('firebase.project_id'))) {
            $factory = $factory->withProjectId(config('firebase.project_id'));
        }

        return $this->database = $factory->createFirestore()->database();
    }

    public function auth(): mixed
    {
        if (! $this->enabled()) {
            throw new RuntimeException('Firebase credentials belum ditemukan. Cek FIREBASE_CREDENTIALS di .env.');
        }

        $factory = (new Factory)->withServiceAccount(config('firebase.credentials'));

        if (filled(config('firebase.project_id'))) {
            $factory = $factory->withProjectId(config('firebase.project_id'));
        }

        return $factory->createAuth();
    }

    public function all(string $collection, string $orderBy = 'created_at', string $direction = 'desc'): Collection
    {
        $rows = collect();

        foreach ($this->db()->collection($collection)->documents() as $document) {
            if ($document->exists()) {
                $rows->push($this->makeDocument($document->id(), $document->data()));
            }
        }

        return $rows->sortBy(function ($item) use ($orderBy) {
            $value = $item->{$orderBy};
            return $value instanceof \DateTimeInterface ? $value->getTimestamp() : (string) $value;
        }, SORT_REGULAR, strtolower($direction) === 'desc')->values();
    }

    public function find(string $collection, string|int|null $id): ?FirestoreDocument
    {
        if (blank($id)) {
            return null;
        }

        $snapshot = $this->db()->collection($collection)->document((string) $id)->snapshot();

        return $snapshot->exists() ? $this->makeDocument($snapshot->id(), $snapshot->data()) : null;
    }

    public function findOrFail(string $collection, string|int|null $id): FirestoreDocument
    {
        return $this->find($collection, $id) ?? abort(404, "Data {$collection} tidak ditemukan.");
    }

    public function create(string $collection, array $data, ?string $id = null): FirestoreDocument
    {
        $now = now()->toIso8601String();
        $data = array_merge($data, [
            'created_at' => $data['created_at'] ?? $now,
            'updated_at' => $data['updated_at'] ?? $now,
        ]);

        if ($id !== null && $id !== '') {
            $ref = $this->db()->collection($collection)->document((string) $id);
            $data['id'] = (string) $id;
            $ref->set($data, ['merge' => true]);
            return new FirestoreDocument($data);
        }

        $ref = $this->db()->collection($collection)->newDocument();
        $data['id'] = $ref->id();
        $ref->set($data);

        return new FirestoreDocument($data);
    }

    public function update(string $collection, string|int $id, array $data): FirestoreDocument
    {
        $data['id'] = (string) $id;
        $data['updated_at'] = now()->toIso8601String();

        $this->db()->collection($collection)->document((string) $id)->set($data, ['merge' => true]);

        return $this->findOrFail($collection, $id);
    }

    public function delete(string $collection, string|int $id): void
    {
        $this->db()->collection($collection)->document((string) $id)->delete();
    }

    public function firstWhere(string $collection, string $field, mixed $value): ?FirestoreDocument
    {
        return $this->all($collection)->first(fn ($item) => (string) ($item->{$field} ?? '') === (string) $value);
    }

    public function unique(string $collection, string $field, mixed $value, string|int|null $ignoreId = null): bool
    {
        return ! $this->all($collection)->contains(function ($item) use ($field, $value, $ignoreId) {
            if ($ignoreId !== null && (string) $item->id === (string) $ignoreId) {
                return false;
            }

            return strtolower((string) ($item->{$field} ?? '')) === strtolower((string) $value);
        });
    }

    public function nextNumber(string $collection): int
    {
        return $this->all($collection)->count() + 1;
    }

    public function makeDocument(string $id, array $data): FirestoreDocument
    {
        $data['id'] = (string) ($data['id'] ?? $id);
        return new FirestoreDocument($data);
    }
}
