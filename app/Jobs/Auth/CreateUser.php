<?php

namespace App\Jobs\Auth;

use App\Jobs\BaseJob;
use App\Models\User;

class CreateUser extends BaseJob
{
    protected $user;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($user)
    {
        $this->user = $user;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $this->prepareRequest();

        \DB::transaction(function () {
            $this->user = User::create($this->request);
        });

        return $this->user;
    }

    private function prepareRequest()
    {
        $this->request['password'] = bcrypt($this->request['password']);
    }
}
