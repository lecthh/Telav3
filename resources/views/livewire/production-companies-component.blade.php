<div>
    <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">
        <div class="lg:col-span-1">
            @include('livewire.production-companies-filter')
        </div>
        
        <div class="lg:col-span-3">
            <div class="mb-4 flex justify-between items-center">
                <p class="text-gray-600">
                    Found <span class="font-medium">{{ $productionCompanies->count() }}</span> production companies
                </p>
                <button 
                    class="lg:hidden px-4 py-2 border border-gray-300 rounded-lg text-gray-700 bg-white hover:bg-gray-50"
                    @click="$dispatch('toggle-filters')"
                >
                    <span class="flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
                        </svg>
                        Filters
                    </span>
                </button>
            </div>
            
            @if($productionCompanies->count() > 0)
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                    @foreach($productionCompanies as $productionCompany)
                    <div 
                        class="flex flex-col p-4 rounded-lg bg-white border hover:shadow-md transition-all duration-200 {{ $selectedProductionCompany === $productionCompany->id ? 'border-cPrimary ring-2 ring-cPrimary/30' : 'border-gray-200' }}"
                        wire:click="selectProductionCompany({{ $productionCompany->id }})"
                    >
                        <div class="h-40 mb-4 rounded-md overflow-hidden bg-gray-50 flex items-center justify-center p-4">
                            @if($productionCompany->company_logo && Str::startsWith($productionCompany->company_logo, 'company_logos/'))
                                <img class="object-contain w-full h-full" src="{{ Storage::url($productionCompany->company_logo) }}" alt="{{ $productionCompany->company_name }}">
                            @elseif($productionCompany->company_logo)
                                <img class="object-contain w-full h-full" src="{{ asset($productionCompany->company_logo) }}" alt="{{ $productionCompany->company_name }}">
                            @else
                                <img class="object-contain w-full h-full" src="{{ asset('imgs/companyLogo/placeholder.jpg') }}" alt="{{ $productionCompany->company_name }}">
                            @endif
                        </div>
                        
                        <div class="flex-grow">
                            <h3 class="font-gilroy font-bold text-lg mb-1">{{ $productionCompany->company_name }}</h3>
                            
                            <div class="mt-1 space-y-1 text-sm text-gray-500 mb-3">
                                @php
                                    $productionTypeArray = is_string($productionCompany->production_type) 
                                        ? json_decode($productionCompany->production_type, true) 
                                        : $productionCompany->production_type;
                                    
                                    if (!is_array($productionTypeArray)) {
                                        $productionTypeArray = [];
                                    }
                                @endphp
                                
                                @if(count($productionTypeArray) > 0)
                                    <p class="flex items-start">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1 mt-1 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01" />
                                        </svg>
                                        <span>
                                            {{ implode(', ', array_map(function($typeId) use ($productionTypeNames) {
                                                return $productionTypeNames[$typeId] ?? '';
                                            }, array_filter($productionTypeArray))) }}
                                        </span>
                                    </p>
                                @endif
                                
                                @if($productionCompany->lowestPrice && $productionCompany->highestPrice)
                                    <p class="flex items-center">
                                        ₱{{ number_format($productionCompany->lowestPrice, 2) }} - ₱{{ number_format($productionCompany->highestPrice, 2) }}
                                    </p>
                                @endif
                            </div>
                        </div>
                        
                        <div class="pt-3 border-t border-gray-100 mt-auto">
                            <a wire:click.stop href="{{ route('production.company.show', $productionCompany->id) }}" class="text-cPrimary hover:text-purple-700 hover:underline text-sm font-medium flex items-center">
                                View details
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                                </svg>
                            </a>
                        </div>
                    </div>
                    @endforeach
                </div>
            @else
                <div class="bg-white rounded-lg border border-gray-200 p-8 text-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto text-gray-400 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <h3 class="text-lg font-medium text-gray-900 mb-1">No production companies found</h3>
                    <p class="text-gray-500 mb-4">Try adjusting your filters to find more results</p>
                    <button 
                        wire:click="resetFilters"
                        class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-cPrimary hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-cPrimary"
                    >
                        Reset Filters
                    </button>
                </div>
            @endif
        </div>
    </div>
</div>