<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Http\Models\Repositories\BillStatusRepository;
use App\Http\Models\Repositories\CardTypeRepository;
use App\Traits\GettingResponseTrait;
use GuzzleHttp\Client;
use Illuminate\Console\Command;

class ImportDictionary extends Command
{
    use GettingResponseTrait;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:dictionary';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command imported dictionaries of API';

    /** @var \GuzzleHttp\Client */
    private $client;

    /** @var \App\Http\Models\Repositories\BillStatusRepository */
    private $billStatusRepository;

    /** @var \App\Http\Models\Repositories\CardTypeRepository */
    private $cardTypeRepository;

    /**
     * ImportDictionary constructor.
     *
     * @param \App\Http\Models\Repositories\BillStatusRepository $billStatusRepository
     * @param \App\Http\Models\Repositories\CardTypeRepository   $cardTypeRepository
     */
    public function __construct(BillStatusRepository $billStatusRepository, CardTypeRepository $cardTypeRepository)
    {
        parent::__construct();

        $this->client = new Client([
            'base_uri' => env('API_URL', ''),
            'verify'   => false,
        ]);

        $this->billStatusRepository = $billStatusRepository;
        $this->cardTypeRepository = $cardTypeRepository;
    }

    /**
     * @throws \Exception
     */
    public function handle()
    {
        try {
            $this->importDictionary('BillStatus', $this->billStatusRepository);
            $this->importDictionary('CardType', $this->cardTypeRepository);
        } catch (\Exception $exception) {
            throw new \Exception($exception->getMessage());
        }

        $this->line('Success');
    }

    /**
     * @param string $name
     * @param        $repository
     */
    private function importDictionary(string $name, $repository)
    {
        $response = $this->client
            ->get('Dictionary', [
                'query' => [
                    'name' => $name,
                ],
            ]);

        $dictionaryItems = $this->getResponse($response)['Response']['DictionaryItem'];

        foreach ($dictionaryItems as $dictionaryItem) {
            $repository->updateOrCreate($dictionaryItem);
        }
    }
}
