<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use App\Models\Incident;
use App\Models\MaintenanceLog;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ExportController extends Controller
{
    public function assets(Request $request): Response
    {
        $assets = Asset::with(['category', 'location'])->get();

        $csv = $this->generateCsv($assets, [
            'asset_id' => 'Asset ID',
            'name' => 'Name',
            'category.name' => 'Category',
            'brand' => 'Brand',
            'model' => 'Model',
            'serial_number' => 'Serial Number',
            'purchase_date' => 'Purchase Date',
            'warranty_end_date' => 'Warranty End Date',
            'asset_value' => 'Value',
            'status' => 'Status',
            'location.name' => 'Location',
        ]);

        return response($csv)
            ->header('Content-Type', 'text/csv')
            ->header('Content-Disposition', 'attachment; filename="assets_' . now()->format('Y-m-d') . '.csv"');
    }

    public function maintenance(Request $request): Response
    {
        $logs = MaintenanceLog::with(['asset', 'createdBy'])->get();

        $csv = $this->generateCsv($logs, [
            'asset.asset_id' => 'Asset ID',
            'asset.name' => 'Asset Name',
            'type' => 'Type',
            'vendor' => 'Vendor',
            'pic' => 'PIC',
            'maintenance_date' => 'Date',
            'cost' => 'Cost',
            'description' => 'Description',
            'createdBy.name' => 'Created By',
        ]);

        return response($csv)
            ->header('Content-Type', 'text/csv')
            ->header('Content-Disposition', 'attachment; filename="maintenance_' . now()->format('Y-m-d') . '.csv"');
    }

    public function incidents(Request $request): Response
    {
        $incidents = Incident::with(['asset', 'reportedBy', 'resolvedBy'])->get();

        $csv = $this->generateCsv($incidents, [
            'asset.asset_id' => 'Asset ID',
            'title' => 'Title',
            'description' => 'Description',
            'incident_date' => 'Date',
            'status' => 'Status',
            'severity' => 'Severity',
            'reportedBy.name' => 'Reported By',
            'resolved_date' => 'Resolved Date',
            'resolvedBy.name' => 'Resolved By',
        ]);

        return response($csv)
            ->header('Content-Type', 'text/csv')
            ->header('Content-Disposition', 'attachment; filename="incidents_' . now()->format('Y-m-d') . '.csv"');
    }

    protected function generateCsv($data, array $columns): string
    {
        $output = fopen('php://temp', 'r+');

        // Header row
        fputcsv($output, array_values($columns));

        // Data rows
        foreach ($data as $row) {
            $csvRow = [];
            foreach (array_keys($columns) as $key) {
                $value = data_get($row, $key);

                // Handle enum values
                if (is_object($value) && enum_exists(get_class($value))) {
                    $value = $value->value;
                }

                $csvRow[] = $value;
            }
            fputcsv($output, $csvRow);
        }

        rewind($output);
        $csv = stream_get_contents($output);
        fclose($output);

        return $csv;
    }
}
