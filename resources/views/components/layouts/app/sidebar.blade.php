<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ in_array(app()->getLocale(), ['ar', 'he']) ? 'rtl' : 'ltr' }}" class="{{ auth()->user()->dark_mode ? 'dark dark:text-white' : '' }}">
    <head>
        @include('partials.head')
    </head>
    <body class="min-h-screen bg-white dark:bg-zinc-800">
        <flux:sidebar sticky stashable class="border-e border-zinc-200 bg-zinc-50 dark:border-zinc-700 dark:bg-zinc-900">
            <flux:sidebar.toggle class="lg:hidden" icon="x-mark" />

            <a href="{{ route('dashboard') }}" class="me-5 flex items-center space-x-2 rtl:space-x-reverse dark:text-white" wire:navigate>
                <x-app-logo />
            </a>

            <flux:navlist variant="outline">
                {{-- Super admon links  --}}
                @if (auth()->user()->role == 'admin')
                    <flux:navlist.group :heading="__('Platform')" class="grid">
                        <flux:navlist.item icon="home" :href="route('dashboard')" :current="request()->routeIs('dashboard')" wire:navigate>{{ __('Dashboard') }}</flux:navlist.item>
                        <flux:navlist.item icon="users" :href="route('users.index')" :current="request()->routeIs('users.index')" wire:navigate>{{ __('Users') }}</flux:navlist.item>
                        <flux:navlist.item icon="academic-cap" :href="route('schools.index')" :current="request()->routeIs('schools.index')" wire:navigate>{{ __('Schools') }}</flux:navlist.item>
                        <flux:navlist.item icon="computer-desktop" :href="route('programs.index')" :current="request()->routeIs('programs.index')" wire:navigate>{{ __('Programs') }}</flux:navlist.item>
                        <flux:navlist.item icon="bolt" :href="route('activations.index')" :current="request()->routeIs('activations.index')" wire:navigate>{{ __('Activations Code') }}</flux:navlist.item>
                        <flux:navlist.item icon="shield-alert" :href="route('activations.requests')" :current="request()->routeIs('activations.requests')" wire:navigate>{{ __('Activations Request') }}</flux:navlist.item>
                    </flux:navlist.group>
                @endif

                {{-- manager links  --}}
                @if (auth()->user()->role == 'manager')
                    <flux:navlist.group :heading="__('Platform')" class="grid">
                        <flux:navlist.item icon="home" :href="route('manager.dashboard')" :current="request()->routeIs('manager.dashboard')" wire:navigate>{{ __('Dashboard') }}</flux:navlist.item>
                        <flux:navlist.item icon="users" :href="route('manager.users.index')" :current="request()->routeIs('manager.users.index')" wire:navigate>{{ __('Users') }}</flux:navlist.item>
                        <flux:navlist.item icon="users" :href="route('manager.students.index')" :current="request()->routeIs('manager.students.index')" wire:navigate>{{ __('Students') }}</flux:navlist.item>
                        <flux:navlist.item icon="users" :href="route('manager.guardians.index')" :current="request()->routeIs('manager.guardians.index')" wire:navigate>{{ __('Parents') }}</flux:navlist.item>
                        <flux:navlist.item icon="users" :href="route('manager.teachers.index')" :current="request()->routeIs('manager.teachers.index')" wire:navigate>{{ __('Teachers') }}</flux:navlist.item>
                        <flux:navlist.item icon="arrow-up-tray" :href="route('manager.import')" :current="request()->routeIs('manager.import')" wire:navigate>{{ __('Import Excel') }}</flux:navlist.item>
                        <flux:navlist.item icon="identification" :href="route('manager.actvation')" :current="request()->routeIs('manager.actvation')" wire:navigate>{{ __('Actvation Info') }}</flux:navlist.item>
                    </flux:navlist.group>
                @endif
             
                {{-- guardian links  --}}
                @if (auth()->user()->role == 'guardian')
                    <flux:navlist.group :heading="__('Platform')" class="grid">
                        <flux:navlist.item icon="home" :href="route('guardian.dashboard')" :current="request()->routeIs('guardian.dashboard')" wire:navigate>{{ __('Dashboard') }}</flux:navlist.item>
                        <flux:navlist.item icon="notepad-text" :href="route('guardian.book-meeting')" :current="request()->routeIs('guardian.book-meeting')" wire:navigate>{{ __('Book Meeting') }}</flux:navlist.item>
                        <flux:navlist.item icon="notepad-text" :href="route('guardian.chat')" :current="request()->routeIs('guardian.chat')" wire:navigate>{{ __('Chat') }}</flux:navlist.item>
                    </flux:navlist.group>
                @endif
             
                {{-- teacher links  --}}
                @if (auth()->user()->role == 'teacher')
                    <flux:navlist.group :heading="__('Platform')" class="grid">
                        <flux:navlist.item icon="home" :href="route('teacher.dashboard')" :current="request()->routeIs('teacher.dashboard')" wire:navigate>{{ __('Dashboard') }}</flux:navlist.item>
                        <flux:navlist.item icon="calendar-check" :href="route('teacher.set-slots')" :current="request()->routeIs('teacher.set-slots')" wire:navigate>{{ __('Set Appointments') }}</flux:navlist.item>
                        <flux:navlist.item icon="calendar-check" :href="route('teacher.manage-meeting')" :current="request()->routeIs('teacher.manage-meeting')" wire:navigate>{{ __('Appointments') }}</flux:navlist.item>
                    </flux:navlist.group>
                @endif
                
            </flux:navlist>

            <flux:spacer />

            <!-- Desktop User Menu -->
            <flux:dropdown class="hidden lg:block" position="bottom" align="start">
                <flux:profile
                    :name="auth()->user()->name"
                    :initials="auth()->user()->initials()"
                    icon:trailing="chevrons-up-down"
                />
                <flux:menu class="w-[220px]">
                    <flux:menu.radio.group>
                        <div class="p-0 text-sm font-normal">
                            <div class="flex items-center gap-2 px-1 py-1.5 text-start text-sm">
                                <span class="relative flex h-8 w-8 shrink-0 overflow-hidden rounded-lg">
                                    <span
                                        class="flex h-full w-full items-center justify-center rounded-lg bg-neutral-200 text-black dark:bg-neutral-700 dark:text-white"
                                    >
                                        {{ auth()->user()->initials() }}
                                    </span>
                                </span>

                                <div class="grid flex-1 text-start text-sm leading-tight dark:text-white">
                                    <span class="truncate font-semibold">{{ auth()->user()->name }}</span>
                                    <span class="truncate text-xs">{{ auth()->user()->email }}</span>
                                </div>
                            </div>
                        </div>
                    </flux:menu.radio.group>

                    <flux:menu.separator />

                    <flux:menu.radio.group>
                        <flux:menu.item :href="route('settings.profile')" icon="cog" wire:navigate>{{ __('Settings') }}</flux:menu.item>
                    </flux:menu.radio.group>

                    <flux:menu.separator />

                    <form method="POST" action="{{ route('logout') }}" class="w-full">
                        @csrf
                        <flux:menu.item as="button" type="submit" icon="arrow-right-start-on-rectangle" class="w-full">
                            {{ __('Log Out') }}
                        </flux:menu.item>
                    </form>
                </flux:menu>
            </flux:dropdown>
        </flux:sidebar>

        <!-- Mobile User Menu -->
        <flux:header class="lg:hidden">
            <flux:sidebar.toggle class="lg:hidden" icon="bars-2" inset="left" />

            <flux:spacer />

            <flux:dropdown position="top" align="end">
                <flux:profile
                    :initials="auth()->user()->initials()"
                    icon-trailing="chevron-down"
                />

                <flux:menu>
                    <flux:menu.radio.group>
                        <div class="p-0 text-sm font-normal">
                            <div class="flex items-center gap-2 px-1 py-1.5 text-start text-sm">
                                <span class="relative flex h-8 w-8 shrink-0 overflow-hidden rounded-lg">
                                    <span
                                        class="flex h-full w-full items-center justify-center rounded-lg bg-neutral-200 text-black dark:bg-neutral-700 dark:text-white"
                                    >
                                        {{ auth()->user()->initials() }}
                                    </span>
                                </span>

                                <div class="grid flex-1 text-start text-sm leading-tight">
                                    <span class="truncate font-semibold">{{ auth()->user()->name }}</span>
                                    <span class="truncate text-xs">{{ auth()->user()->email }}</span>
                                </div>
                            </div>
                        </div>
                    </flux:menu.radio.group>

                    <flux:menu.separator />

                    <flux:menu.radio.group>
                        <flux:menu.item :href="route('settings.profile')" icon="cog" wire:navigate>{{ __('Settings') }}</flux:menu.item>
                    </flux:menu.radio.group>

                    <flux:menu.separator />

                    <form method="POST" action="{{ route('logout') }}" class="w-full">
                        @csrf
                        <flux:menu.item as="button" type="submit" icon="arrow-right-start-on-rectangle" class="w-full">
                            {{ __('Log Out') }}
                        </flux:menu.item>
                    </form>
                </flux:menu>
            </flux:dropdown>
        </flux:header>

        {{ $slot }}

        <livewire:toasts />
        @fluxScripts
        @livewireScriptConfig
    </body>
</html>
