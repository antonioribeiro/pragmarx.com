
<div class="w-1/3 max-w-sm m-4 rounded overflow-hidden shadow border-r border-b border-l border-grey-light lg:border-l-0 lg:border-t lg:border-grey-light bg-white rounded-b lg:rounded-b-none lg:rounded-r p-4 flex flex-col justify-between leading-normal">
    <div class="mb-2">
        <p class="text-sm text-grey">
            icon = <i class="fas fa-user"></i>{{ $package['name'] }}
        </p>

        <div class="text-black font-bold text-xl mb-2">
            {{ $package['title'] }}
        </div>

        <div class="text-black mb-2">{{ $package['description'] }}</div>
    </div>

    <div class="flex items-center">
        <div class="flex-1">
            <p class="text-black leading-none">Downloads: {{ number_format($package['downloads']['total']) }}</p>
        </div>

        <div class="flex-1">
            <p class="text-black leading-none">GitHub stars: {{ number_format($package['github_stars']) }}</p>
        </div>
    </div>
</div>
{{--<tr>--}}
    {{--<td>--}}
        {{--<a href="{{ $package['repository'] }}">{{ $package['name'] }}</a>--}}
    {{--</td>--}}
    {{--<td>--}}
        {{--<a href="{{ $package['repository'] }}">{{ $package['description'] }}</a>--}}
    {{--</td>--}}
    {{--<td>--}}
        {{--{{ $package['downloads']['total'] }}--}}
    {{--</td>--}}
    {{--<td>--}}
        {{--{{ $package['github_stars'] }}--}}
    {{--</td>--}}
{{--</tr>--}}
