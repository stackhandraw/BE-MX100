<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\JobPosting;
use App\Services\JobService;
use Illuminate\Http\Request;

class CompanyJobController extends Controller
{
    protected JobService $jobService;

    public function __construct(JobService $jobService)
    {
        $this->jobService = $jobService;
    }

    public function index()
    {
        $jobs = $this->jobService->getCompanyJobs();
        return response()->json(['data' => $jobs]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'status' => 'nullable|in:draft,published',
        ]);

        $job = $this->jobService->createJob($validated);

        return response()->json([
            'message' => 'Job created successfully',
            'data' => $job
        ], 201);
    }

    public function update(Request $request, JobPosting $job)
    {
        $validated = $request->validate([
            'title' => 'sometimes|string|max:255',
            'description' => 'sometimes|string',
            'status' => 'sometimes|in:draft,published',
        ]);

        $updatedJob = $this->jobService->updateJob($job, $validated);

        return response()->json([
            'message' => 'Job updated successfully',
            'data' => $updatedJob
        ]);
    }

    public function applications(JobPosting $job)
    {
        if ($job->company_id !== request()->user()->id) {
            abort(403, 'Unauthorized action.');
        }

        $applications = $job->applications()->with('freelancer')->get();

        return response()->json(['data' => $applications]);
    }
}
