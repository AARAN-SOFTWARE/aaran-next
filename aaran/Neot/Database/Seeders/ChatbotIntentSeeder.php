<?php


namespace Aaran\Neot\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ChatbotIntentSeeder extends Seeder
{
    public function run()
    {
        DB::table('chatbot_intents')->insert([
            [
                'title' => 'Show Price List',
                'pattern' => '/price\s*list/i',
                'static_response' => null,
                'model_class' => 'Aaran\BMS\Billing\Master\Models\Product',
                'columns' => json_encode(['name', 'price']),
                'where_conditions' => json_encode([]),
                'view_template' => 'neot.partials::price-list',
                'priority' => 10,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Pending Payments',
                'pattern' => '/(pending\s*payments|unpaid\s*invoices)/i',
                'static_response' => null,
                'model_class' => 'Aaran\BMS\Billing\Entries\Models\Sale',
                'columns' => json_encode(['invoice_number', 'total_amount', 'due_date']),
                'where_conditions' => json_encode([
                    ['status', '=', 'pending'],
                    ['customer_id', '=', '{{user_id}}']
                ]),
                'view_template' => 'neot.partials::pending-payments',
                'priority' => 20,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Simple Greeting',
                'pattern' => '/(hello|hi|hey)/i',
                'static_response' => 'Hello! 👋 How can I assist you today?',
                'model_class' => null,
                'columns' => null,
                'where_conditions' => null,
                'view_template' => null,
                'priority' => 5,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
