<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class GenerateKodeAdmin extends Command
{
    protected $signature = 'admin:generate-kode';
    protected $description = 'Generate kode_admin untuk semua admin yang belum memiliki kode';

    public function handle()
    {
        $admins = User::admins()->whereNull('kode_admin')->get();

        if ($admins->isEmpty()) {
            $this->info('Semua admin sudah memiliki kode_admin.');
            return 0;
        }

        foreach ($admins as $admin) {
            $admin->kode_admin = User::generateKodeAdmin($admin->name, $admin->jenis_kelamin);
            $admin->save();
            $this->line("  [OK] {$admin->name} => {$admin->kode_admin}");
        }

        $this->info("Berhasil generate kode_admin untuk {$admins->count()} admin.");

        return 0;
    }
}
