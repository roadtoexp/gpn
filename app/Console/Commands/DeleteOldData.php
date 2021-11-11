<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Http\Models\Repositories\SessionRepository;
use App\Http\Models\Repositories\UserRepository;
use App\Traits\GettingResponseTrait;
use Carbon\Carbon;
use Illuminate\Console\Command;

class DeleteOldData extends Command
{
    use GettingResponseTrait;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'delete:old';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command deleted old data';

    /** @var \App\Http\Models\Repositories\SessionRepository */
    private $sessionRepository;

    /** @var \App\Http\Models\Repositories\UserRepository */
    private $userRepository;

    /**
     * DeleteOldData constructor.
     *
     * @param \App\Http\Models\Repositories\SessionRepository $sessionRepository
     * @param \App\Http\Models\Repositories\UserRepository    $userRepository
     */
    public function __construct(SessionRepository $sessionRepository, UserRepository $userRepository)
    {
        parent::__construct();

        $this->sessionRepository = $sessionRepository;
        $this->userRepository = $userRepository;
    }

    /**
     * @throws \Exception
     */
    public function handle()
    {
        try {
            $sessions = $this->sessionRepository->findOld(Carbon::now());

            foreach ($sessions as $session) {
                if ($session->user_id) {
                    $this->userRepository->deleteById($session->user_id);
                }
            }
        } catch (\Exception $exception) {
            throw new \Exception($exception->getMessage());
        }
    }
}
