<?php

namespace Database\Seeders;

use App\Models\StoreSetting;
use Illuminate\Database\Seeder;

class StoreSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $settings = [
            // General Store Info
            [
                'group' => 'general',
                'key' => 'store_name',
                'value' => 'Agrobig',
                'type' => 'string',
                'description' => 'Nombre público de la tienda virtual',
                'is_public' => true,
            ],
            [
                'group' => 'general',
                'key' => 'store_slogan',
                'value' => 'Tu agropecuaria de confianza',
                'type' => 'string',
                'description' => 'Eslogan o descripción corta de la tienda',
                'is_public' => true,
            ],
            [
                'group' => 'general',
                'key' => 'store_email',
                'value' => 'contacto@agrobig.com',
                'type' => 'string',
                'description' => 'Correo de contacto y atención al cliente',
                'is_public' => true,
            ],
            [
                'group' => 'general',
                'key' => 'store_phone',
                'value' => '+591 70000000',
                'type' => 'string',
                'description' => 'Teléfono o WhatsApp principal de atención',
                'is_public' => true,
            ],
            [
                'group' => 'general',
                'key' => 'store_address',
                'value' => 'Santa Cruz, Bolivia',
                'type' => 'string',
                'description' => 'Dirección física principal de la tienda',
                'is_public' => true,
            ],

            // Localization & Currency
            [
                'group' => 'localization',
                'key' => 'currency_code',
                'value' => 'BOB',
                'type' => 'string',
                'description' => 'Código de moneda ISO (BOB, USD, etc.)',
                'is_public' => true,
            ],
            [
                'group' => 'localization',
                'key' => 'currency_symbol',
                'value' => 'Bs.',
                'type' => 'string',
                'description' => 'Símbolo de la moneda para visualización',
                'is_public' => true,
            ],
            [
                'group' => 'localization',
                'key' => 'timezone',
                'value' => 'America/La_Paz',
                'type' => 'string',
                'description' => 'Zona horaria del negocio',
                'is_public' => false,
            ],

            // Sales & Checkout
            [
                'group' => 'sales',
                'key' => 'tax_enabled',
                'value' => '0',
                'type' => 'boolean',
                'description' => 'Indica si se aplica cálculo de impuestos/factura',
                'is_public' => true,
            ],
            [
                'group' => 'sales',
                'key' => 'tax_percentage',
                'value' => '13.0',
                'type' => 'float',
                'description' => 'Porcentaje de impuesto aplicable (IVA/Factura)',
                'is_public' => true,
            ],
            [
                'group' => 'sales',
                'key' => 'min_order_amount',
                'value' => '0.00',
                'type' => 'float',
                'description' => 'Monto mínimo para realizar un pedido',
                'is_public' => true,
            ],

            // Shipping
            [
                'group' => 'shipping',
                'key' => 'free_shipping_min_amount',
                'value' => '500.00',
                'type' => 'float',
                'description' => 'Monto mínimo para envíos gratuitos a domicilio',
                'is_public' => true,
            ],
            [
                'group' => 'shipping',
                'key' => 'default_shipping_fee',
                'value' => '25.00',
                'type' => 'float',
                'description' => 'Costo base o estándar de envío',
                'is_public' => true,
            ],

            // Social & Messaging
            [
                'group' => 'social',
                'key' => 'whatsapp_orders_number',
                'value' => '+591 70000000',
                'type' => 'string',
                'description' => 'Número de WhatsApp para coordinar pedidos directamente',
                'is_public' => true,
            ],
            [
                'group' => 'social',
                'key' => 'facebook_url',
                'value' => 'https://facebook.com/agrobig',
                'type' => 'string',
                'description' => 'Enlace a página oficial de Facebook',
                'is_public' => true,
            ],
        ];

        foreach ($settings as $setting) {
            StoreSetting::firstOrCreate(
                ['key' => $setting['key']],
                $setting
            );
        }
    }
}
