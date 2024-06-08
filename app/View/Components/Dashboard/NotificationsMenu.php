<?php

namespace App\View\Components\Dashboard;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class NotificationsMenu extends Component
{
    public $notifications;
    public $newCount;
    /**
     * Create a new component instance.
     */
    public function __construct(int $count = 10)
    {
        $user = auth()->user();
        $this->notifications = $user->notifications()->take($count)->get();
        $this->newCount = $user->unReadNotifications()->count();
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.dashboard.notifications-menu');
    }
}