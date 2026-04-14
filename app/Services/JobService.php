<?php

namespace App\Services;

use App\Models\JobPosting;
use Illuminate\Support\Facades\Auth;

class JobService
{
    /**
     * Create a new job posting for the authenticated company.
     */
    public function createJob(array $data): JobPosting
    {
        return JobPosting::create([
            'company_id' => Auth::id(),
            'title' => $data['title'],
            'description' => $data['description'],
            'status' => $data['status'] ?? 'draft',
        ]);
    }

    /**
     * Update an existing job posting.
     */
    public function updateJob(JobPosting $job, array $data): JobPosting
    {
        // Ensure the company owns this job
        if ($job->company_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $job->update($data);

        return $job;
    }

    /**
     * Get jobs for the authenticated company.
     */
    public function getCompanyJobs()
    {
        return JobPosting::where('company_id', Auth::id())->latest()->get();
    }

    /**
     * Get all published jobs (for freelancers).
     */
    public function getPublishedJobs()
    {
        return JobPosting::where('status', 'published')->latest()->get();
    }
}
