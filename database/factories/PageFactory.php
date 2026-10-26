<?php

namespace Database\Factories;

use App\Enums\PageStatus;
use App\Enums\PageTemplate;
use App\Models\Page;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Page>
 */
class PageFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var class-string<Page>
     */
    protected $model = Page::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $title = fake()->unique()->sentence(3);

        return [
            'author_id' => User::factory(),
            'title' => rtrim($title, '.'),
            'slug' => Str::slug($title),
            'summary' => fake()->paragraph(2),
            'content' => '<p>'.implode('</p><p>', fake()->paragraphs(4)).'</p>',
            'template' => PageTemplate::DEFAULT,
            'sections' => null,
            'gallery' => null,
            'featured_image' => null,
            'status' => PageStatus::PUBLISHED,
            'published_at' => now(),
            'order' => fake()->numberBetween(0, 10),
            'show_in_menu' => fake()->boolean(40),
            'show_in_footer' => fake()->boolean(60),
            'meta_title' => null,
            'meta_description' => null,
            'meta_keywords' => 'agropecuaria, bolivia, productos agricolas',
            'og_image' => null,
            'is_indexable' => true,
        ];
    }

    /**
     * Indicate that the page is published.
     */
    public function published(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => PageStatus::PUBLISHED,
            'published_at' => now()->subDay(),
        ]);
    }

    /**
     * Indicate that the page is a draft.
     */
    public function draft(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => PageStatus::DRAFT,
            'published_at' => null,
        ]);
    }

    /**
     * Indicate that the page is archived.
     */
    public function archived(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => PageStatus::ARCHIVED,
        ]);
    }

    /**
     * Indicate that the page appears in the main menu.
     */
    public function inMenu(): static
    {
        return $this->state(fn (array $attributes) => [
            'show_in_menu' => true,
            'status' => PageStatus::PUBLISHED,
        ]);
    }

    /**
     * Indicate that the page appears in the footer.
     */
    public function inFooter(): static
    {
        return $this->state(fn (array $attributes) => [
            'show_in_footer' => true,
            'status' => PageStatus::PUBLISHED,
        ]);
    }

    /**
     * About Us template state.
     */
    public function about(): static
    {
        return $this->state(fn (array $attributes) => [
            'title' => 'Sobre Nosotros',
            'slug' => 'sobre-nosotros',
            'template' => PageTemplate::ABOUT,
            'show_in_menu' => true,
            'show_in_footer' => true,
        ]);
    }

    /**
     * Services template state.
     */
    public function services(): static
    {
        return $this->state(fn (array $attributes) => [
            'title' => 'Nuestros Servicios',
            'slug' => 'servicios',
            'template' => PageTemplate::SERVICES,
            'show_in_menu' => true,
            'show_in_footer' => true,
        ]);
    }
}
