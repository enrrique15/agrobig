<?php

namespace App\Enums;

enum PageTemplate: string
{
    case DEFAULT = 'default';
    case ABOUT = 'about';
    case SERVICES = 'services';
    case CONTACT = 'contact';
    case FAQ = 'faq';
    case LEGAL = 'legal';

    /**
     * Get the human-readable label for the template.
     */
    public function label(): string
    {
        return match ($this) {
            self::DEFAULT => 'Estándar',
            self::ABOUT => 'Sobre Nosotros',
            self::SERVICES => 'Servicios',
            self::CONTACT => 'Contacto',
            self::FAQ => 'Preguntas Frecuentes',
            self::LEGAL => 'Legal / Términos y Políticas',
        };
    }

    /**
     * Get all template values as an array.
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
