<div class="w-full block flex-grow lg:flex lg:items-center lg:w-auto">
    <div class="text-sm lg:flex-grow">
        <a href="/firewall" class="{{ request()->is('firewall') ? 'active' : '' }} block mt-4 lg:inline-block lg:mt-0 text-teal-lighter hover:text-white mr-4">
            Firewall Test Page
        </a>
        <a href="/google2fa" class="{{ request()->is('google2fa') ? 'active' : '' }} block mt-4 lg:inline-block lg:mt-0 text-teal-lighter hover:text-white mr-4">
            Google2FA Test Page
        </a>
        {{--<a href="/countries" class="{{ request()->is('countries') ? 'active' : '' }} block mt-4 lg:inline-block lg:mt-0 text-teal-lighter hover:text-white">--}}
            {{--Countries Test Page--}}
        {{--</a>--}}
    </div>

    @if ($user = Auth::user())
        <a
            href="/google2fa/middleware/logout"
            class="inline-block text-sm px-4 py-2 leading-none border rounded text-white border-white hover:border-transparent hover:text-teal hover:bg-white mt-4 lg:mt-0"
        >
            {{ $user->name }} ({{ $user->email }}) - logout
        </a>
    @endif
</div>
