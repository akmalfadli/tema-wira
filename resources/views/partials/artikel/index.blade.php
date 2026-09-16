@extends('theme::template')

@php
    $currentPath = trim(request()->path(), '/');
    $isCategoryPage = str_contains($currentPath, 'artikel/kategori');
@endphp

@if ($isCategoryPage)
@section('layout')
    <div class="w-full flex flex-col lg:flex-row mt-8 mb-8 gap-6 text-gray-600">
        {{-- Content --}}
        <main class="lg:flex-1 w-full bg-white rounded-xl shadow-sm overflow-hidden p-4 lg:p-6">
            {{-- Breadcrumb --}}
            <nav role="navigation" aria-label="navigation" class="mb-6">
                <ol class="flex items-center gap-2 text-sm text-gray-500">
                    <li><a href="{{ ci_route() }}" class="hover:text-green-600">Beranda</a></li>
                    <li><svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg></li>
                    <li class="font-medium text-gray-900">
                        {{ is_array($judul_kategori) ? ($judul_kategori['kategori'] ?? 'Kategori Artikel') : ($judul_kategori ?? 'Kategori Artikel') }}
                    </li>
                </ol>
            </nav>

            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden p-6 md:p-8 space-y-6">
                {{-- Header Kategori --}}
                <div class="border-b border-gray-100 pb-4">
                    <h1 class="text-2xl md:text-3xl font-bold text-gray-900">
                        {{ is_array($judul_kategori) ? ($judul_kategori['kategori'] ?? 'Kategori Artikel') : ($judul_kategori ?? 'Daftar Artikel') }}
                    </h1>
                </div>

                {{-- List Berita Kategori --}}
                @if (isset($artikel) && count($artikel) > 0)
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        @foreach ($artikel as $post)
                            @include('theme::partials.artikel.list', ['post' => $post])
                        @endforeach
                    </div>

                    {{-- Pagination --}}
                    <div class="mt-8 flex justify-center">
                        @if (method_exists($artikel, 'links'))
                            {{ $artikel->links() }}
                        @endif
                    </div>
                @else
                    @include('theme::partials.artikel.empty')
                @endif
            </div>
        </main>
        {{-- Widget Sidebar --}}
        <div class="lg:w-1/3 2xl:w-[400px] w-full">
            @include('theme::partials.sidebar')
        </div>
    </div>
@endsection
@endif
