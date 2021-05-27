<?php

use Illuminate\Database\Seeder;

use App\Message;
class MessagesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $messagesArray = [
            ['first_hello',      'first_hello',                            'helloBoot',        'en', NULL],
            ['create_account',   'account|create my account|create',       'setName',          'en', 'setEmail'],
            ['set_email',        'setEmail',                               'setEmail',         'en', 'setPassword'],
            ['set_password',     'setPassword',                            'setPassword',      'en', 'confirmPassword'],
            ['confirm_password', 'confirmPassword',                        'confirmPassword',  'en', 'registerAccount'],
            ['loginEmail',       'login|make login|entry',                 'loginEmail',       'en', 'loginPassword'],
            ['loginPassword',    'loginPassword',                          'loginPassword',    'en', 'login'],
            ['deposit',          'deposit|make deposit|make a deposit',    'deposit',          'en', 'currencyDeposit'],
            ['currencyDeposit',  'currencyDeposit',                        'currencyDeposit',  'en', 'deposit'],
            ['balance',          'balance|get my balance|see my balance',  'balance',          'en', 'balance'],
            ['withdraw',         'withdraw|make withdraw|make a withdraw', 'withdraw',         'en', 'currencyWithdraw'],
            ['currencyWithdraw', 'currencyWithdraw',                       'currencyWithdraw', 'en', 'withdraw'],
            ['setCurrency',      'set currency|set my currency',           'setCurrency',      'en', 'saveCurrency'],
        ];
        
        foreach ($messagesArray as $key => $message) {
            Message::create([
                'bot_code' => $message[0],
                'expected_entries' => $message[1],
                'bot_response' => $message[2],
                'translation_language' => $message[3],
                'next_step' => $message[4]
            ]);
        }
    }
}
