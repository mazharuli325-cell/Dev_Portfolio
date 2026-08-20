@php
    $seo = $portfolio['seo'] ?? [];
    $profile = $portfolio['profile'] ?? [];
    $about = $portfolio['about'] ?? [];
    $skills = $portfolio['skills'] ?? [];
    $projects = $portfolio['projects'] ?? [];
    $experience = $portfolio['experience'] ?? [];
    $education = $portfolio['education'] ?? [];
    $github = $portfolio['github'] ?? [];
    $articles = $portfolio['articles'] ?? [];
    $contact = $portfolio['contact'] ?? [];

    $assetPath = function (?string $path): string {
        if (blank($path)) {
            return '#';
        }

        if (preg_match('#^(https?:)?//#', $path) || str_starts_with($path, '/')) {
            return $path;
        }

        if (str_starts_with($path, 'assets/') || str_starts_with($path, 'storage/')) {
            return asset($path);
        }

        return asset('storage/' . $path);
    };
@endphp

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="description" content="{{ $seo['description'] ?? '' }}" />
    <title>{{ $seo['title'] ?? config('app.name') }}</title>
    <link rel="icon" href="{{ asset('favicon.ico') }}?v={{ filemtime(public_path('favicon.ico')) }}" sizes="any" />
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}?v={{ filemtime(public_path('favicon.png')) }}" />
    <link rel="stylesheet" href="{{ asset('css/portfolio.css') }}?v={{ filemtime(public_path('css/portfolio.css')) }}" />
  </head>
  <body>
    <div class="site-shell">
      <header class="site-header" data-reveal>
        <a class="brand" href="#home" aria-label="Go to home">
          <span class="brand__prompt">~/</span><span>{{ $profile['brand'] ?? '' }}</span>
        </a>
        <nav class="site-nav" aria-label="Primary navigation">
          <a href="#about">About</a>
          <a href="#skills">Skills</a>
          <a href="#projects">Projects</a>
          <a href="#experience">Experience</a>
          <a href="#contact">Contact</a>
        </nav>
      </header>

      <main>
        <section class="hero section" id="home">
          <div class="hero__content" data-reveal>
            <p class="eyebrow">console.log("hello_world")</p>
            <h1>{{ $profile['name'] ?? '' }}</h1>
            <p class="hero__title">{{ $profile['title'] ?? '' }}</p>
            <p class="hero__intro">{{ $profile['intro'] ?? '' }}</p>
            <div class="hero__actions" aria-label="Primary actions">
              <a class="button button--primary" href="#projects">View Projects</a>
              @if (! blank($profile['resumePath'] ?? null))
                <a class="button" href="{{ $assetPath($profile['resumePath']) }}" download>Download Resume</a>
              @endif
              @if (! blank($profile['whatsappUrl'] ?? null))
                <a class="button button--whatsapp" href="{{ $profile['whatsappUrl'] }}" target="_blank" rel="noopener noreferrer" aria-label="Chat on WhatsApp">
                  <svg viewBox="0 0 32 32" aria-hidden="true" focusable="false">
                    <path d="M16.04 3.2A12.74 12.74 0 0 0 5.17 22.58L3.84 28.8l6.36-1.44A12.72 12.72 0 1 0 16.04 3.2Zm0 22.98c-2.07 0-4-.61-5.63-1.66l-.4-.25-3.78.86.8-3.7-.27-.43a10.29 10.29 0 1 1 9.28 5.18Zm5.65-7.7c-.31-.15-1.83-.9-2.12-1-.28-.1-.49-.15-.7.15-.2.31-.8 1-.98 1.2-.18.2-.36.23-.67.08-.31-.16-1.3-.48-2.48-1.53a9.3 9.3 0 0 1-1.72-2.14c-.18-.31-.02-.48.14-.63.14-.14.31-.36.46-.54.16-.18.2-.31.31-.52.1-.2.05-.38-.03-.54-.08-.15-.7-1.68-.95-2.3-.25-.6-.5-.52-.7-.53h-.6c-.2 0-.54.08-.82.38-.28.31-1.08 1.06-1.08 2.58 0 1.51 1.1 2.98 1.26 3.18.15.2 2.18 3.32 5.28 4.66.74.32 1.31.51 1.76.65.74.23 1.41.2 1.94.12.59-.09 1.83-.75 2.09-1.47.25-.72.25-1.34.18-1.47-.08-.13-.28-.2-.59-.35Z" />
                  </svg>
                  WhatsApp
                </a>
              @endif
            </div>
          </div>

          <div class="terminal hero-terminal" data-reveal>
            <div class="terminal__bar">
              <span></span>
              <span></span>
              <span></span>
            </div>
            <div class="terminal__body">
              <p><span class="prompt">$</span> whoami</p>
              <p class="terminal__output">{{ $profile['terminalRole'] ?? '' }}</p>
              <p><span class="prompt">$</span> stack --focus</p>
              <p class="terminal__output">{{ $profile['terminalStack'] ?? '' }}</p>
              <p><span class="prompt">$</span> current_task</p>
              <p class="terminal__output">
                <span id="typed-line">{{ $profile['typingMessages'][0] ?? 'shipping thoughtful web experiences' }}</span><span class="cursor" aria-hidden="true"></span>
              </p>
            </div>
          </div>
        </section>

        <section class="section about" id="about">
          <div class="section-heading" data-reveal>
            <p class="eyebrow">{{ $about['eyebrow'] ?? '' }}</p>
            <h2>{{ $about['heading'] ?? '' }}</h2>
          </div>
          <div class="about__grid">
            <div class="about__media about-code-portrait" data-reveal>
              <div class="code-orbit" aria-hidden="true">
                <span class="code-chip code-chip--top">$ php artisan make:feature</span>
                <span class="code-chip code-chip--right">const developer = true;</span>
                <span class="code-chip code-chip--bottom">SELECT * FROM projects;</span>
                <span class="code-chip code-chip--left">npm run build</span>
              </div>
              <div class="orbit-dots" aria-hidden="true">
                <span></span>
                <span></span>
                <span></span>
              </div>
              <div class="code-scan" aria-hidden="true"></div>
              <div class="code-ring" aria-hidden="true"></div>
              <div class="profile-avatar">
                <img
                  src="{{ $assetPath($profile['profileImage'] ?? null) }}"
                  alt="{{ $profile['name'] ?? 'Developer' }} profile image"
                  width="520"
                  height="520"
                />
              </div>
            </div>
            <div class="about__copy" data-reveal>
              @foreach (($about['paragraphs'] ?? []) as $paragraph)
                <p>{{ $paragraph }}</p>
              @endforeach
              <div class="about__facts" aria-label="Developer facts">
                @foreach (($about['stats'] ?? []) as $stat)
                  <div>
                    <span>{{ $stat['value'] ?? '' }}</span>
                    <p>{{ $stat['label'] ?? '' }}</p>
                  </div>
                @endforeach
              </div>
            </div>
          </div>
        </section>

        <section class="section skills" id="skills">
          <div class="section-heading" data-reveal>
            <p class="eyebrow">{{ $skills['eyebrow'] ?? '' }}</p>
            <h2>{{ $skills['heading'] ?? '' }}</h2>
          </div>
          <div class="skills__terminal terminal" data-reveal>
            <div class="terminal__bar">
              <span></span>
              <span></span>
              <span></span>
            </div>
            <div class="skills__grid">
              @foreach (($skills['groups'] ?? []) as $group)
                <article class="skill-panel">
                  <h3>{{ $group['title'] ?? '' }}</h3>
                  <div class="skill-tags">
                    @foreach (($group['items'] ?? []) as $item)
                      <span>{{ $item }}</span>
                    @endforeach
                  </div>
                </article>
              @endforeach
            </div>
          </div>
        </section>

        <section class="section projects" id="projects">
          <div class="section-heading" data-reveal>
            <p class="eyebrow">{{ $projects['eyebrow'] ?? '' }}</p>
            <h2>{{ $projects['heading'] ?? '' }}</h2>
          </div>
          <div class="projects__grid">
            @foreach (($projects['items'] ?? []) as $project)
              <article class="project-card" data-reveal>
                @if (! blank($project['image'] ?? null))
                  <img
                    src="{{ $assetPath($project['image']) }}"
                    alt="{{ $project['title'] ?? 'Project' }} preview"
                    width="1200"
                    height="720"
                  />
                @endif
                <div class="project-card__body">
                  <h3>{{ $project['title'] ?? '' }}</h3>
                  @if (! blank($project['role'] ?? null))
                    <p class="project-card__meta">{{ $project['role'] }}</p>
                  @endif
                  <p>{{ $project['description'] ?? '' }}</p>
                  @if (! empty($project['stack'] ?? []))
                    <div class="stack">
                      @foreach ($project['stack'] as $item)
                        <span>{{ $item }}</span>
                      @endforeach
                    </div>
                  @endif
                  @if (! blank($project['highlight'] ?? null))
                    <p class="highlight">{{ $project['highlight'] }}</p>
                  @endif
                  <div class="project-links">
                    @if (! blank($project['liveUrl'] ?? null))
                      <a href="{{ $project['liveUrl'] }}" aria-label="Open {{ $project['title'] ?? 'project' }} live demo">Live Demo</a>
                    @endif
                    @if (! blank($project['githubUrl'] ?? null))
                      <a href="{{ $project['githubUrl'] }}" aria-label="Open {{ $project['title'] ?? 'project' }} GitHub repository">GitHub</a>
                    @endif
                  </div>
                </div>
              </article>
            @endforeach
          </div>
        </section>

        <section class="section timeline-section" id="experience">
          <div class="section-heading" data-reveal>
            <p class="eyebrow">{{ $experience['eyebrow'] ?? '' }}</p>
            <h2>{{ $experience['heading'] ?? '' }}</h2>
          </div>
          <div class="timeline">
            @foreach (($experience['items'] ?? []) as $item)
              <article class="timeline-item" data-reveal>
                <p class="timeline-item__meta">{{ $item['period'] ?? '' }}@if (! blank($item['location'] ?? null)) / {{ $item['location'] }}@endif</p>
                <h3>{{ $item['role'] ?? '' }}@if (! blank($item['company'] ?? null)), {{ $item['company'] }}@endif</h3>
                <ul>
                  @foreach (($item['bullets'] ?? []) as $bullet)
                    <li>{{ $bullet }}</li>
                  @endforeach
                </ul>
                @if (! empty($item['technologies'] ?? []))
                  <div class="stack stack--timeline">
                    @foreach ($item['technologies'] as $technology)
                      <span>{{ $technology }}</span>
                    @endforeach
                  </div>
                @endif
              </article>
            @endforeach
          </div>
        </section>

        <section class="section education-github">
          <div class="education" data-reveal>
            <div class="section-heading section-heading--compact">
              <p class="eyebrow">{{ $education['eyebrow'] ?? '' }}</p>
              <h2>{{ $education['heading'] ?? '' }}</h2>
            </div>
            @foreach (($education['items'] ?? []) as $item)
              <article class="info-panel">
                <p class="timeline-item__meta">{{ $item['period'] ?? '' }}</p>
                <h3>{{ $item['degree'] ?? '' }}</h3>
                <p>{{ $item['institute'] ?? '' }}</p>
                @if (! blank($item['details'] ?? null))
                  <p>{{ $item['details'] }}</p>
                @endif
              </article>
            @endforeach
          </div>

          <div class="github" data-reveal>
            <div class="section-heading section-heading--compact">
              <p class="eyebrow">{{ $github['eyebrow'] ?? '' }}</p>
              <h2>{{ $github['heading'] ?? '' }}</h2>
            </div>
            <div class="contribution-graph" aria-label="Decorative GitHub contribution graph">
              @foreach (array_slice($github['graphLevels'] ?? [], 0, 70) as $level)
                <span data-level="{{ $level }}"></span>
              @endforeach
            </div>
            <div class="repo-list">
              @foreach (($github['repos'] ?? []) as $repo)
                <a href="{{ $repo['url'] ?? '#' }}">{{ $repo['label'] ?? '' }}</a>
              @endforeach
            </div>
          </div>
        </section>

        <section class="section blog">
          <div class="section-heading" data-reveal>
            <p class="eyebrow">{{ $articles['eyebrow'] ?? '' }}</p>
            <h2>{{ $articles['heading'] ?? '' }}</h2>
          </div>
          <div class="blog__grid">
            @foreach (($articles['items'] ?? []) as $article)
              <a class="article-link" href="{{ $article['url'] ?? '#' }}" data-reveal>
                <span>{{ $article['category'] ?? '' }}</span>
                <h3>{{ $article['title'] ?? '' }}</h3>
                @if (! blank($article['excerpt'] ?? null))
                  <p>{{ $article['excerpt'] }}</p>
                @endif
              </a>
            @endforeach
          </div>
        </section>

        <section class="section contact" id="contact">
          <div class="section-heading" data-reveal>
            <p class="eyebrow">{{ $contact['eyebrow'] ?? '' }}</p>
            <h2>{{ $contact['heading'] ?? '' }}</h2>
          </div>
          <div class="contact__grid">
            <form class="contact-form" method="POST" action="{{ route('portfolio.contact') }}" data-reveal>
              @csrf
              <label>
                Name
                <input name="name" type="text" autocomplete="name" value="{{ old('name') }}" required />
              </label>
              <label>
                Email
                <input name="email" type="email" autocomplete="email" value="{{ old('email') }}" required />
              </label>
              <label>
                Message
                <textarea name="message" rows="5" required>{{ old('message') }}</textarea>
              </label>
              <button class="button button--primary" type="submit">Send Message</button>
              @if ($errors->any())
                <p class="form-status" role="status">Please fill in every field correctly.</p>
              @elseif (session('status'))
                <p class="form-status" role="status">{{ session('status') }}</p>
              @else
                <p class="form-status" role="status" aria-live="polite"></p>
              @endif
            </form>
            <aside class="contact-panel terminal" data-reveal>
              <div class="terminal__bar">
                <span></span>
                <span></span>
                <span></span>
              </div>
              <div class="terminal__body">
                <p><span class="prompt">$</span> connect --channel</p>
                <div class="contact-links">
                  @if (! blank($contact['email'] ?? null))
                    <a href="mailto:{{ $contact['email'] }}">{{ $contact['email'] }}</a>
                  @endif
                  @foreach (($contact['links'] ?? []) as $link)
                    <a href="{{ $link['url'] ?? '#' }}">{{ $link['label'] ?? '' }}</a>
                  @endforeach
                </div>
              </div>
            </aside>
          </div>
        </section>
      </main>

      <footer class="site-footer">
        <p>Built with Laravel, Blade, and Filament.</p>
        <p>&copy; <span id="year"></span> {{ $profile['name'] ?? '' }}. {{ $profile['footerQuote'] ?? '' }}</p>
      </footer>
    </div>

    <script>
      window.PORTFOLIO_TYPING_MESSAGES = @json($profile['typingMessages'] ?? []);
    </script>
    <script src="{{ asset('js/portfolio.js') }}?v={{ filemtime(public_path('js/portfolio.js')) }}"></script>
  </body>
</html>
