<?php

namespace App\Models;

use App\Support\CoderProfileImage;
use Illuminate\Database\Eloquent\Model;

class PortfolioProfile extends Model
{
    protected $guarded = [];

    protected static function booted(): void
    {
        static::saving(function (PortfolioProfile $profile): void {
            if (! $profile->isDirty('profile_image')) {
                return;
            }

            $profileImage = self::uploadedFilePath($profile->profile_image);

            if (blank($profileImage)) {
                $profile->profile_image = $profile->getOriginal('profile_image')
                    ?: data_get(self::defaultAttributes(), 'profile_image');

                return;
            }

            $profile->profile_image = CoderProfileImage::frame($profileImage);
        });
    }

    protected function casts(): array
    {
        return [
            'typing_messages' => 'array',
            'about_paragraphs' => 'array',
            'about_stats' => 'array',
            'skill_groups' => 'array',
            'project_items' => 'array',
            'experience_items' => 'array',
            'education_items' => 'array',
            'github_repos' => 'array',
            'github_graph_levels' => 'array',
            'article_items' => 'array',
            'contact_links' => 'array',
        ];
    }

    public static function defaultAttributes(): array
    {
        $data = config('portfolio');

        return [
            'seo_title' => data_get($data, 'seo.title'),
            'seo_description' => data_get($data, 'seo.description'),
            'brand' => data_get($data, 'profile.brand'),
            'name' => data_get($data, 'profile.name'),
            'title' => data_get($data, 'profile.title'),
            'intro' => data_get($data, 'profile.intro'),
            'resume_path' => data_get($data, 'profile.resumePath'),
            'profile_image' => data_get($data, 'profile.profileImage'),
            'terminal_role' => data_get($data, 'profile.terminalRole'),
            'terminal_stack' => data_get($data, 'profile.terminalStack'),
            'typing_messages' => data_get($data, 'profile.typingMessages', []),
            'whatsapp_url' => data_get($data, 'profile.whatsappUrl'),
            'footer_quote' => data_get($data, 'profile.footerQuote'),
            'about_eyebrow' => data_get($data, 'about.eyebrow'),
            'about_heading' => data_get($data, 'about.heading'),
            'about_paragraphs' => data_get($data, 'about.paragraphs', []),
            'about_stats' => data_get($data, 'about.stats', []),
            'skills_eyebrow' => data_get($data, 'skills.eyebrow'),
            'skills_heading' => data_get($data, 'skills.heading'),
            'skill_groups' => data_get($data, 'skills.groups', []),
            'projects_eyebrow' => data_get($data, 'projects.eyebrow'),
            'projects_heading' => data_get($data, 'projects.heading'),
            'project_items' => data_get($data, 'projects.items', []),
            'experience_eyebrow' => data_get($data, 'experience.eyebrow'),
            'experience_heading' => data_get($data, 'experience.heading'),
            'experience_items' => data_get($data, 'experience.items', []),
            'education_eyebrow' => data_get($data, 'education.eyebrow'),
            'education_heading' => data_get($data, 'education.heading'),
            'education_items' => data_get($data, 'education.items', []),
            'github_eyebrow' => data_get($data, 'github.eyebrow'),
            'github_heading' => data_get($data, 'github.heading'),
            'github_repos' => data_get($data, 'github.repos', []),
            'github_graph_levels' => data_get($data, 'github.graphLevels', []),
            'articles_eyebrow' => data_get($data, 'articles.eyebrow'),
            'articles_heading' => data_get($data, 'articles.heading'),
            'article_items' => data_get($data, 'articles.items', []),
            'contact_eyebrow' => data_get($data, 'contact.eyebrow'),
            'contact_heading' => data_get($data, 'contact.heading'),
            'contact_email' => data_get($data, 'contact.email'),
            'contact_links' => data_get($data, 'contact.links', []),
        ];
    }

    public function toPortfolioData(): array
    {
        return [
            'seo' => [
                'title' => $this->seo_title,
                'description' => $this->seo_description,
            ],
            'profile' => [
                'brand' => $this->brand,
                'name' => $this->name,
                'title' => $this->title,
                'intro' => $this->intro,
                'resumePath' => $this->resume_path,
                'profileImage' => $this->profile_image ?: data_get(self::defaultAttributes(), 'profile_image'),
                'terminalRole' => $this->terminal_role,
                'terminalStack' => $this->terminal_stack,
                'typingMessages' => $this->stringList($this->typing_messages),
                'whatsappUrl' => $this->whatsapp_url,
                'footerQuote' => $this->footer_quote,
            ],
            'about' => [
                'eyebrow' => $this->about_eyebrow,
                'heading' => $this->about_heading,
                'paragraphs' => $this->stringList($this->about_paragraphs),
                'stats' => $this->about_stats ?? [],
            ],
            'skills' => [
                'eyebrow' => $this->skills_eyebrow,
                'heading' => $this->skills_heading,
                'groups' => $this->skill_groups ?? [],
            ],
            'projects' => [
                'eyebrow' => $this->projects_eyebrow,
                'heading' => $this->projects_heading,
                'items' => $this->project_items ?? [],
            ],
            'experience' => [
                'eyebrow' => $this->experience_eyebrow,
                'heading' => $this->experience_heading,
                'items' => $this->experience_items ?? [],
            ],
            'education' => [
                'eyebrow' => $this->education_eyebrow,
                'heading' => $this->education_heading,
                'items' => $this->education_items ?? [],
            ],
            'github' => [
                'eyebrow' => $this->github_eyebrow,
                'heading' => $this->github_heading,
                'repos' => $this->github_repos ?? [],
                'graphLevels' => $this->github_graph_levels ?? [],
            ],
            'articles' => [
                'eyebrow' => $this->articles_eyebrow,
                'heading' => $this->articles_heading,
                'items' => $this->article_items ?? [],
            ],
            'contact' => [
                'eyebrow' => $this->contact_eyebrow,
                'heading' => $this->contact_heading,
                'email' => $this->contact_email,
                'links' => $this->contact_links ?? [],
            ],
        ];
    }

    private function stringList(mixed $items): array
    {
        if (! is_array($items)) {
            return [];
        }

        return array_values(array_filter(array_map(
            fn (mixed $item): ?string => is_scalar($item) ? trim((string) $item) : null,
            $items,
        ), fn (?string $item): bool => filled($item)));
    }

    private static function uploadedFilePath(mixed $value): ?string
    {
        if (is_string($value)) {
            return $value;
        }

        if (is_array($value)) {
            $firstValue = reset($value);

            return is_string($firstValue) ? $firstValue : null;
        }

        return is_scalar($value) ? (string) $value : null;
    }
}
