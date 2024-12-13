<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Cache;
use App\Models\Industry;
use App\Models\Organization;
use App\Models\Sponsorship;
use App\Services\AirTableService;
use Carbon\Carbon;

class AirtableController extends Controller
{
    // public function index(AirTableService $airtable)
    // {
    // $industries = $airtable->getIndustries();
    // // Check in Industries table and create if not exists
    // foreach ($industries as $industry) {
    //     Industry::firstOrCreate([
    //         'rid' => $industry['id'],
    //         'name' => $industry['fields']['Industry Type Name'],
    //         'sponsors' => json_encode($industry['fields']['Industry Type Sponsors']),
    //         'created_at' => $industry['createdTime'],
    //     ]);
    // }

    // get the getSponsorships from the AirTableService and create the Sponsorships table
    // Check in Sponsorships table and create if not exists
    // $sponsorships = $airtable->getSponsorships();

    // foreach ($sponsorships as $sponsorship) {
    //     Sponsorship::firstOrCreate([
    //         'rid' => $sponsorship['id'],
    //         'esports_orgs' => json_encode(collect($sponsorship['fields']['Esports Orgs']??null)),
    //         'industry_rid' => $sponsorship['fields']['Industry Type']??null,
    //         'name' => $sponsorship['fields']['Name']?? '',
    //         'logo' => json_encode(collect($sponsorship['fields']['Logo']??null)),
    //         'website' => $sponsorship['fields']['Website']??null,
    //         'created_at' => $sponsorship['createdTime'],
    //     ]);
    // }
    // $tables = $airtable->getTables();

    //     $allData = [];
    //     foreach ($tables as $table) {
    //         // Extract the table name from the table schema response
    //         $tableName = $table['name'];

    //         // Create a new instance of the service for each table to fetch its records
    //         $tableAirtableService = new AirTableService(
    //             config('services.airtable.token'),
    //             config('services.airtable.base_id'),
    //             $tableName
    //         );

    // Fetch records for this particular table
    //     $records = $tableAirtableService->getRecords();

    //     $allData[] = [
    //         'table' => $tableName,
    //         'records' => $records,
    //     ];
    // }
    // dd($allData);

    // return view('airtable.index', compact('allData'));

    // dd(Sponsorship::get());
    // dd(Industry::with('sponsorships')->get());
    // }

    public function index(AirTableService $airtable)
    {
        $industries = Cache::remember('industries_with_sponsorship_count', 15 * 60, function () {
            return Industry::withCount('sponsorships')->get();
        });

        $sponsorships = Cache::remember('all_sponsorships', 15 * 60, function () {
            return Sponsorship::get();
        });

        return inertia('Airtable/Index', [
            'industries' => $industries,
            'sponsorships' => $sponsorships,
        ]);
    }

    public function esportsOrgs(AirTableService $airtable)
    {

        $organization = Cache::remember('all_organization', 15 * 60, function () use($airtable) {
            return $airtable->getEsportsOrgs();
        });
        // dd($organization);

        // store the data in the database
        foreach ($organization as $org) {
            Organization::firstOrCreate([
                'rid' => $org['id'],
                'name' => $org['fields']['Name']??'',
                'sponsorships' => json_encode(collect($org['fields']['Sponsorships']??null)),
                'sponsorship_logos' => json_encode(collect($org['fields']['Sponsorship Logo']??null)),
                'sponsorship_names' => json_encode(collect($org['fields']['Sponsor Name']??null)),
                'sponsorship_websites' => json_encode(collect($org['fields']['Sponsor Website']??null)),
                'logo' => json_encode(collect($org['fields']['Logo']??null)),
                'country' => $org['fields']['Country']??null,
                'website' => $org['fields']['Website']??null,
                'created_at' => Carbon::parse($org['createdTime'])->toDateTimeString(),
            ]);
        }

        dd(Organization::get());

        
    }

    public function showRecords(AirTableService $airtable)
    {
        $records = $airtable->getRecords([
            'filterByFormula' => "{Status} = 'Active'",
            'maxRecords' => 50
        ]);

        return view('airtable.records', compact('records'));
    }

    public function showBases(AirTableService $airtable)
    {
        $bases = $airtable->getBases();

        return view('airtable.bases', compact('bases'));
    }


    public function showTables(AirTableService $airtable)
    {
        // If no argument is passed, uses the default configured base in AirTableService
        $tables = $airtable->getTables();

        return view('airtable.tables', compact('tables'));
    }

    public function listRecords(AirTableService $airtable)
    {
        $records = $airtable->getRecords([
            'filterByFormula' => "{Status} = 'Active'",
            'maxRecords' => 50
        ]);

        return view('airtable.records', compact('records'));
    }

    public function getRecord(AirTableService $airtable, $recordId)
    {
        $record = $airtable->getRecord($recordId);

        return view('airtable.record', compact('record'));
    }
}
