<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class Setting extends Controller
{
    // index page setting
    public function index()
    {
        return view('setting.settings');
    }

    public function encapsulation()
    {
        $users = User::all();
        return view('security.encapsulation', compact('users'));
    }

    public function toggleEncryption(Request $request)
    {
        try {
            $enabled = $request->input('enabled', false);
            
            // Call the stored procedure to toggle encryption
            DB::statement('CALL toggle_encryption(?)', [$enabled]);
            
            return response()->json([
                'success' => true,
                'message' => $enabled ? 'Encryption disabled' : 'Encryption enabled'
            ]);
        } catch (\Exception $e) {
            \Log::error('Encryption toggle error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error updating encryption status: ' . $e->getMessage()
            ], 500);
        }
    }
}
