<?php

namespace SetCMS\Module\Migrations\Migration;

interface MigrationInterface
{

    public function up(): void;

    public function down(): void;
}
