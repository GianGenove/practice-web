<?php

namespace App\Http\Controllers;

use App\Models\Job;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;

class JobController extends Controller
{
    public function index()
    {

        return view('jobs.index', [
            'jobs' => Job::with('employer')->cursorPaginate(4)
        ]);

    }

    public function show(Job $job)
    {
        return view('jobs.show', [
            'job' => $job
        ]);
    }


    public function create()
    {
        return view('jobs.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => [
                'required',
                'string',
                'min:3',
                'max:100'
            ],
            'description' => [
                'required',
                'string',
                'min:10'
            ],
            'salary' => [
                'required',
                'string',
                'min:3',
                'max:100'
            ]
        ]);

        // Sample code to get employer_id using Auth and DB
        // $employer_id = DB::table('employers')->where('user_id', Auth::id())->get();

        $job = Job::create([
            'title' => $validated['title'],
            'description' => $validated['description'],
            'salary' => $validated['salary'],
            'employer_id' => 1 // Replace with actual employer_id s
        ]);

        return redirect()->route('jobs.show', ['job' => $job->id]);


    }

    public function edit(Job $job)
    {

        // Gate::authorize('edit-job', $job);

        return view('jobs.edit', [
            'job' => $job
        ]);
    }

    public function update(Request $request, Job $job)
    {

        $validated = $request->validate([
            'title' => [
                'required',
                'string',
                'min:3',
                'max:100'
            ],
            'description' => [
                'required',
                'string',
                'min:10'
            ],
            'salary' => [
                'required',
                'string',
                'min:3',
                'max:100'
            ]
        ]);

        $job->update($validated);

        // dd($job);

        return redirect()->route('jobs.show', ['job' => $job->id]);
    }

    public function destroy(Job $job)
    {

        $job->delete();

        return redirect('/jobs');
    }

}
