<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

class AirTableService
{
    protected $token;
    protected $baseId;
    protected $tableName;
    protected $cacheTTL; // in seconds

    /**
     * Constructor allows injecting configuration; defaults can be from config/services.php
     *
     * @param string|null $token
     * @param string|null $baseId
     * @param string|null $tableName
     * @param int $cacheTTL  Time-to-live for caching in seconds. Default: 600 (10 minutes)
     */
    public function __construct(
        ?string $token = null,
        ?string $baseId = null,
        ?string $tableName = null,
        int $cacheTTL = 600
    ) {
        $this->token = $token ?? config('services.airtable.token');
        $this->baseId = $baseId ?? config('services.airtable.base_id');
        $this->tableName = $tableName ?? config('services.airtable.table_name');
        $this->cacheTTL = $cacheTTL;
    }

    /**
     * List records from a specific Airtable table, caching them for the specified TTL.
     *
     * Docs: https://airtable.com/developers/web/api/list-records
     *
     * @param  array  $params Optional query parameters (e.g. ['filterByFormula' => '...', 'maxRecords' => 50])
     * @return array
     */
    public function getRecords(array $params = []): array
    {
        $cacheKey = $this->buildCacheKeyForRecords($params);

        return Cache::remember($cacheKey, $this->cacheTTL, function () use ($params) {
            $url = $this->buildRecordsUrl();

            $response = Http::withToken($this->token)
                ->acceptJson()
                ->get($url, $params);

            if ($response->successful()) {
                return $response->json()['records'] ?? [];
            }

            return [];
        });
    }

    /**
     * Get one specific record details from a particular base and table.
     *
     * Docs: https://airtable.com/developers/web/api/get-record
     *
     * @param string $recordId The record ID to fetch
     * @return array
     */
    public function getRecord(string $recordId): array
    {
        $cacheKey = $this->buildCacheKeyForRecord($recordId);

        return Cache::remember($cacheKey, $this->cacheTTL, function () use ($recordId) {
            $url = $this->buildRecordUrl($recordId);

            $response = Http::withToken($this->token)
                ->acceptJson()
                ->get($url);

            if ($response->successful()) {
                return $response->json() ?? [];
            }

            return [];
        });
    }

    /**
     * Get a list of bases accessible with the given token from the Airtable Metadata API.
     * Caches the result for the specified TTL.
     *
     * Docs: https://airtable.com/developers/web/api/list-bases
     *
     * @return array
     */
    public function getBases(): array
    {
        $cacheKey = $this->buildCacheKeyForBases();

        return Cache::remember($cacheKey, $this->cacheTTL, function () {
            $url = "https://api.airtable.com/v0/meta/bases";

            $response = Http::withToken($this->token)
                ->acceptJson()
                ->get($url);

            if ($response->successful()) {
                return $response->json()['bases'] ?? [];
            }

            return [];
        });
    }

    /**
     * Get schema of all tables in a particular base.
     *
     * Docs: https://airtable.com/developers/web/api/get-base-schema
     *
     * @param string|null $baseId Base ID to fetch tables for; defaults to configured base
     * @return array
     */
    public function getTables(?string $baseId = null): array
    {
        $baseId = $baseId ?? $this->baseId;
        $cacheKey = $this->buildCacheKeyForTables($baseId);

        return Cache::remember($cacheKey, $this->cacheTTL, function () use ($baseId) {
            $url = "https://api.airtable.com/v0/meta/bases/{$baseId}/tables";

            $response = Http::withToken($this->token)
                ->acceptJson()
                ->get($url);

            if ($response->successful()) {
                return $response->json()['tables'] ?? [];
            }

            return [];
        });
    }

    /**
     * Build the Airtable API URL for listing records.
     *
     * @return string
     */
    protected function buildRecordsUrl(): string
    {
        return "https://api.airtable.com/v0/{$this->baseId}/" . urlencode($this->tableName);
    }

    /**
     * Build the Airtable API URL for getting a specific record.
     *
     * @param string $recordId
     * @return string
     */
    protected function buildRecordUrl(string $recordId): string
    {
        return "https://api.airtable.com/v0/{$this->baseId}/" . urlencode($this->tableName) . "/{$recordId}";
    }

    /**
     * Build a unique cache key for listing all records with certain parameters.
     *
     * @param array $params
     * @return string
     */
    protected function buildCacheKeyForRecords(array $params): string
    {
        $paramsKey = empty($params) ? 'no_params' : http_build_query($params);
        return "airtable.records.{$this->baseId}.{$this->tableName}." . md5($paramsKey);
    }

    /**
     * Build a unique cache key for a specific record.
     *
     * @param string $recordId
     * @return string
     */
    protected function buildCacheKeyForRecord(string $recordId): string
    {
        return "airtable.record.{$this->baseId}.{$this->tableName}.{$recordId}";
    }

    /**
     * Build a unique cache key for listing bases.
     *
     * @return string
     */
    protected function buildCacheKeyForBases(): string
    {
        return "airtable.bases";
    }

    /**
     * Build a unique cache key for listing tables of a particular base.
     *
     * @param string $baseId
     * @return string
     */
    protected function buildCacheKeyForTables(string $baseId): string
    {
        return "airtable.tables.{$baseId}";
    }
}
