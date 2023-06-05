<?php

namespace App\Console\Commands;

use App\Models\Respond;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

use function Symfony\Component\String\s;

class ServerSend extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'hh:server-send';

    private static string $urlServer = 'https://hub.blackclever.ru';

    private static array $pathFiles = [
        '/voditel-kurer.json',
    ];

    private static int $countGetResponds = 2;

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        foreach (static::$pathFiles as $path) {

            $file = json_decode(
                file_get_contents(static::$urlServer.$path),
                true
            );

            $arrayResponds = $file[1];

            $lastFileId = end($arrayResponds)['id'] ?? 1;

            $lastDBId = Respond::query()
                ->latest('id')
                ->first()
                ->id;

            if ($lastFileId !== $lastDBId) {

                $respondsCollection = Respond::query()
                    ->where('id', '>', $lastFileId)
                    ->limit(static::$countGetResponds)
                    ->get(['id', 'name', 'title', 'area', 'phone']);

                if ($respondsCollection->count() > 0) {

                    foreach ($respondsCollection as $respond) {

                        $preparedResponds[] = [
                            'id'       => $respond->id,
                            'name'     => explode(' ', $respond->name)[0] ?? ' ',
                            'last_name'=> explode(' ', $respond->name)[1] ?? ' ',
                            'number'   => preg_replace('~\D+~','', $respond->phone),
                            'city'     => $respond->area,
                        ];
                    }

                    $fileData = json_encode([
                        $file[0],
                        array_merge($preparedResponds, $arrayResponds)
                    ], JSON_UNESCAPED_SLASHES);//

                    $fd = fopen("test.json", 'w');
                    fwrite($fd, $fileData);
                    fclose($fd);
                }
            }
        }

        return Command::SUCCESS;
    }
}
