<?php

namespace Database\Seeders;

use App\Enums\PageStatus;
use App\Enums\PageTemplate;
use App\Models\Page;
use App\Models\User;
use Illuminate\Database\Seeder;

class PageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $adminId = User::where('role', 'admin')->value('id') ?? User::first()?->id;

        $pages = [
            [
                'author_id' => $adminId,
                'title' => 'Sobre Nosotros',
                'slug' => 'sobre-nosotros',
                'summary' => 'Conoce la historia, misión y el equipo detrás de Agrobig, tu aliado estratégico para el campo y la producción pecuaria.',
                'content' => '<h2>Nuestra Historia</h2>
<p>En Agrobig nacimos con el compromiso de potenciar el desarrollo productivo del sector agrícola y ganadero, facilitando insumos, herramientas y asesoramiento técnico de alta calidad directamente al productor.</p>
<h2>Misión y Visión</h2>
<p><strong>Misión:</strong> Brindar a nuestros clientes soluciones agropecuarias integrales, combinando productos de calidad garantizada, atención profesional y logística eficiente que maximicen el rendimiento de sus cultivos y hatos ganaderos.</p>
<p><strong>Visión:</strong> Ser el canal digital y físico líder en distribución agropecuaria a nivel nacional, reconocidos por la innovación, fiabilidad y compromiso con la productividad sustentable.</p>
<h2>Nuestros Valores</h2>
<ul>
    <li><strong>Compromiso con el productor:</strong> Su éxito productivo es el nuestro.</li>
    <li><strong>Calidad certificada:</strong> Solo trabajamos con marcas y laboratorios reconocidos.</li>
    <li><strong>Integridad y transparencia:</strong> En cada transacción, precio y recomendación técnica.</li>
</ul>',
                'template' => PageTemplate::ABOUT,
                'sections' => [
                    'highlights' => [
                        ['title' => 'Más de 10 años', 'description' => 'De trayectoria y experiencia en el sector agropecuario.'],
                        ['title' => '+5,000 Productores', 'description' => 'Atendidos con soluciones a medida en todo el país.'],
                        ['title' => 'Asesoría Certificada', 'description' => 'Equipo de agrónomos y médicos veterinarios dedicados.'],
                    ],
                ],
                'status' => PageStatus::PUBLISHED,
                'published_at' => now(),
                'order' => 1,
                'show_in_menu' => true,
                'show_in_footer' => true,
                'meta_title' => 'Sobre Nosotros | Agrobig - Pasión por el Campo',
                'meta_description' => 'Descubre la historia y misión de Agrobig. Líderes en insumos agrícolas, veterinarios y tecnología para el agro.',
                'meta_keywords' => 'agrobig, sobre nosotros, insumos agricolas, veterinaria campo',
                'is_indexable' => true,
            ],
            [
                'author_id' => $adminId,
                'title' => 'Nuestros Servicios',
                'slug' => 'servicios',
                'summary' => 'Descubre nuestros servicios de asesoramiento veterinario, diagnóstico agrícola, análisis de suelo y despacho logístico a campo.',
                'content' => '<h2>Soluciones Integrales para Productores</h2>
<p>En Agrobig no solo vendemos productos; brindamos respaldo técnico integral para que cada inversión en su propiedad genere el máximo retorno posible.</p>
<h2>¿Por qué elegir nuestros servicios?</h2>
<p>Contamos con profesionales altamente capacitados en sanidad animal, nutrición vegetal y protección de cultivos, equipados con herramientas modernas de diagnóstico y recomendaciones precisas.</p>',
                'template' => PageTemplate::SERVICES,
                'sections' => [
                    'services_list' => [
                        [
                            'icon' => 'truck',
                            'title' => 'Despacho y Logística a Campo',
                            'description' => 'Entregas programadas directamente en su finca, estancia o propiedad agrícola con cobertura regional.',
                        ],
                        [
                            'icon' => 'stethoscope',
                            'title' => 'Asesoría Veterinaria y Sanidad Animal',
                            'description' => 'Planes sanitarios, vacunación, suplementación estratégica y control de parásitos para bovinos, porcinos y equinos.',
                        ],
                        [
                            'icon' => 'sprout',
                            'title' => 'Asistencia Técnica Agronómica',
                            'description' => 'Monitoreo de plagas, manejo integrado de malezas y planes de fertilización foliar y edáfica.',
                        ],
                        [
                            'icon' => 'beaker',
                            'title' => 'Análisis de Semillas y Calidad de Agua',
                            'description' => 'Pruebas de viabilidad y compatibilidad para asegurar un arranque óptimo en sus parcelas.',
                        ],
                    ],
                ],
                'status' => PageStatus::PUBLISHED,
                'published_at' => now(),
                'order' => 2,
                'show_in_menu' => true,
                'show_in_footer' => true,
                'meta_title' => 'Servicios Agropecuarios Especializados | Agrobig',
                'meta_description' => 'Asesoría veterinaria, acompañamiento agronómico y logística especializada para productores agrícolas y ganaderos.',
                'meta_keywords' => 'servicios veterinarios, asesoria agronomica, logistica agropecuaria',
                'is_indexable' => true,
            ],
            [
                'author_id' => $adminId,
                'title' => 'Preguntas Frecuentes',
                'slug' => 'preguntas-frecuentes',
                'summary' => 'Respuestas a las dudas más comunes sobre compras en línea, envíos, métodos de pago y garantías de productos.',
                'content' => '<h2>Centro de Ayuda y Preguntas Frecuentes</h2>
<p>¿Tienes dudas sobre cómo realizar tu pedido o los tiempos de entrega? Aquí respondemos a las consultas más frecuentes de nuestros clientes.</p>',
                'template' => PageTemplate::FAQ,
                'sections' => [
                    'faqs' => [
                        [
                            'question' => '¿Cómo realizo una compra en Agrobig?',
                            'answer' => 'Navega por nuestro catálogo, añade los productos a tu carrito de compras y procede a finalizar la compra completando tus datos de entrega y método de pago preferido.',
                        ],
                        [
                            'question' => '¿Qué métodos de pago aceptan?',
                            'answer' => 'Aceptamos transferencias bancarias, pagos con código QR, tarjetas de débito/crédito y pago contra entrega en zonas autorizadas.',
                        ],
                        [
                            'question' => '¿Hacen envíos a zonas rurales y provincias?',
                            'answer' => 'Sí, coordinamos entregas tanto por transporte directo para cargas pesadas como por encomienda para pedidos medianos y pequeños.',
                        ],
                        [
                            'question' => '¿Los productos veterinarios requieren receta?',
                            'answer' => 'Determinados antibióticos y fármacos de control especial requieren prescripción médica veterinaria para su despacho.',
                        ],
                    ],
                ],
                'status' => PageStatus::PUBLISHED,
                'published_at' => now(),
                'order' => 3,
                'show_in_menu' => false,
                'show_in_footer' => true,
                'meta_title' => 'Preguntas Frecuentes | Agrobig',
                'meta_description' => 'Resuelve tus dudas sobre compras, envíos, pagos y garantías de productos en la tienda virtual de Agrobig.',
                'meta_keywords' => 'faq agrobig, dudas compras, envios campo, preguntas frecuentes',
                'is_indexable' => true,
            ],
            [
                'author_id' => $adminId,
                'title' => 'Términos y Condiciones',
                'slug' => 'terminos-y-condiciones',
                'summary' => 'Condiciones de uso, políticas de compra y responsabilidades de nuestra plataforma de comercio electrónico.',
                'content' => '<h2>1. Generalidades</h2>
<p>El uso de este sitio web y los servicios de Agrobig están sujetos a los presentes Términos y Condiciones. Al realizar un pedido a través de nuestra plataforma, el usuario acepta de manera expresa todas las cláusulas aquí descritas.</p>
<h2>2. Precios y Disponibilidad</h2>
<p>Los precios publicados están sujetos a cambio sin previo aviso debido a fluctuaciones del mercado. La confirmación del pedido garantiza el precio pactado al momento de su emisión.</p>
<h2>3. Garantías de Producto</h2>
<p>Todos nuestros productos cuentan con garantía directa de fábrica o laboratorio importador. En caso de defectos de fabricación o recipientes dañados en tránsito, se aplicará reposición inmediata según nuestras políticas de devolución.</p>',
                'template' => PageTemplate::LEGAL,
                'sections' => null,
                'status' => PageStatus::PUBLISHED,
                'published_at' => now(),
                'order' => 4,
                'show_in_menu' => false,
                'show_in_footer' => true,
                'meta_title' => 'Términos y Condiciones | Agrobig',
                'meta_description' => 'Consulta los términos legales y condiciones de compra en la tienda virtual de Agrobig.',
                'meta_keywords' => 'terminos y condiciones, politicas compra agrobig',
                'is_indexable' => true,
            ],
            [
                'author_id' => $adminId,
                'title' => 'Políticas de Privacidad',
                'slug' => 'politicas-de-privacidad',
                'summary' => 'Compromiso de protección de datos personales y seguridad de la información de nuestros clientes.',
                'content' => '<h2>Protección de sus Datos Personales</h2>
<p>En Agrobig respetamos su privacidad y protegemos la información personal que nos confía. Los datos recopilados (nombre, teléfono, correo electrónico, dirección) se utilizan exclusivamente para procesar pedidos, coordinar entregas y mejorar la experiencia de compra.</p>
<h2>Seguridad de la Información</h2>
<p>Implementamos estándares de seguridad para resguardar la confidencialidad de sus datos y no compartimos información con terceros no autorizados.</p>',
                'template' => PageTemplate::LEGAL,
                'sections' => null,
                'status' => PageStatus::PUBLISHED,
                'published_at' => now(),
                'order' => 5,
                'show_in_menu' => false,
                'show_in_footer' => true,
                'meta_title' => 'Políticas de Privacidad | Agrobig',
                'meta_description' => 'Conoce cómo protegemos y administramos tus datos personales en Agrobig.',
                'meta_keywords' => 'privacidad datos, politicas de privacidad agrobig',
                'is_indexable' => true,
            ],
            [
                'author_id' => $adminId,
                'title' => 'Envíos y Devoluciones',
                'slug' => 'envios-y-devoluciones',
                'summary' => 'Tiempos de despacho, zonas de cobertura y procedimiento para cambios o devoluciones.',
                'content' => '<h2>Políticas de Envío</h2>
<p>Realizamos despachos diarios para pedidos confirmados antes de las 12:00 PM. Los tiempos de entrega oscilan entre 24 y 48 horas según la ubicación de destino.</p>
<h2>Proceso de Cambios y Devoluciones</h2>
<p>Si el producto recibido presenta alguna anomalía o no corresponde a lo solicitado, cuentas con un plazo de 7 días hábiles para notificar al soporte y solicitar el cambio o reembolso correspondiente.</p>',
                'template' => PageTemplate::LEGAL,
                'sections' => null,
                'status' => PageStatus::PUBLISHED,
                'published_at' => now(),
                'order' => 6,
                'show_in_menu' => false,
                'show_in_footer' => true,
                'meta_title' => 'Envíos y Devoluciones | Agrobig',
                'meta_description' => 'Información sobre envíos, plazos de entrega y políticas de devolución en Agrobig.',
                'meta_keywords' => 'envios agrobig, entregas campo, devoluciones garantia',
                'is_indexable' => true,
            ],
        ];

        foreach ($pages as $pageData) {
            Page::updateOrCreate(
                ['slug' => $pageData['slug']],
                $pageData
            );
        }
    }
}
