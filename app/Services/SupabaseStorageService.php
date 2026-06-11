<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;

class SupabaseStorageService
{
    private string $baseUrl;
    private string $serviceKey;
    private string $bucket;
    private string $projectId;

    public function __construct()
    {
        $this->projectId = config('supabase.project_id');
        $this->serviceKey = config('supabase.service_key');
        $this->bucket     = config('supabase.bucket', 'activehub');
        $this->baseUrl    = "https://{$this->projectId}.supabase.co/storage/v1";
    }

    /**
     * Upload a file to Supabase Storage.
     * Returns the public URL on success, or null on failure.
     */
    public function upload(UploadedFile $file, string $folder = 'uploads'): ?string
    {
        $filename = $folder . '/' . uniqid() . '_' . time() . '.' . $file->getClientOriginalExtension();
        $content  = file_get_contents($file->getRealPath());
        $mimeType = $file->getMimeType() ?? 'application/octet-stream';

        $url = "{$this->baseUrl}/object/{$this->bucket}/{$filename}";

        $ch = curl_init($url);
        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST           => true,
            CURLOPT_POSTFIELDS     => $content,
            CURLOPT_HTTPHEADER     => [
                "Authorization: Bearer {$this->serviceKey}",
                "Content-Type: {$mimeType}",
                "x-upsert: true",
            ],
        ]);

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($httpCode >= 200 && $httpCode < 300) {
            return $this->publicUrl($filename);
        }

        \Log::error('Supabase upload failed', [
            'status'   => $httpCode,
            'response' => $response,
            'filename' => $filename,
        ]);

        return null;
    }

    /**
     * Delete a file from Supabase Storage by its public URL or path.
     */
    public function delete(string $urlOrPath): bool
    {
        // Extract path relative to bucket from full URL
        $pattern = "/object\/public\/{$this->bucket}\//";
        if (preg_match($pattern, $urlOrPath)) {
            $path = preg_replace("/.*object\/public\/{$this->bucket}\//", '', $urlOrPath);
        } else {
            $path = ltrim($urlOrPath, '/');
        }

        $url = "{$this->baseUrl}/object/{$this->bucket}/{$path}";

        $ch = curl_init($url);
        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST  => 'DELETE',
            CURLOPT_HTTPHEADER     => [
                "Authorization: Bearer {$this->serviceKey}",
            ],
        ]);

        curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        return $httpCode >= 200 && $httpCode < 300;
    }

    /**
     * Get the public URL for a given file path in the bucket.
     */
    public function publicUrl(string $path): string
    {
        return "{$this->baseUrl}/object/public/{$this->bucket}/{$path}";
    }
}
