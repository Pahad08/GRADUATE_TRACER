@php
if (! isset($scrollTo)) {
    $scrollTo = 'body';
}

$scrollIntoViewJsSnippet = ($scrollTo !== false)
    ? <<<JS
       (\$el.closest('{$scrollTo}') || document.querySelector('{$scrollTo}')).scrollIntoView()
    JS
    : '';
@endphp

<div >
            <div class="flex-1 gap-y-3 md:flex-row flex-col flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-700 leading-5 dark:text-gray-400">
                        <span>{!! __('Showing') !!}</span>
                        <span class="font-medium">{{ $paginator->firstItem() }}</span>
                        <span>{!! __('to') !!}</span>
                        <span class="font-medium">{{ $paginator->lastItem() }}</span>
                        <span>{!! __('of') !!}</span>
                        <span class="font-medium">{{ $paginator->total() }}</span>
                        <span>{!! __('results') !!}</span>
                    </p>
                </div>
                @if ($paginator->hasPages())

                <div>
                    <span class="join relative z-0 inline-flex rtl:flex-row-reverse rounded-md">
                        {{-- First Page --}}
                        @if ($paginator->onFirstPage())
                            <span class="join-item btn btn-sm relative z-0 cursor-default opacity-50">First</span>
                        @else
                            <button type="button" class="join-item btn btn-sm relative z-0" wire:click="resetPage()"
                                x-on:click="{{ $scrollIntoViewJsSnippet }}">
                                First
                            </button>
                        @endif

                            {{-- Previous Page Link --}}
                            @if ($paginator->onFirstPage())
                                <span aria-disabled="true" class="join-item btn btn-sm opacity-50"
                                    aria-label="{{ __("pagination.previous") }}">
                                    <span aria-hidden="true">
                                        <i class="fa-solid fa-chevron-left"></i>
                                    </span>
                                </span>
                            @else
                                <button type="button" class="join-item btn btn-sm"
                                    wire:click="previousPage('{{ $paginator->getPageName() }}')"
                                    x-on:click="{{ $scrollIntoViewJsSnippet }}"
                                    dusk="previousPage{{ $paginator->getPageName() == "page" ? "" : "." . $paginator->getPageName() }}.after"
                                    class="relative inline-flex items-center rounded-l-md border border-gray-300 bg-white px-2 py-2 text-sm font-medium leading-5 text-gray-500 ring-blue-300 transition duration-150 ease-in-out hover:text-gray-400 focus:z-10 focus:border-blue-300 focus:outline-none focus:ring active:bg-gray-100 active:text-gray-500 dark:border-gray-600 dark:bg-gray-800 dark:focus:border-blue-800 dark:active:bg-gray-700"
                                    aria-label="{{ __("pagination.previous") }}">
                                    <i class="fa-solid fa-chevron-left"></i>
                                </button>
                            @endif

                        {{-- Pagination Elements --}}
                        @foreach ($elements as $element)
                            {{-- "Three Dots" Separator --}}
                            @if (is_string($element))
                                <span aria-disabled="true" class="join-item btn btn-sm cursor-default">
                                    <span >{{ $element }}</span>
                                </span>
                            @endif

                            {{-- Array Of Links --}}
                            @if (is_array($element))
                                @foreach ($element as $page => $url)
                                        @if ($page == $paginator->currentPage())
                                        <span class="join-item btn btn-sm btn-primary" wire:key="paginator-{{ $paginator->getPageName() }}-page{{ $page }}">
                                                <span >{{ $page }}</span>
                                        </span>
                                        @else
                                            <button type="button" wire:click="gotoPage({{ $page }}, '{{ $paginator->getPageName() }}')" x-on:click="{{ $scrollIntoViewJsSnippet }}" 
                                                class="join-item btn btn-sm" wire:key="paginator-{{ $paginator->getPageName() }}-page{{ $page }}" aria-label="{{ __('Go to page :page', ['page' => $page]) }}">
                                                {{ $page }}
                                            </button>
                                        @endif
                                @endforeach
                            @endif
                        @endforeach

                        {{-- Next Page Link --}}
                        @if ($paginator->hasMorePages())
                            <button type="button" class="join-item btn btn-sm"
                                wire:click="nextPage('{{ $paginator->getPageName() }}')"
                                x-on:click="{{ $scrollIntoViewJsSnippet }}"
                                dusk="nextPage{{ $paginator->getPageName() == "page" ? "" : "." . $paginator->getPageName() }}.after"
                                aria-label="{{ __("pagination.next") }}">
                                <i class="fa-solid fa-chevron-right"></i>
                            </button>
                        @else
                            <span aria-disabled="true" class="join-item btn btn-sm opacity-50"
                                aria-label="{{ __("pagination.next") }}">
                                <span aria-hidden="true">
                                    <i class="fa-solid fa-chevron-right"></i>
                                </span>
                            </span>
                        @endif

                        {{-- Last Page --}}
                        @if ($paginator->hasMorePages())
                            <button type="button" class="join-item btn btn-sm"
                                wire:click="gotoPage({{ $paginator->lastPage() }}, '{{ $paginator->getPageName() }}')"
                                x-on:click="{{ $scrollIntoViewJsSnippet }}" aria-label="{{ __("pagination.last") }}">
                                Last
                            </button>
                        @else
                            <span class="join-item btn btn-sm cursor-default opacity-50">
                                Last
                            </span>
                        @endif
                        
                    </span>              
                </div>
    @endif

            </div>
</div>
