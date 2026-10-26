<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pages', function (Blueprint $table) {
            $table->id();

            // Author / Creator
            $table->foreignId('author_id')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            // Core Page Data
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('summary')->nullable();
            $table->longText('content')->nullable();

            // Template / Layout & Dynamic Sections
            $table->string('template', 50)->default('default')->index();
            $table->json('sections')->nullable(); // Structured modular blocks (services, team, FAQ, etc.)
            $table->json('gallery')->nullable(); // Optional collection of media/images

            // Media
            $table->string('featured_image')->nullable();

            // Status & Publishing Lifecycle
            $table->string('status', 20)->default('draft')->index(); // draft, published, archived
            $table->timestamp('published_at')->nullable()->index();

            // Navigation & Hierarchy
            $table->integer('order')->default(0)->index();
            $table->boolean('show_in_menu')->default(false)->index();
            $table->boolean('show_in_footer')->default(false)->index();

            // SEO & Social Open Graph
            $table->string('meta_title')->nullable();
            $table->string('meta_description', 500)->nullable();
            $table->string('meta_keywords')->nullable();
            $table->string('og_image')->nullable();
            $table->boolean('is_indexable')->default(true);

            // Audit & Recovery
            $table->softDeletes();
            $table->timestamps();

            // Composite performance indexes
            $table->index(['status', 'published_at', 'order']);
            $table->index(['show_in_menu', 'status', 'order']);
            $table->index(['show_in_footer', 'status', 'order']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pages');
    }
};
