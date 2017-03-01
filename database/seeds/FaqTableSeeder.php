<?php

use Illuminate\Database\Seeder;
use App\Faq;

class FaqTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Faq::truncate();


        $faq = [
            [
                'question' => 'How secure is your website and my account data?', 
                'answer' => 'We have a wide range of security measures to protect your account. Our website is protected against DDoS attacks, all transferred data are SSL-encrypted and we use a licensed script. Our website is located on a dedicated server with a firewall installed on it. '
            ],
            [
                'question' => 'What if I forgot my password?', 
                'answer' => 'Click "Forgot password?" link, enter your login name and e-mail and your login data will be sent to your e-mail address. '
            ],
             [
                'question' => 'How can I access the account?', 
                'answer' => 'If you are a registered user already, please click on "Login" button enter your login name and password in the appropriate fields. You will be redirected to your account automatically as soon as you have done the above. '
            ],
             [
                'question' => 'Do you have a referral program?', 
                'answer' => 'Yes, we have a referral program which offer 12% referral commissions of the deposit for any member you refer to our program. All members of our site have a referral link that they can use to invite new members. '
            ],
             [
                'question' => 'Can I have multiple accounts?', 
                'answer' => 'Yes, you can have multiple accounts. '
            ],
             [
                'question' => 'Which E-Currencies do you accept?', 
                'answer' => 'We accept PerfectMoney, Payeer and BitCoin at the moment. '
            ],
             [
                'question' => 'What are the limits of deposit?', 
                'answer' => 'We accept investments from 2 USD to 20,000 USD.'
            ],
             [
                'question' => 'What are the limits for withdrawal?', 
                'answer' => 'Minimum amount is 0.01 USD for Payeer and PerfectMoney and 0.001 BTC for BitCoin currency. '
            ],
             [
                'question' => 'I have pending/missing withdraw what should I do?', 
                'answer' => 'Please wait upto 24 hours before reporting via support ticket. '
            ],
             [
                'question' => 'Why the withdraw are not instant, my withdraw went to pending and when will I get withdraw?', 
                'answer' => 'All our withdraw are instantly.  '
            ],
             [
                'question' => 'Where I can check investment plans?', 
                'answer' => 'You can check our investment plans here. '
            ],
             [
                'question' => 'Is compounding available?', 
                'answer' => 'We do not currently offer the option to compound your earnings. '
            ],
            [
                'question' => 'Will I receive my initial deposit back after my deposit expire?', 
                'answer' => 'Yes, you will receive your deposit back when you deposit will expire.'
            ],
            [
                'question' => 'Can i withdraw my active deposit before the plan will expire?', 
                'answer' => 'No, it is not possible. '
            ],
            [
                'question' => 'How much active investments I can have at the same time?', 
                'answer' => 'You can have as much as you want. '
            ],
        ];
        
        Faq::insert($faq);
    }
}
