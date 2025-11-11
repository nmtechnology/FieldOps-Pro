<?php

namespace App\Http\Controllers;

class TutorialListController extends Controller
{
    /**
     * Get list of all available tutorials
     */
    public function index()
    {
        // Define all available tutorials with their metadata
        $tutorials = [
            [
                'id' => 'FieldTechTraining',
                'name' => 'Field Technician Training',
                'slides' => 15,
                'description' => 'Comprehensive guide to field technician practices',
            ],
            [
                'id' => 'Cat6CableTraining',
                'name' => 'Cat 6 Cable Installation & Termination',
                'slides' => 25,
                'description' => 'Learn professional cable installation techniques',
            ],
            [
                'id' => 'NetworkEquipmentSetup',
                'name' => 'Network Equipment Setup',
                'slides' => 26,
                'description' => 'Complete guide to network equipment installation',
            ],
            [
                'id' => 'CCTVTroubleshooting',
                'name' => 'CCTV Camera Troubleshooting',
                'slides' => '30+',
                'description' => 'Professional CCTV system troubleshooting and diagnostics',
            ],
        ];

        return response()->json([
            'tutorials' => $tutorials,
            'count' => count($tutorials),
        ]);
    }
}
