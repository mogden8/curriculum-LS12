<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NotifyCourseAddedToProgramMail extends Mailable
{
    use Queueable, SerializesModels;

    public $course_id;

    public $course_code;

    public $course_num;

    public $course_title;

    public $program_title;

    public $program_id;

    public $is_required;

    /**
     * Create a new message instance.
     */
    public function __construct(int $course_id, string $course_code, string $course_num, string $course_title, string $program_title, int $program_id, bool $is_required)
    {
        $this->course_id = $course_id;         // course id for generating URLs
        $this->course_code = $course_code;     // course code (ex. SLEP)
        $this->course_num = $course_num;       // course num (ex. 101)
        $this->course_title = $course_title;   // course title (ex. Intro to Sleeping)
        $this->program_title = $program_title; // program title (ex. Bachelor of Sleep)
        $this->program_id = $program_id;       // program id for generating URLs
        $this->is_required = $is_required;     // whether the course is required
    }

    /**
     * Build the message.
     */
    public function build(): static
    {
        $course_full_name = "{$this->course_code} {$this->course_num}";

        return $this->markdown('emails.notifyCourseAddedToProgram', [
            'course_id' => $this->course_id,
            'course_code' => $this->course_code,
            'course_num' => $this->course_num,
            'course_title' => $this->course_title,
            'program_title' => $this->program_title,
            'program_id' => $this->program_id,
            'is_required' => $this->is_required,
        ])
            ->subject("{$course_full_name} Added to {$this->program_title}");
    }
}
