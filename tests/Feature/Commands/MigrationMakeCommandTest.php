<?php

namespace Tests\Feature\Commands;

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

it(description: 'can generate new create migration')
    ->tap(function () {
        $tableName = Str::snake('CreateUsersTable');

        $fileName = now()->format('Y_m_d_his') . '_' . $tableName . '.php';

        $this->assertFalse(File::exists(base_path("database/migrations/$fileName")));

        Artisan::call(command: 'application:migration CreateUsersTable --create=users');

        $this->assertTrue(File::exists(base_path("database/migrations/$fileName")));

        $migrationFile = File::get(path: base_path("database/migrations/$fileName"));

        expect(value: Str::contains(haystack: $migrationFile, needles: ['{{ table_name }}']))->toBeFalse();

        unlink(base_path("database/migrations/$fileName"));
    })
    ->group(groups: 'commands');

it(description: 'can generate new table migration')
    ->tap(function () {
        $tableName = Str::snake('UpdateUsersTable');

        $fileName = now()->format('Y_m_d_his') . '_' . $tableName . '.php';

        $this->assertFalse(File::exists(base_path("database/migrations/$fileName")));

        Artisan::call(command: 'application:migration UpdateUsersTable --table=users');

        $this->assertTrue(File::exists(base_path("database/migrations/$fileName")));

        $migrationFile = File::get(path: base_path("database/migrations/$fileName"));

        expect(value: Str::contains(haystack: $migrationFile, needles: ['{{ table_name }}']))->toBeFalse();

        unlink(base_path("database/migrations/$fileName"));
    })
    ->group(groups: 'commands');

it(description: 'can generate new migration')
    ->tap(function () {
        $tableName = Str::snake('UserPost');

        $fileName = now()->format('Y_m_d_his') . '_' . $tableName . '.php';

        $this->assertFalse(File::exists(base_path("database/migrations/$fileName")));

        Artisan::call(command: 'application:migration UserPost');

        $this->assertTrue(File::exists(base_path("database/migrations/$fileName")));

        unlink(base_path("database/migrations/$fileName"));
    })
    ->group(groups: 'commands');