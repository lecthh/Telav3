<div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 mb-6">
    <h3 class="font-gilroy font-bold text-xl mb-4">Filter Production Companies</h3>
    
    <div class="space-y-6">
        <div>
            <h4 class="font-medium text-gray-800 mb-2">Apparel Type</h4>
            <div class="grid grid-cols-2 md:grid-cols-3 gap-2">
                @foreach($apparelTypes as $apparelType)
                <label class="flex items-center space-x-2">
                    <input 
                        type="checkbox" 
                        wire:model.live="selectedApparelType" 
                        value="{{ $apparelType->id }}" 
                        class="rounded border-gray-300 text-cPrimary focus:ring-cPrimary"
                    >
                    <span class="text-sm text-gray-700">{{ $apparelType->name }}</span>
                </label>
                @endforeach
            </div>
        </div>
        
        <div>
            <h4 class="font-medium text-gray-800 mb-2">Production Method</h4>
            <div class="grid grid-cols-2 md:grid-cols-3 gap-2">
                @foreach($productionTypes as $productionType)
                <label class="flex items-center space-x-2">
                    <input 
                        type="checkbox" 
                        wire:model.live="selectedProductionType" 
                        value="{{ $productionType->id }}" 
                        class="rounded border-gray-300 text-cPrimary focus:ring-cPrimary"
                    >
                    <span class="text-sm text-gray-700">{{ $productionType->name }}</span>
                </label>
                @endforeach
            </div>
        </div>
        
        <div>
            <h4 class="font-medium text-gray-800 mb-2">Max Price Range</h4>
            <div class="mb-4 px-1">
                <div class="flex justify-between text-xs text-gray-500 mb-1">
                    <span>₱0</span>
                    <span>₱{{ $maxPriceLimit }}</span>
                </div>
                <input 
                    type="range" 
                    wire:model.live="priceRange" 
                    min="0" 
                    max="{{ $maxPriceLimit }}" 
                    step="100" 
                    class="w-full h-2 bg-gray-200 rounded-lg appearance-none cursor-pointer accent-cPrimary"
                >
                <div class="text-center mt-2 text-sm font-medium text-gray-700">
                    ₱{{ $priceRange }}
                </div>
            </div>
        </div>
        
        <div class="border-t border-gray-200 pt-4">
            <h4 class="font-medium text-gray-800 mb-2">Sort By</h4>
            <select 
                wire:model.live="sortBy" 
                class="w-full rounded-lg border-gray-300 focus:border-cPrimary focus:ring focus:ring-cPrimary focus:ring-opacity-50"
            >
                <option value="">Select an option</option>
                <option value="name_asc">Name (A-Z)</option>
                <option value="name_desc">Name (Z-A)</option>
                <option value="price_asc">Price (Low to High)</option>
                <option value="price_desc">Price (High to Low)</option>
            </select>
        </div>

        <div class="pt-2">
            <button
                wire:click="resetFilters"
                class="w-full py-2 px-4 border border-gray-300 rounded-lg text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-cPrimary"
            >
                Reset Filters
            </button>
        </div>
    </div>
</div>