<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\PaymentCategory;
use App\Models\PaymentMethod;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Akun Admin (Gunakan updateOrCreate agar aman)
        User::updateOrCreate(
            ['email' => 'admin@keuangan.test'],
            [
                'name' => 'Administrator',
                'password' => Hash::make('password'),
                'is_admin' => true,
                'is_active' => true,
            ]
        );

        // 2. Buat Kategori Utama Sesuai Request
        $categories = [
            'Cash / Tunai',
            'E-Wallet / Dompet Digital',
            'QRIS',
            'Bank',
            'Crypto'
        ];

        foreach ($categories as $index => $name) {
            $category = PaymentCategory::create([
                'name' => $name,
                'sort_order' => $index + 1,
                'is_active' => true
            ]);

            // Tambahkan seeder metode untuk Cash / Tunai
            if ($name === 'Cash / Tunai') {
                PaymentMethod::create(['payment_category_id' => $category->id, 'name' => 'Uang Kertas Rupiah', 'sort_order' => 1]);
                PaymentMethod::create(['payment_category_id' => $category->id, 'name' => 'Uang Logam Rupiah', 'sort_order' => 2]);
            }

            // Tambahkan seeder metode untuk E-Wallet / Dompet Digital
            if ($name === 'E-Wallet / Dompet Digital') {
                $wallets = ['GoPay', 'OVO', 'DANA', 'ShopeePay', 'LinkAja', 'Sakuku', 'i.saku', 'AstraPay', 'DOKU', 'MotionPay', 'SpeedCash', 'Netzme'];
                foreach ($wallets as $wIndex => $wName) {
                    PaymentMethod::create([
                        'payment_category_id' => $category->id,
                        'name' => $wName,
                        'sort_order' => $wIndex + 1
                    ]);
                }
            }

            // Tambahkan seeder metode untuk Bank
            if ($name === 'Bank') {
                $banks = [
                    'Bank Mandiri', 'Bank Rakyat Indonesia (BRI)', 'Bank Negara Indonesia (BNI)', 
                    'Bank Tabungan Negara (BTN)', 'Bank Syariah Indonesia (BSI)', 'Bank Central Asia (BCA)', 
                    'Bank CIMB Niaga', 'Bank Danamon', 'Bank Permata', 'Bank Mega', 'Bank Panin', 
                    'Bank OCBC NISP', 'Bank Mayapada', 'Bank MNC', 'Bank Sinarmas',
                    'Bank Aceh', 'Bank Sumut', 'Bank Nagari', 'Bank Riau Kepri', 'Bank Jambi', 
                    'Bank Sumsel Babel', 'Bank Bengkulu', 'Bank Lampung', 'Bank BJB', 'Bank DKI', 
                    'Bank Banten', 'Bank Jateng', 'Bank BPD DIY', 'Bank Jatim', 'Bank Kalbar', 
                    'Bank Kalsel', 'Bank Kaltimtara', 'Bank Kalteng', 'Bank BPD Bali', 'Bank NTB Syariah', 
                    'Bank NTT', 'Bank Sulselbar', 'Bank Sulteng', 'Bank Sultra', 'Bank Sulutgo', 
                    'Bank Malukumalut', 'Bank Papua',
                    'Bank Muamalat Indonesia', 'Bank Mega Syariah', 'Bank Panin Dubai Syariah', 
                    'Bank BCA Syariah', 'Bank BTPN Syariah', 'Bank Aladin Syariah', 'Bank Nano Syariah', 
                    'Bank KB Bukopin Syariah', 'Bank BJB Syariah',
                    'Jenius (Bank BTPN)', 'Bank Jago', 'SeaBank', 'Bank Neo Commerce', 'Allo Bank', 
                    'Bank Raya', 'Blu (BCA Digital)', 'Line Bank (Hana Bank)', 'Superbank',
                    'Citibank N.A.', 'HSBC', 'Standard Chartered Bank', 'Deutsche Bank', 
                    'Bank of America, N.A.', 'J.P. Morgan Chase Bank, N.A.', 'UOB', 'DBS Bank', 
                    'OCBC Bank', 'Maybank', 'Bangkok Bank', 'CCB', 'Bank KEB Hana', 'Bank Woori Saudara', 'ANZ'
                ];
                foreach ($banks as $bIndex => $bName) {
                    PaymentMethod::create(['payment_category_id' => $category->id, 'name' => $bName, 'sort_order' => $bIndex + 1]);
                }
            }

            // Tambahkan seeder metode untuk QRIS
            if ($name === 'QRIS') {
                $qrisMethods = [
                    'Blu (BCA Digital)', 'BCA mobile', 'BRImo', 'BNI Mobile Banking', 
                    "Livin' by Mandiri", 'M-Smile', 'OCTO Mobile', 'Permata Mobile X', 
                    'JakOne Mobile', 'Simobi+', 'Nobu Mobile', 'DIGI by bank bjb', 
                    'OCBC Mobile', 'Jenius', 'Sampoerna Mobile Banking', 'Motion Banking', 
                    'Bank DKI Mobile', 'IBK Mobile Banking', 'BSGQRIS', 'Mobile Banking BPR KS',
                    'GoPay', 'ShopeePay', 'DANA', 'LinkAja', 'OVO', 'Netzme', 
                    'Sakuku', 'AstraPay', 'i.saku', 'DOKU', 'GoBiz', 'Midtrans', 
                    'Xendit', 'OY!', 'Kashier', 'Moka', 'Olsera', 'InstaQRIS'
                ];
                foreach ($qrisMethods as $qIndex => $qName) {
                    PaymentMethod::create([
                        'payment_category_id' => $category->id,
                        'name' => $qName,
                        'sort_order' => $qIndex + 1
                    ]);
                }
            }

            // Tambahkan seeder metode untuk Crypto
            if ($name === 'Crypto') {
                $cryptos = [
                    'Ajaib', 'ASTAL', 'Bittime', 'Bitwewe', 'Bitwyre', 'BTSE Indonesia', 
                    'Coinvest', 'CoinX', 'CYRA', 'digitalexchange.id', 'Fasset', 'Floq', 
                    'GudangKripto', 'Indodax', 'Koinsayang', 'Luno', 'MAKS', 'Mobee', 
                    'Naga Exchange', 'Nanovest', 'Nobi', 'Pintu', 'Pluang', 'Reku', 
                    'Samuel Kripto', 'Stockbit', 'Tokocrypto'
                ];
                foreach ($cryptos as $cIndex => $cName) {
                    PaymentMethod::create([
                        'payment_category_id' => $category->id,
                        'name' => $cName,
                        'sort_order' => $cIndex + 1
                    ]);
                }
            }
        }
    }
}