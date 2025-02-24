<a href="{{ $notification->link }}" class="notification-item d-block" data-id="{{ $notification->id }}">
    <div class="title fw-bold">
        {{ $notification->title }}
    </div>
    <div class="time"> {{ \Carbon\Carbon::parse($notification->created_at)->format('d/m/Y H:i') }}</div>
</a>
