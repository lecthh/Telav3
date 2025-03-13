@include('head')

<footer class="flex gap-x-[10px] px-[100px] py-6 bg-cNot-black text-white justify-start">
    <div class="flex flex-col gap-y-[10px] text-sm">
        <h1 class="font-inter font-bold">Site Links</h1>
        <ul class="flex gap-x-6">
            <li class=""><a wire:navigate href="{{ route('home') }}">Home</a></li>
            <li class=""><a wire:navigate href="{{ route('customer.place-order.select-apparel') }}">Start Your Custom Order</a></li>
            <li class=""><a href="{{ route('production.services') }}">Browse Production Services</a></li>
            <li class=""><a wire:navigate href="{{ route('partner-registration') }}">Become a Partner</a></li>
            @guest
            <li class=""><a href="{{ route('login') }}">Business Hub</a></li>
            @endguest
        </ul>
    </div>
</footer>

<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<!-- for Livewire components -->
<script>
    document.addEventListener('toast', event => {
        console.log('Toast event received:', event.detail);
        let detail = Array.isArray(event.detail) ? event.detail[0] : event.detail;

        toastr.options = {
            "closeButton": true,
            "progressBar": true,
            "positionClass": "toast-top-right"
        };

        const type = (detail.type || 'success').toLowerCase().trim();
        const allowedTypes = ['success', 'error', 'info', 'warning'];

        if (allowedTypes.includes(type) && typeof toastr[type] === 'function') {
            toastr[type](detail.message);
        } else {
            console.error(`Toastr method '${type}' is not a function or is not recognized.`);
        }
    });
</script>
<!-- For normal Laravel Controllers -->
@if(session('toast'))
<script>
    $(document).ready(function() {
        toastr.options = {
            "closeButton": true,
            "progressBar": true,
            "positionClass": "toast-top-right"
        };
        toastr["{{ session('toast')['type'] }}"]("{{ session('toast')['message'] }}");
    });
</script>
@endif




@livewireScripts
@vite(['resources/js/app.js'])
@include('chat.chat-widget')