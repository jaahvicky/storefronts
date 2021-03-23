<?php

namespace App\Jobs;

use App\Jobs\Job;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Contracts\Queue\ShouldQueue;

use Monolog\Handler\RotatingFileHandler;
use Monolog\Logger;
use Mail;
use Mandrill_Error;

use App\Dtos\EmailRequest;
use Config;

class SendEmail extends Job implements ShouldQueue, SelfHandling
{
    use InteractsWithQueue, SerializesModels;
    
    protected $emailRequest;
    private $monolog;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(EmailRequest $emailRequest) {
        $this->emailRequest = $emailRequest;
		
        //Create a seperate logger - logs to /storage/logs/emails.log
        $this->monolog = new Logger('emails');
        $handler = new RotatingFileHandler(storage_path() . '/logs/emails.log', \Config::get('storefronts-backoffice.logs-max-days'), Logger::DEBUG);
        $this->monolog->pushHandler($handler);
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle() {
        try {
            list($email, $name, $subject) = [$this->emailRequest->getEmail(), $this->emailRequest->getName(), $this->emailRequest->getSubject()];
            
            Mail::queue($this->emailRequest->getTemplate(), 
                    ['email' => $email, 'name' => $name, 'subject' => $subject], function ($m) 
                    use ($email, $name, $subject) {
                
                $m->from(\Config::get('storefronts-backoffice.from_email'), \Config::get('storefronts-backoffice.from_name'));
                $m->to($email, $name)->subject($subject);
            });

        } catch(Exception $e) {
            // Mandrill errors are thrown as exceptions
            echo 'An error occurred: ' . get_class($e) . ' - ' . $e->getMessage();
            // A mandrill error occurred: Mandrill_Unknown_Subaccount - No subaccount exists with the id 'customer-123'
            $this->monolog->addError(get_class($e) . ': ' . $e->getMessage());
            throw $e;
        }
    }
}
