<div class="fixed inset-0 z-50 flex items-center justify-center overflow-auto bg-black bg-opacity-50" 
    x-show="showCancelModal"
    x-cloak>
    <div class="relative w-full max-w-md mx-auto my-8 bg-white rounded-lg shadow-xl overflow-hidden" 
        x-show="showCancelModal"
        @click.away="showCancelModal = false">
        <div class="px-6 py-4 bg-cPrimary">
            <div class="flex items-center justify-between">
                <h3 class="text-lg font-bold text-white">Cancel Order</h3>
                <button type="button" @click="showCancelModal = false" class="text-white hover:text-gray-200">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
        </div>

        <form method="POST" action="{{ $action }}" class="p-6">
            @csrf
            <div class="mb-4">
                <p class="font-medium text-gray-800 mb-4">Please select a reason for cancelling this order:</p>
                
                <div class="space-y-3">
                    <label class="flex items-center">
                        <input type="radio" name="cancellation_reason" value="Customer request" class="h-4 w-4 text-cPrimary" x-on:click="otherReason = ''" required>
                        <span class="ml-2 text-gray-700">Customer requested cancellation</span>
                    </label>
                    
                    <label class="flex items-center">
                        <input type="radio" name="cancellation_reason" value="Production issues" class="h-4 w-4 text-cPrimary" x-on:click="otherReason = ''">
                        <span class="ml-2 text-gray-700">Production issues</span>
                    </label>
                    
                    <label class="flex items-center">
                        <input type="radio" name="cancellation_reason" value="Design issues" class="h-4 w-4 text-cPrimary" x-on:click="otherReason = ''">
                        <span class="ml-2 text-gray-700">Design issues</span>
                    </label>
                    
                    <label class="flex items-center">
                        <input type="radio" name="cancellation_reason" value="Payment issues" class="h-4 w-4 text-cPrimary" x-on:click="otherReason = ''">
                        <span class="ml-2 text-gray-700">Payment issues</span>
                    </label>
                    
                    <label class="flex items-center">
                        <input type="radio" name="cancellation_reason" value="Schedule issues" class="h-4 w-4 text-cPrimary" x-on:click="otherReason = ''">
                        <span class="ml-2 text-gray-700">Schedule constraints</span>
                    </label>
                    
                    <label class="flex items-center">
                        <input type="radio" name="cancellation_reason" value="Other" class="h-4 w-4 text-cPrimary" x-on:click="otherReason = 'Other'">
                        <span class="ml-2 text-gray-700">Other reason</span>
                    </label>
                    
                    <div x-show="otherReason === 'Other'" x-cloak>
                        <textarea name="cancellation_note" rows="3" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-cPrimary focus:border-transparent" placeholder="Please specify the reason..."></textarea>
                    </div>
                </div>
            </div>
            
            <div class="flex justify-end space-x-3 mt-6">
                <button type="button" @click="showCancelModal = false" class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-cPrimary focus:ring-offset-2">
                    Close
                </button>
                <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2">
                    Cancel Order
                </button>
            </div>
        </form>
    </div>
</div>