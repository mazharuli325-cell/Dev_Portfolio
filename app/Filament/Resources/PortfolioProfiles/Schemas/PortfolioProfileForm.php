<?php

namespace App\Filament\Resources\PortfolioProfiles\Schemas;

use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Schema;

class PortfolioProfileForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Tabs::make('Portfolio content')
                    ->tabs([
                        Tab::make('SEO')
                            ->schema([
                                TextInput::make('seo_title')
                                    ->label('Page title')
                                    ->required()
                                    ->maxLength(255)
                                    ->columnSpanFull(),
                                Textarea::make('seo_description')
                                    ->label('Meta description')
                                    ->rows(3)
                                    ->columnSpanFull(),
                            ]),
                        Tab::make('Hero')
                            ->schema([
                                TextInput::make('brand')->required()->maxLength(255),
                                TextInput::make('name')->required()->maxLength(255),
                                TextInput::make('title')->required()->maxLength(255),
                                FileUpload::make('resume_path')
                                    ->label('Download resume')
                                    ->disk('public_assets')
                                    ->directory('assets')
                                    ->acceptedFileTypes([
                                        'application/pdf',
                                        'application/msword',
                                        'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                                        'text/plain',
                                    ])
                                    ->downloadable()
                                    ->openable()
                                    ->maxSize(5120)
                                    ->columnSpanFull(),
                                FileUpload::make('profile_image')
                                    ->label('Profile image')
                                    ->helperText('Upload any photo. It will be saved as a coder-style framed image automatically.')
                                    ->disk('public_assets')
                                    ->directory('assets')
                                    ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp'])
                                    ->image()
                                    ->imagePreviewHeight('160')
                                    ->maxSize(12288),
                                TextInput::make('whatsapp_url')
                                    ->label('WhatsApp chat URL')
                                    ->placeholder('https://wa.me/8801XXXXXXXXX')
                                    ->helperText('Use country code only, without + or spaces.')
                                    ->url()
                                    ->maxLength(255),
                                TextInput::make('terminal_role')->maxLength(255),
                                TextInput::make('terminal_stack')->maxLength(255),
                                Textarea::make('intro')->rows(4)->columnSpanFull(),
                                TagsInput::make('typing_messages')
                                    ->label('Typing messages')
                                    ->reorderable()
                                    ->columnSpanFull(),
                                TextInput::make('footer_quote')->maxLength(255)->columnSpanFull(),
                            ])
                            ->columns(2),
                        Tab::make('About')
                            ->schema([
                                TextInput::make('about_eyebrow')->label('Section label')->maxLength(255),
                                TextInput::make('about_heading')->label('Heading')->maxLength(255),
                                Repeater::make('about_paragraphs')
                                    ->label('Paragraphs')
                                    ->simple(Textarea::make('paragraph')->rows(3))
                                    ->reorderable()
                                    ->columnSpanFull(),
                                Repeater::make('about_stats')
                                    ->label('Stats')
                                    ->schema([
                                        TextInput::make('value')->required()->maxLength(50),
                                        TextInput::make('label')->required()->maxLength(255),
                                    ])
                                    ->itemLabel(fn (array $state): ?string => $state['label'] ?? null)
                                    ->reorderable()
                                    ->columns(2)
                                    ->columnSpanFull(),
                            ])
                            ->columns(2),
                        Tab::make('Skills')
                            ->schema([
                                TextInput::make('skills_eyebrow')->label('Section label')->maxLength(255),
                                TextInput::make('skills_heading')->label('Heading')->maxLength(255),
                                Repeater::make('skill_groups')
                                    ->label('Skill groups')
                                    ->schema([
                                        TextInput::make('title')->required()->maxLength(255),
                                        TagsInput::make('items')->label('Skills')->reorderable()->columnSpanFull(),
                                    ])
                                    ->itemLabel(fn (array $state): ?string => $state['title'] ?? null)
                                    ->reorderable()
                                    ->columnSpanFull(),
                            ])
                            ->columns(2),
                        Tab::make('Projects')
                            ->schema([
                                TextInput::make('projects_eyebrow')->label('Section label')->maxLength(255),
                                TextInput::make('projects_heading')->label('Heading')->maxLength(255),
                                Repeater::make('project_items')
                                    ->label('Projects')
                                    ->schema([
                                        TextInput::make('title')->required()->maxLength(255),
                                        TextInput::make('role')
                                            ->label('Role / ownership')
                                            ->placeholder('Founder')
                                            ->maxLength(255),
                                        FileUpload::make('image')
                                            ->label('Card image')
                                            ->disk('public_assets')
                                            ->directory('assets')
                                            ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp'])
                                            ->image()
                                            ->imagePreviewHeight('140')
                                            ->maxSize(12288),
                                        Textarea::make('description')->rows(3)->columnSpanFull(),
                                        TagsInput::make('stack')->reorderable()->columnSpanFull(),
                                        TextInput::make('highlight')->maxLength(255)->columnSpanFull(),
                                        TextInput::make('liveUrl')->label('Live demo URL')->maxLength(255),
                                        TextInput::make('githubUrl')->label('GitHub URL')->maxLength(255),
                                    ])
                                    ->itemLabel(fn (array $state): ?string => $state['title'] ?? null)
                                    ->reorderable()
                                    ->columns(2)
                                    ->columnSpanFull(),
                            ])
                            ->columns(2),
                        Tab::make('Experience')
                            ->schema([
                                TextInput::make('experience_eyebrow')->label('Section label')->maxLength(255),
                                TextInput::make('experience_heading')->label('Heading')->maxLength(255),
                                Repeater::make('experience_items')
                                    ->label('Experience')
                                    ->schema([
                                        TextInput::make('period')->required()->maxLength(255),
                                        TextInput::make('location')->maxLength(255),
                                        TextInput::make('role')->required()->maxLength(255),
                                        TextInput::make('company')->required()->maxLength(255),
                                        TagsInput::make('bullets')->reorderable()->columnSpanFull(),
                                        TagsInput::make('technologies')->reorderable()->columnSpanFull(),
                                    ])
                                    ->itemLabel(fn (array $state): ?string => $state['company'] ?? null)
                                    ->reorderable()
                                    ->columns(2)
                                    ->columnSpanFull(),
                            ])
                            ->columns(2),
                        Tab::make('Education')
                            ->schema([
                                TextInput::make('education_eyebrow')->label('Section label')->maxLength(255),
                                TextInput::make('education_heading')->label('Heading')->maxLength(255),
                                Repeater::make('education_items')
                                    ->label('Education')
                                    ->schema([
                                        TextInput::make('period')->required()->maxLength(255),
                                        TextInput::make('degree')->required()->maxLength(255),
                                        TextInput::make('institute')->required()->maxLength(255),
                                        Textarea::make('details')->rows(3)->columnSpanFull(),
                                    ])
                                    ->itemLabel(fn (array $state): ?string => $state['degree'] ?? null)
                                    ->reorderable()
                                    ->columns(2)
                                    ->columnSpanFull(),
                            ])
                            ->columns(2),
                        Tab::make('GitHub')
                            ->schema([
                                TextInput::make('github_eyebrow')->label('Section label')->maxLength(255),
                                TextInput::make('github_heading')->label('Heading')->maxLength(255),
                                Repeater::make('github_repos')
                                    ->label('Featured repositories')
                                    ->schema([
                                        TextInput::make('label')->required()->maxLength(255),
                                        TextInput::make('url')->required()->maxLength(255),
                                    ])
                                    ->itemLabel(fn (array $state): ?string => $state['label'] ?? null)
                                    ->reorderable()
                                    ->columns(2)
                                    ->columnSpanFull(),
                                Repeater::make('github_graph_levels')
                                    ->label('Graph levels')
                                    ->simple(
                                        TextInput::make('level')
                                            ->numeric()
                                            ->minValue(0)
                                            ->maxValue(4)
                                            ->required(),
                                    )
                                    ->helperText('Use values from 0 to 4. Each row is one contribution square.')
                                    ->reorderable()
                                    ->columnSpanFull(),
                            ])
                            ->columns(2),
                        Tab::make('Articles')
                            ->schema([
                                TextInput::make('articles_eyebrow')->label('Section label')->maxLength(255),
                                TextInput::make('articles_heading')->label('Heading')->maxLength(255),
                                Repeater::make('article_items')
                                    ->label('Articles')
                                    ->schema([
                                        TextInput::make('category')->required()->maxLength(255),
                                        TextInput::make('title')->required()->maxLength(255),
                                        Textarea::make('excerpt')->rows(3)->columnSpanFull(),
                                        TextInput::make('url')->required()->maxLength(255)->columnSpanFull(),
                                    ])
                                    ->itemLabel(fn (array $state): ?string => $state['title'] ?? null)
                                    ->reorderable()
                                    ->columns(2)
                                    ->columnSpanFull(),
                            ])
                            ->columns(2),
                        Tab::make('Contact')
                            ->schema([
                                Section::make('Contact section')
                                    ->schema([
                                        TextInput::make('contact_eyebrow')->label('Section label')->maxLength(255),
                                        TextInput::make('contact_heading')->label('Heading')->maxLength(255),
                                        TextInput::make('contact_email')->label('Email')->email()->maxLength(255),
                                    ])
                                    ->columns(2),
                                Repeater::make('contact_links')
                                    ->label('Social links')
                                    ->schema([
                                        TextInput::make('label')->required()->maxLength(255),
                                        TextInput::make('url')->required()->maxLength(255),
                                    ])
                                    ->itemLabel(fn (array $state): ?string => $state['label'] ?? null)
                                    ->reorderable()
                                    ->columns(2)
                                    ->columnSpanFull(),
                            ]),
                    ])
                    ->columnSpanFull(),
            ]);
    }
}
