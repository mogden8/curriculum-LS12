<?php

namespace App\Mail;

use App\Models\Course;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CourseAccessRequestMail extends Mailable
{
    use Queueable;
    use SerializesModels;

    public function __construct(
        public readonly Course $course,
        public readonly User $requester,
        public readonly string $accessType,
        public readonly ?string $requestMessage
    ) {}

    public function build(): static
    {
        return $this->subject('Access request: '.$this->course->course_code.' '.$this->course->course_num.' - '.$this->course->course_title)
            ->markdown('emails.courseAccessRequest', [
                'course' => $this->course,
                'requester' => $this->requester,
                'accessType' => $this->accessType,
                'requestMessage' => $this->requestMessage,
            ]);
    }
}
