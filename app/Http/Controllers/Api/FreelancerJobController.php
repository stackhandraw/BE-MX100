<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\JobPosting;
use App\Models\JobApplication;
use App\Services\JobService;
use Illuminate\Http\Request;

class FreelancerJobController extends Controller
{
    protected JobService $jobService;

    public function __construct(JobService $jobService)
    {
        $this->jobService = $jobService;
    }

    public function index()
    {
        $jobs = $this->jobService->getPublishedJobs();
        return response()->json(['data' => $jobs]);
    }

    public function apply(Request $request, JobPosting $job)
    {
        if ($job->status !== 'published') {
            return response()->json(['message' => 'Job is not published.'], 400);
        }

        $validated = $request->validate([
            'cv_path' => 'required|string', // in reality this might be a file upload, but string is faster for demonstration
        ]);

        $user = $request->user();

        // Check if already applied
        $exists = JobApplication::where('job_posting_id', $job->id)
            ->where('freelancer_id', $user->id)
            ->exists();

        if ($exists) {
            return response()->json(['message' => 'You have already applied for this job.'], 400);
        }

        $application = JobApplication::create([
            'job_posting_id' => $job->id,
            'freelancer_id' => $user->id,
            'cv_path' => $validated['cv_path'],
        ]);

        return response()->json([
            'message' => 'Application submitted successfully',
            'data' => $application
        ], 201);
    }
}
