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
    protected string $pattern = '{user}';
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
        Telegram::sendMessage([
            'chat_id' => $this->getUpdate()->getMessage()->getChat()->getId(),
            'text' => 'Please wait, I am preparing the file for you',
        ]);

        $user = $this->argument('user');
        $user = strtolower(str_replace('_', ' ', $user));

        $fileName = 'users.xlsx';
        Excel::store(new UsersExport($user), $fileName, 'public');

        $filePath = storage_path('app/public/' . $fileName);

        Telegram::sendDocument([
            'chat_id' => $this->getUpdate()->getMessage()->getChat()->getId(),
            'document' => InputFile::create($filePath, $fileName),
            'caption' => 'Here is the user data',
        ]);
    }
}
