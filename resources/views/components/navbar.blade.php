<header class="border-b border-border bg-surface">
    <div class="mx-auto flex w-full max-w-300 items-center justify-between px-4 sm:px-6 lg:px-8">

        {{-- Brand --}}
        <a
            href="{{ url('/') }}"
            class="flex min-h-16 items-center text-lg font-semibold tracking-tight text-text hover:text-primary"
        >
            Mikroliterasi
        </a>

        {{-- Desktop navigation --}}
        <nav class="hidden items-center gap-1 md:flex">

            <a
                href="{{ route('research-projects.index') }}"
                class="rounded-md px-3 py-2 text-sm font-medium text-text-muted transition hover:bg-background hover:text-primary"
            >
                Research
            </a>

            <a
                href="#"
                class="rounded-md px-3 py-2 text-sm font-medium text-text-muted transition hover:bg-background hover:text-primary"
            >
                Publications
            </a>

            <a
                href="#"
                class="rounded-md px-3 py-2 text-sm font-medium text-text-muted transition hover:bg-background hover:text-primary"
            >
                People
            </a>

            <a
                href="#"
                class="rounded-md px-3 py-2 text-sm font-medium text-text-muted transition hover:bg-background hover:text-primary"
            >
                About
            </a>

        </nav>

        {{-- Mobile menu button --}}
        <button
            type="button"
            class="inline-flex min-h-10 min-w-10 items-center justify-center rounded-md border border-border text-text-muted transition hover:bg-background hover:text-primary md:hidden"
            aria-label="Open navigation menu"
            aria-expanded="false"
            aria-controls="mobile-menu"
            data-mobile-menu-button
        >
            <svg
                xmlns="http://www.w3.org/2000/svg"
                fill="none"
                viewBox="0 0 24 24"
                stroke-width="1.5"
                stroke="currentColor"
                class="h-5 w-5"
            >
                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5"
                />
            </svg>
        </button>

    </div>
    <div
        id="mobile-menu"
        class="hidden border-t border-border md:hidden"
        data-mobile-menu
    >
        <nav class="mx-auto w-full max-w-300 px-4 py-3 sm:px-6">

            <a
                href="{{ route('research-projects.index') }}"
                class="block rounded-md px-3 py-3 text-sm font-medium text-text-muted hover:bg-background hover:text-primary"
            >
                Research
            </a>

            <a
                href="#"
                class="block rounded-md px-3 py-3 text-sm font-medium text-text-muted hover:bg-background hover:text-primary"
            >
                Publications
            </a>

            <a
                href="#"
                class="block rounded-md px-3 py-3 text-sm font-medium text-text-muted hover:bg-background hover:text-primary"
            >
                People
            </a>

            <a
                href="#"
                class="block rounded-md px-3 py-3 text-sm font-medium text-text-muted hover:bg-background hover:text-primary"
            >
                About
            </a>

        </nav>
    </div>
</header>
