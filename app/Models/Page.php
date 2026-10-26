<?php

namespace App\Models;

use App\Enums\PageStatus;
use App\Enums\PageTemplate;
use Database\Factories\PageFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

#[Fillable([
    'author_id',
    'title',
    'slug',
    'summary',
    'content',
    'template',
    'sections',
    'gallery',
    'featured_image',
    'status',
    'published_at',
    'order',
    'show_in_menu',
    'show_in_footer',
    'meta_title',
    'meta_description',
    'meta_keywords',
    'og_image',
    'is_indexable',
])]
class Page extends Model
{
    /** @use HasFactory<PageFactory> */
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'author_id',
        'title',
        'slug',
        'summary',
        'content',
        'template',
        'sections',
        'gallery',
        'featured_image',
        'status',
        'published_at',
        'order',
        'show_in_menu',
        'show_in_footer',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'og_image',
        'is_indexable',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var list<string>
     */
    protected $appends = [
        'reading_time',
        'seo_title',
        'seo_description',
        'og_image_url',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'status' => PageStatus::class,
            'template' => PageTemplate::class,
            'sections' => 'array',
            'gallery' => 'array',
            'order' => 'integer',
            'show_in_menu' => 'boolean',
            'show_in_footer' => 'boolean',
            'is_indexable' => 'boolean',
            'published_at' => 'datetime',
        ];
    }

    /**
     * Model bootstrap lifecycle events.
     */
    protected static function booted(): void
    {
        static::creating(function (self $page) {
            if (empty($page->slug) && ! empty($page->title)) {
                $page->slug = static::generateUniqueSlug($page->title);
            }

            if ($page->status === PageStatus::PUBLISHED && empty($page->published_at)) {
                $page->published_at = now();
            }
        });

        static::updating(function (self $page) {
            if ($page->isDirty('title') && empty($page->slug)) {
                $page->slug = static::generateUniqueSlug($page->title, $page->id);
            }

            if ($page->isDirty('status') && $page->status === PageStatus::PUBLISHED && empty($page->published_at)) {
                $page->published_at = now();
            }
        });
    }

    /**
     * Generate a unique slug for the page.
     */
    public static function generateUniqueSlug(string $title, ?int $ignoreId = null): string
    {
        $baseSlug = Str::slug($title);
        $slug = $baseSlug;
        $counter = 1;

        while (static::where('slug', $slug)->when($ignoreId, fn ($q) => $q->where('id', '!=', $ignoreId))->exists()) {
            $slug = "{$baseSlug}-{$counter}";
            $counter++;
        }

        return $slug;
    }

    /**
     * Get the route key for the model (uses slug for clean URLs).
     */
    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    /**
     * User/Author who created or owns the page.
     */
    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    /*
    |--------------------------------------------------------------------------
    | Scopes
    |--------------------------------------------------------------------------
    */

    /**
     * Scope query to only published pages that are past their publication date.
     */
    public function scopePublished(Builder $query): Builder
    {
        return $query->where('status', PageStatus::PUBLISHED)
            ->where(function (Builder $q) {
                $q->whereNull('published_at')
                    ->orWhere('published_at', '<=', now());
            });
    }

    /**
     * Scope query to only draft pages.
     */
    public function scopeDraft(Builder $query): Builder
    {
        return $query->where('status', PageStatus::DRAFT);
    }

    /**
     * Scope query to only archived pages.
     */
    public function scopeArchived(Builder $query): Builder
    {
        return $query->where('status', PageStatus::ARCHIVED);
    }

    /**
     * Scope query for pages visible in the main navigation menu.
     */
    public function scopeInMenu(Builder $query): Builder
    {
        return $query->published()
            ->where('show_in_menu', true)
            ->orderBy('order', 'asc');
    }

    /**
     * Scope query for pages visible in the footer.
     */
    public function scopeInFooter(Builder $query): Builder
    {
        return $query->published()
            ->where('show_in_footer', true)
            ->orderBy('order', 'asc');
    }

    /**
     * Scope query to filter by template.
     */
    public function scopeTemplate(Builder $query, PageTemplate|string $template): Builder
    {
        $value = $template instanceof PageTemplate ? $template->value : $template;

        return $query->where('template', $value);
    }

    /**
     * Scope query ordered by custom sort order.
     */
    public function scopeOrdered(Builder $query, string $direction = 'asc'): Builder
    {
        return $query->orderBy('order', $direction)->orderBy('title', 'asc');
    }

    /**
     * Scope query for search in title, summary and content.
     */
    public function scopeSearch(Builder $query, string $term): Builder
    {
        return $query->where(function (Builder $q) use ($term) {
            $q->where('title', 'like', "%{$term}%")
                ->orWhere('summary', 'like', "%{$term}%")
                ->orWhere('content', 'like', "%{$term}%");
        });
    }

    /*
    |--------------------------------------------------------------------------
    | Accessors & Mutators
    |--------------------------------------------------------------------------
    */

    /**
     * Check if the page is currently active/published.
     */
    public function isPublished(): bool
    {
        return $this->status === PageStatus::PUBLISHED
            && ($this->published_at === null || $this->published_at->isPast());
    }

    /**
     * Estimate reading time in minutes (based on 200 words per minute).
     */
    public function getReadingTimeAttribute(): int
    {
        $text = strip_tags(($this->content ?? '').' '.($this->summary ?? ''));
        $words = str_word_count($text);

        return max(1, (int) ceil($words / 200));
    }

    /**
     * Get resolved SEO meta title.
     */
    public function getSeoTitleAttribute(): string
    {
        return ! empty($this->meta_title) ? $this->meta_title : ($this->title ?? '');
    }

    /**
     * Get resolved SEO meta description.
     */
    public function getSeoDescriptionAttribute(): string
    {
        if (! empty($this->meta_description)) {
            return $this->meta_description;
        }

        $source = ! empty($this->summary) ? $this->summary : ($this->content ?? '');

        return Str::limit(trim(preg_replace('/\s+/', ' ', strip_tags($source))), 160);
    }

    /**
     * Get resolved Open Graph social image URL.
     */
    public function getOgImageUrlAttribute(): ?string
    {
        return $this->og_image ?: $this->featured_image;
    }
}
