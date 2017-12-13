@extends('templates.main')

@section('content')
    <div class="flex items-center flex-grow">
        <div class="flex-1 m-4 rounded overflow-hidden shadow border-r border-b border-l border-grey-light lg:border-l-0 lg:border-t lg:border-grey-light bg-white rounded-b lg:rounded-b-none lg:rounded-r p-4 flex flex-col justify-between leading-normal">
            <p class="text-black">What?</p>
        </div>
    </div>

    <div class="flex">
        <div class="w-1/6 p-2"></div>

        <div class="w-auto p-2">
            <div class="flex flex-wrap">
                @foreach($packages as $package)
                    @include('home.partials.package-card', $package)
                @endforeach
            </div>
        </div>

        <div class="w-1/6 p-2"></div>
    </div>

    <a href="https://github.com/antonioribeiro"> <i class="fa fa-github-alt" title="Github"></i></a>
    <a href="https://twitter.com/iantonioribeiro"> <i class="fa fa-twitter" title="Twitter"></i></a>

    by <a href="https://antoniocarlosribeiro.com">Antonio Carlos Ribeiro</a>
@stop

