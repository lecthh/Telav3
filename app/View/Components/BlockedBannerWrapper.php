<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class BlockedBannerWrapper extends Component
{
    public mixed $entity;

    public function __construct(mixed $entity = null)
    {
        $this->entity = $entity;
    }

    public function shouldShowBanner(): bool
    {
        if (!$this->entity) {
            return auth()->check() && auth()->user()->isBlocked();
        }
        return method_exists($this->entity, 'isBlocked') && $this->entity->isBlocked();
    }

    public function render(): View|Closure|string
    {
        return function (array $data) {
            $data['showBanner'] = $this->shouldShowBanner();
            return view('components.blocked-banner-wrapper', $data);
        };
    }
}
