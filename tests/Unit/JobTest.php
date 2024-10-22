<?php

namespace Tests\Unit;

use App\Models\Employer;
use App\Models\Job;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class JobTest extends TestCase
{
    use RefreshDatabase; // This runs migrations for each test.

    /**
     * A basic unit test example.
     */
    public function test_job_belongs_to_an_employer(): void
    {
        // Arrange
        $employer = Employer::factory()->create();
        $job = Job::factory()->create(['employer_id' => $employer->id]); // set employer_id of job to the employer id we created when creating a job

        // Act
        $jobEmployer = $job->employer();

        //Assert
        $this->assertTrue($jobEmployer->is($employer));
    }

    public function test_job_can_have_tags(): void
    {
        // Arrange
        $job = Job::factory()->create(); // set employer_id of job to the employer id we created when creating a job

        // Act
        $job->tag('Frontend');

        //Assert
        $this->assertCount(1, $job->tags); // Assert that the job has 1 tag
    }
}
