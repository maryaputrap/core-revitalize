<?php

namespace App\Console\Commands;

use App\Exports\UsersExport;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use Telegram\Bot\Api;
use Telegram\Bot\Commands\Command;
use Telegram\Bot\Exceptions\TelegramSDKException;
use Telegram\Bot\FileUpload\InputFile;
use Telegram\Bot\Laravel\Facades\Telegram;

class SendExcelCommand extends Command
{
    protected string $name = 'user';

    /**
     * The console command description.
     *
     * @var string
     */
    protected string $description = 'Command description';

    /**
     * Execute the console command.
     * @throws TelegramSDKException
     */
    public function handle()
    {
        $fileName = 'users.xlsx';
        Excel::store(new UsersExport, $fileName, 'public');

        $filePath = storage_path('app/public/' . $fileName);

        Telegram::sendDocument([
            'chat_id' => $this->getUpdate()->getMessage()->getChat()->getId(),
            'document' => InputFile::create($filePath, $fileName),
            'caption' => 'Here is the user data',
        ]);
    }
}
