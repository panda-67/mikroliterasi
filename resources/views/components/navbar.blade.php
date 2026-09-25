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

            @auth
                <x-nav-link
                    href="{{ route('dashboard.index') }}"
                    :active="request()->routeIs('dashboard.*')"
                >
                    Dashboard
                </x-nav-link>
            @endauth

            <x-nav-link
                href="{{ route('research-projects.index') }}"
                :active="request()->routeIs('research-projects.*')"
            >
                Research
            </x-nav-link>

            <x-nav-link
                href="{{ route('publications.index') }}"
                :active="request()->routeIs('publications.*')"
            >
                Publications
            </x-nav-link>

            <x-nav-link
                href="{{ route('people.index') }}"
                :active="request()->routeIs('people.*')"
            >
                People
            </x-nav-link>

            <x-nav-link
                href="{{ route('about') }}"
                :active="request()->routeIs('about')"
            >
                About
            </x-nav-link>

            @auth
                <form
                    method="POST"
                    action="{{ route('logout') }}"
                >
                    @csrf

                    <button
                        type="submit"
                        class="text-sm font-medium text-text-muted hover:text-primary"
                    >
                        Logout
                    </button>
                </form>
            @else
                <a
                    href="{{ route('login') }}"
                    class="text-sm font-medium text-text-muted hover:text-primary"
                >
                    Login
                </a>
            @endauth

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
            @auth
                <x-mobile-nav-link
                    href="{{ route('dashboard.index') }}"
                    :active="request()->routeIs('dashboard.*')"
                >
                    Dashboard
                </x-mobile-nav-link>
            @endauth

            <x-mobile-nav-link
                href="{{ route('research-projects.index') }}"
                :active="request()->routeIs('research-projects.*')"
            >
                Research
            </x-mobile-nav-link>

            <x-mobile-nav-link
                href="{{ route('publications.index') }}"
                :active="request()->routeIs('publications.*')"
            >
                Publications
            </x-mobile-nav-link>

             <x-mobile-nav-link
                href="{{ route('people.index') }}"
                :active="request()->routeIs('people.*')"
            >
                People
            </x-mobile-nav-link>

            <x-mobile-nav-link
                href="{{ route('about') }}"
                :active="request()->routeIs('about')"
            >
                About
            </x-mobile-nav-link>

            @auth
                <form
                    method="POST"
                    action="{{ route('logout') }}"
                >
                    @csrf

                    <button
                        type="submit"
                        class="w-full py-3 px-3 text-left text-sm font-medium text-text-muted hover:text-primary"
                    >
                        Logout
                    </button>
                </form>
            @else
                <a
                    href="{{ route('login') }}"
                    class="block px-3 py-3 text-sm font-medium text-text-muted hover:text-primary"
                >
                    Login
                </a>
            @endauth

        </nav>
    </div>
</header>
