<?php

namespace Tests\Feature;

use App\Enums\PageStatus;
use App\Enums\PageTemplate;
use App\Models\Page;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PageModelTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_create_page_with_factory(): void
    {
        $page = Page::factory()->create([
            'title' => 'Nuestros Servicios Agrícolas',
            'slug' => 'nuestros-servicios-agricolas',
            'template' => PageTemplate::SERVICES,
            'status' => PageStatus::PUBLISHED,
        ]);

        $this->assertDatabaseHas('pages', [
            'id' => $page->id,
            'slug' => 'nuestros-servicios-agricolas',
            'template' => PageTemplate::SERVICES->value,
            'status' => PageStatus::PUBLISHED->value,
        ]);

        $this->assertInstanceOf(PageStatus::class, $page->status);
        $this->assertInstanceOf(PageTemplate::class, $page->template);
        $this->assertTrue($page->isPublished());
    }

    public function test_automatically_generates_unique_slug_from_title(): void
    {
        $page1 = Page::factory()->create([
            'title' => 'Sobre Nosotros',
            'slug' => null,
        ]);

        $this->assertEquals('sobre-nosotros', $page1->slug);

        $page2 = Page::factory()->create([
            'title' => 'Sobre Nosotros',
            'slug' => null,
        ]);

        $this->assertEquals('sobre-nosotros-1', $page2->slug);
    }

    public function test_published_scope_only_returns_active_pages(): void
    {
        Page::factory()->create([
            'title' => 'Borrador',
            'status' => PageStatus::DRAFT,
        ]);

        Page::factory()->create([
            'title' => 'Archivado',
            'status' => PageStatus::ARCHIVED,
        ]);

        Page::factory()->create([
            'title' => 'Programado Futuro',
            'status' => PageStatus::PUBLISHED,
            'published_at' => now()->addDays(5),
        ]);

        Page::factory()->create([
            'title' => 'Publicado Ahora',
            'status' => PageStatus::PUBLISHED,
            'published_at' => now()->subDay(),
        ]);

        $publishedPages = Page::published()->get();

        $this->assertCount(1, $publishedPages);
        $this->assertEquals('Publicado Ahora', $publishedPages->first()->title);
    }

    public function test_menu_and_footer_scopes(): void
    {
        Page::factory()->create([
            'title' => 'En Menu',
            'status' => PageStatus::PUBLISHED,
            'show_in_menu' => true,
            'show_in_footer' => false,
            'order' => 1,
        ]);

        Page::factory()->create([
            'title' => 'En Footer',
            'status' => PageStatus::PUBLISHED,
            'show_in_menu' => false,
            'show_in_footer' => true,
            'order' => 2,
        ]);

        $this->assertCount(1, Page::inMenu()->get());
        $this->assertEquals('En Menu', Page::inMenu()->first()->title);

        $this->assertCount(1, Page::inFooter()->get());
        $this->assertEquals('En Footer', Page::inFooter()->first()->title);
    }

    public function test_seo_and_reading_time_accessors(): void
    {
        $page = Page::factory()->create([
            'title' => 'Preguntas y Respuestas',
            'summary' => 'Breve resumen de ayuda para clientes del campo.',
            'content' => '<p>'.str_repeat('palabra ', 450).'</p>',
            'meta_title' => null,
            'meta_description' => null,
        ]);

        // Fallback meta title should match title
        $this->assertEquals('Preguntas y Respuestas', $page->seo_title);

        // Fallback meta description should strip tags from summary
        $this->assertStringContainsString('Breve resumen de ayuda', $page->seo_description);

        // 450 words / 200 = ~3 minutes reading time
        $this->assertGreaterThanOrEqual(2, $page->reading_time);
    }

    public function test_soft_deletes_functionality(): void
    {
        $page = Page::factory()->create([
            'title' => 'Página para eliminar',
        ]);

        $page->delete();

        $this->assertSoftDeleted('pages', ['id' => $page->id]);
        $this->assertNull(Page::find($page->id));
        $this->assertNotNull(Page::withTrashed()->find($page->id));
    }
}
