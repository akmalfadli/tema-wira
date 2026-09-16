@extends('theme::template')

@section('layout')
    <div class="w-full flex flex-col lg:flex-row mt-8 mb-8 gap-6 text-gray-600">
        <!-- Widget -->
        <div class="lg:w-1/3 2xl:w-[400px] w-full">
            @include('theme::partials.sidebar')
        </div>
        {{-- Content --}}
        <main class="lg:flex-1 w-full bg-white rounded-xl shadow-sm overflow-hidden p-4 lg:p-6">
            @yield('content')
        </main>
    </div>
@endsection
