<?php

namespace App\Services;

use Google\Auth\Credentials\ServiceAccountCredentials;
use Illuminate\Support\Facades\Http;
use Kreait\Firebase\Auth;
use Kreait\Firebase\Factory;
use Illuminate\Support\Collection;
use Throwable;

class FirestoreService
{
    protected Auth $auth;
    protected string $projectId;
    protected string $credentialsPath;
    protected string $baseUrl;

    public function __construct()
    {
        $this->credentialsPath = base_path(env('FIREBASE_CREDENTIALS'));

        if (! file_exists($this->credentialsPath)) {
            throw new \Exception('File firebase_credentials.json tidak ditemukan di: ' . $this->credentialsPath);
        }

        $credentials = json_decode(file_get_contents($this->credentialsPath), true);

        $this->projectId = env('FIREBASE_PROJECT_ID') ?: $credentials['project_id'];

        $factory = (new Factory)
            ->withServiceAccount($this->credentialsPath)
            ->withProjectId($this->projectId);

        $this->auth = $factory->createAuth();

        $this->baseUrl = "https://firestore.googleapis.com/v1/projects/{$this->projectId}/databases/(default)/documents";
    }

    public function auth(): Auth
    {
        return $this->auth;
    }

    protected function token(): string
    {
        $scopes = ['https://www.googleapis.com/auth/datastore'];

        $credentials = new ServiceAccountCredentials($scopes, $this->credentialsPath);

        $token = $credentials->fetchAuthToken();

        if (! isset($token['access_token'])) {
            throw new \Exception('Gagal mengambil access token Firebase.');
        }

        return $token['access_token'];
    }

    protected function headers(): array
    {
        return [
            'Authorization' => 'Bearer ' . $this->token(),
            'Content-Type' => 'application/json',
        ];
    }

    protected function encodeValue($value): array
    {
        if (is_null($value)) {
            return ['nullValue' => null];
        }

        if (is_bool($value)) {
            return ['booleanValue' => $value];
        }

        if (is_int($value)) {
            return ['integerValue' => $value];
        }

        if (is_float($value)) {
            return ['doubleValue' => $value];
        }

        if (is_array($value)) {
            return [
                'arrayValue' => [
                    'values' => array_map(fn ($item) => $this->encodeValue($item), $value),
                ],
            ];
        }

        return ['stringValue' => (string) $value];
    }

    protected function encodeFields(array $data): array
    {
        $fields = [];

        foreach ($data as $key => $value) {
            $fields[$key] = $this->encodeValue($value);
        }

        return $fields;
    }

    protected function decodeValue(array $value)
    {
        if (array_key_exists('stringValue', $value)) {
            return $value['stringValue'];
        }

        if (array_key_exists('integerValue', $value)) {
            return (int) $value['integerValue'];
        }

        if (array_key_exists('doubleValue', $value)) {
            return (float) $value['doubleValue'];
        }

        if (array_key_exists('booleanValue', $value)) {
            return (bool) $value['booleanValue'];
        }

        if (array_key_exists('nullValue', $value)) {
            return null;
        }

        if (array_key_exists('timestampValue', $value)) {
            return $value['timestampValue'];
        }

        if (array_key_exists('arrayValue', $value)) {
            $items = $value['arrayValue']['values'] ?? [];

            return array_map(fn ($item) => $this->decodeValue($item), $items);
        }

        if (array_key_exists('mapValue', $value)) {
            return $this->decodeFields($value['mapValue']['fields'] ?? []);
        }

        return null;
    }

    protected function decodeFields(array $fields): object
    {
        $data = [];

        foreach ($fields as $key => $value) {
            $data[$key] = $this->decodeValue($value);
        }

        return (object) $data;
    }

    public function create(string $collection, array $data, ?string $documentId = null): object
    {
        try {
            $payload = [
                'fields' => $this->encodeFields($data),
            ];

            if ($documentId) {
                $url = "{$this->baseUrl}/{$collection}/{$documentId}";

                $response = Http::withHeaders($this->headers())
                    ->patch($url, $payload);
            } else {
                $url = "{$this->baseUrl}/{$collection}";

                $response = Http::withHeaders($this->headers())
                    ->post($url, $payload);
            }

            if ($response->failed()) {
                throw new \Exception($response->body());
            }

            return (object) [
                'id' => $documentId,
                ...$data,
            ];
        } catch (Throwable $e) {
            throw new \Exception('Gagal membuat data Firestore: ' . $e->getMessage());
        }
    }

    public function find(string $collection, string $documentId): ?object
    {
        try {
            $url = "{$this->baseUrl}/{$collection}/{$documentId}";

            $response = Http::withHeaders($this->headers())
                ->get($url);

            if ($response->status() === 404) {
                return null;
            }

            if ($response->failed()) {
                throw new \Exception($response->body());
            }

            $json = $response->json();

            $data = $this->decodeFields($json['fields'] ?? []);

            $data->id = $documentId;

            return $data;
        } catch (Throwable $e) {
            throw new \Exception('Gagal mengambil data Firestore: ' . $e->getMessage());
        }
    }

    public function update(string $collection, string $documentId, array $data): bool
    {
        try {
            $url = "{$this->baseUrl}/{$collection}/{$documentId}";

            $query = [];

            foreach (array_keys($data) as $field) {
                $query[] = 'updateMask.fieldPaths=' . urlencode($field);
            }

            $url .= '?' . implode('&', $query);

            $payload = [
                'fields' => $this->encodeFields($data),
            ];

            $response = Http::withHeaders($this->headers())
                ->patch($url, $payload);

            if ($response->failed()) {
                throw new \Exception($response->body());
            }

            return true;
        } catch (Throwable $e) {
            throw new \Exception('Gagal update data Firestore: ' . $e->getMessage());
        }
    }

    public function delete(string $collection, string $documentId): bool
    {
        try {
            $url = "{$this->baseUrl}/{$collection}/{$documentId}";

            $response = Http::withHeaders($this->headers())
                ->delete($url);

            if ($response->failed()) {
                throw new \Exception($response->body());
            }

            return true;
        } catch (Throwable $e) {
            throw new \Exception('Gagal hapus data Firestore: ' . $e->getMessage());
        }
    }

    public function all(string $collection): Collection
    {
        try {
            $url = "{$this->baseUrl}/{$collection}";

            $response = Http::withHeaders($this->headers())
                ->get($url);

            if ($response->status() === 404) {
                return collect();
            }

            if ($response->failed()) {
                throw new \Exception($response->body());
            }

            $json = $response->json();

            $documents = $json['documents'] ?? [];

            $data = collect();

            foreach ($documents as $document) {
                $fields = $document['fields'] ?? [];

                $item = $this->decodeFields($fields);

                $nameParts = explode('/', $document['name']);
                $item->id = end($nameParts);

                $data->push($item);
            }

            return $data;
        } catch (Throwable $e) {
            throw new \Exception('Gagal mengambil semua data Firestore: ' . $e->getMessage());
        }
    }
}