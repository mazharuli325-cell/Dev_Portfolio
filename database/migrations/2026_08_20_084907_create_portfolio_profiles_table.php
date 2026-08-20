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
        Schema::create('portfolio_profiles', function (Blueprint $table) {
            $table->id();
            $table->string('seo_title');
            $table->text('seo_description')->nullable();
            $table->string('brand');
            $table->string('name');
            $table->string('title');
            $table->text('intro')->nullable();
            $table->string('resume_path')->nullable();
            $table->string('profile_image')->nullable();
            $table->string('terminal_role')->nullable();
            $table->string('terminal_stack')->nullable();
            $table->json('typing_messages')->nullable();
            $table->string('footer_quote')->nullable();
            $table->string('about_eyebrow')->nullable();
            $table->string('about_heading')->nullable();
            $table->json('about_paragraphs')->nullable();
            $table->json('about_stats')->nullable();
            $table->string('skills_eyebrow')->nullable();
            $table->string('skills_heading')->nullable();
            $table->json('skill_groups')->nullable();
            $table->string('projects_eyebrow')->nullable();
            $table->string('projects_heading')->nullable();
            $table->json('project_items')->nullable();
            $table->string('experience_eyebrow')->nullable();
            $table->string('experience_heading')->nullable();
            $table->json('experience_items')->nullable();
            $table->string('education_eyebrow')->nullable();
            $table->string('education_heading')->nullable();
            $table->json('education_items')->nullable();
            $table->string('github_eyebrow')->nullable();
            $table->string('github_heading')->nullable();
            $table->json('github_repos')->nullable();
            $table->json('github_graph_levels')->nullable();
            $table->string('articles_eyebrow')->nullable();
            $table->string('articles_heading')->nullable();
            $table->json('article_items')->nullable();
            $table->string('contact_eyebrow')->nullable();
            $table->string('contact_heading')->nullable();
            $table->string('contact_email')->nullable();
            $table->json('contact_links')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('portfolio_profiles');
    }
};
