<?php

namespace App\Enums;

enum UserRole: string
{
    case ADMIN = 'admin';
    case MANAGER = 'manager';
    case STAFF = 'staff';

    /**
     * Get the human-readable label for the role.
     */
    public function label(): string
    {
        return match ($this) {
            self::ADMIN => 'Administrador',
            self::MANAGER => 'Gerente de Tienda',
            self::STAFF => 'Personal / Vendedor',
        };
    }

    /**
     * Get the badge color for Filament / UI components.
     */
    public function color(): string
    {
        return match ($this) {
            self::ADMIN => 'danger',
            self::MANAGER => 'warning',
            self::STAFF => 'info',
        };
    }

    /**
     * Get all role values as an array.
     *
     * @return array<string>
     */
    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

    /**
     * Get all options as key-value pairs for selects.
     *
     * @return array<string, string>
     */
    public static function options(): array
    {
        $options = [];
        foreach (self::cases() as $case) {
            $options[$case->value] = $case->label();
        }

        return $options;
    }
}
