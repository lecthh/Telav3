@auth
@if(auth()->user()->isBlocked())
@livewire('blocked-banner', ['contactEmail' => 'support@example.com'])
@endif
@endauth