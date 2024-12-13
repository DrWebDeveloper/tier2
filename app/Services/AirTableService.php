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
     * List records from the currently configured Airtable table, caching them for the specified TTL.
     *
     * @param  array  $params Optional query parameters (e.g. ['filterByFormula' => '...', 'maxRecords' => 50])
     * @return array
     */
    public function getRecords(array $params = []): array
    {
        return $this->getRecordsFromTable($this->tableName, $params);
    }

    /**
     * Get one specific record's details from the currently configured table.
     *
     * @param string $recordId
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
     * @param string|null $baseId
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
     * Get records from a specific table within the configured base, handling pagination.
     *
     * @param string $tableName
     * @param array $params
     * @return array
     */
    public function getRecordsFromTable(string $tableName, array $params = []): array
    {
        $cacheKey = $this->buildCacheKeyForRecords($tableName, $params);

        return Cache::remember($cacheKey, $this->cacheTTL, function () use ($tableName, $params) {
            $allRecords = [];
            $offset = null;

            do {
                $queryParams = $params;
                if ($offset) {
                    $queryParams['offset'] = $offset;
                }

                $url = $this->buildRecordsUrl($tableName);
                $response = Http::withToken($this->token)
                    ->acceptJson()
                    ->get($url, $queryParams);

                if ($response->failed()) {
                    // In case of failure, return what we have so far (or empty if first page failed)
                    return $allRecords;
                }

                $data = $response->json();
                $records = $data['records'] ?? [];
                $allRecords = array_merge($allRecords, $records);

                // Check for offset for pagination
                $offset = $data['offset'] ?? null;
            } while ($offset);

            return $allRecords;
        });
    }

    /**
     * Get records from the "Industries" table.
     *
     * @param array $params
     * @return array
     */
    public function getIndustries(array $params = []): array
    {
        return $this->getRecordsFromTable('Industries', $params);
    }

        /**
     * Get records from the table with ID "tblsrns11YWqP2zov".
     *
     * @param array $params
     * @return array
     */
    public function getEsportsOrgs(array $params = []): array
    {
        return $this->getRecordsFromTable('tblsrns11YWqP2zov', $params);
    }


    /**
     * Get records from the "Sponsorships" table.
     *
     * @param array $params
     * @return array
     */
    public function getSponsorships(array $params = []): array
    {
        return $this->getRecordsFromTable('Sponsorships', $params);
    }

    /**
     * Get records from the "Branding" table.
     *
     * @param array $params
     * @return array
     */
    public function getBranding(array $params = []): array
    {
        return $this->getRecordsFromTable('Branding', $params);
    }

    /**
     * Build the Airtable API URL for listing records.
     *
     * @param string|null $tableName
     * @return string
     */
    protected function buildRecordsUrl(?string $tableName = null): string
    {
        $tableName = $tableName ?? $this->tableName;
        return "https://api.airtable.com/v0/{$this->baseId}/" . urlencode($tableName);
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
     * Build a unique cache key for listing all records of a specific table with certain parameters.
     *
     * @param string $tableName
     * @param array $params
     * @return string
     */
    protected function buildCacheKeyForRecords(string $tableName, array $params = []): string
    {
        $paramsKey = empty($params) ? 'no_params' : http_build_query($params);
        return "airtable.records.{$this->baseId}.{$tableName}." . md5($paramsKey);
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
