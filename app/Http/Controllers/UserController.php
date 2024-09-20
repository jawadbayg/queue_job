<?php

namespace App\Http\Controllers;

use App\Jobs\UsersData;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Handle the request to export users.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function exportUsers(Request $request)
    {
        $userEmail = $request->user()->email; 

        
        UsersData::dispatch($userEmail);

        return response()->json(['message' => 'Your export request has been received. You will be notified via email once the export is complete.']);
    }
}
