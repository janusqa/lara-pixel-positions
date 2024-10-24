<?php

namespace App\Http\Controllers;

use App\Models\Job;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    //
    public function show(Request $request)
    {
        $searchAttributes = $request->validate([
            'q' => ['required', 'min:3', 'regex:/\S+/']
        ]);

        // $jobs = Job::where('title', 'LIKE', '%' . $request->query('q') . '%')->get();
        $jobs = Job::with(['employer', 'tags'])->where('title', 'LIKE', '%' . $searchAttributes['q'] . '%')->get();

        return view('jobs/results', ['jobs' => $jobs]);
    }
}
