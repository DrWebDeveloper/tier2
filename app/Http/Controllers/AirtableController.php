<?php

namespace App\Http\Controllers;

use App\Models\Industry;
use App\Models\Sponsorship;
use App\Services\AirTableService;

class AirtableController extends Controller
{
    public function index(AirTableService $airtable)
    {
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

        // dd(Sponsorship::get());
        // dd(Industry::with('sponsorships')->get());

        // Get all tables for the configured base.
        return inertia('Airtable/Index', [
            'industries' => Industry::withCount('sponsorships')->get(),
            'sponsorships' => Sponsorship::get(),
        ]);
        $tables = $airtable->getTables();

        $allData = [];
        foreach ($tables as $table) {
            // Extract the table name from the table schema response
            $tableName = $table['name'];

            // Create a new instance of the service for each table to fetch its records
            $tableAirtableService = new AirTableService(
                config('services.airtable.token'),
                config('services.airtable.base_id'),
                $tableName
            );

            // Fetch records for this particular table
            $records = $tableAirtableService->getRecords();

            $allData[] = [
                'table' => $tableName,
                'records' => $records,
            ];
        }
        dd($allData);

        return view('airtable.index', compact('allData'));
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
