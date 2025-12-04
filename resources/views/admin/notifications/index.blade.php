@extends('layouts.admin')

@section('title', 'Semua Notifikasi')

@section('content')
<div class="page-header">
    <div class="page-header-left">
        <h1 class="page-title">Notifikasi</h1>
        <p class="page-subtitle">Semua aktivitas dari web dan mobile</p>
    </div>
    <div class="page-header-right">
        <form action="{{ route('admin.notifications.mark-all-read') }}" method="POST" style="display: inline;">
            @csrf
            <button type="submit" class="btn btn-outline">
                <i class="bi bi-check-all"></i> Tandai Semua Dibaca
            </button>
        </form>
    </div>
</div>

<div class="card">
    <div class="card-body" style="padding: 0;">
        @forelse($notifications as $notification)
        <div class="notification-row {{ !$notification->is_read ? 'unread' : '' }}" style="display: flex; align-items: flex-start; gap: 16px; padding: 16px 20px; border-bottom: 1px solid var(--border-color); {{ !$notification->is_read ? 'background: rgba(79, 70, 229, 0.03);' : '' }}">
            <div style="width: 44px; height: 44px; border-radius: 10px; display: flex; align-items: center; justify-content: center; font-size: 20px; flex-shrink: 0; {{ $notification->source === 'mobile' ? 'background: #dbeafe; color: #2563eb;' : 'background: #dcfce7; color: #16a34a;' }}">
                <i class="bi {{ $notification->icon ?? 'bi-bell' }}"></i>
            </div>
            <div style="flex: 1; min-width: 0;">
                <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 4px;">
                    <span style="font-weight: 600; font-size: 14px;">{{ $notification->title }}</span>
                    @if(!$notification->is_read)
                    <span style="background: var(--primary-color); color: white; font-size: 10px; padding: 2px 6px; border-radius: 4px;">Baru</span>
                    @endif
                </div>
                <p style="margin: 0 0 8px; color: var(--text-muted); font-size: 13px;">{{ $notification->message }}</p>
                <div style="display: flex; align-items: center; gap: 16px; font-size: 12px; color: var(--text-muted);">
                    <span>
                        <i class="bi {{ $notification->source === 'mobile' ? 'bi-phone' : 'bi-globe' }}"></i>
                        {{ $notification->source === 'mobile' ? 'Mobile App' : 'Web Admin' }}
                    </span>
                    <span>
                        <i class="bi bi-clock"></i>
                        {{ $notification->created_at->diffForHumans() }}
                    </span>
                </div>
            </div>
            <div style="display: flex; gap: 8px; flex-shrink: 0;">
                @if($notification->link)
                <a href="{{ $notification->link }}" class="btn btn-sm btn-primary" onclick="markAsRead({{ $notification->id }})">
                    <i class="bi bi-eye"></i> Lihat
                </a>
                @endif
                @if(!$notification->is_read)
                <form action="{{ route('admin.notifications.mark-read', $notification) }}" method="POST" style="display: inline;">
                    @csrf
                    <button type="submit" class="btn btn-sm btn-outline" title="Tandai dibaca">
                        <i class="bi bi-check"></i>
                    </button>
                </form>
                @endif
                <form action="{{ route('admin.notifications.destroy', $notification) }}" method="POST" style="display: inline;" onsubmit="return confirm('Hapus notifikasi ini?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-sm btn-outline" style="color: #ef4444; border-color: #ef4444;" title="Hapus">
                        <i class="bi bi-trash"></i>
                    </button>
                </form>
            </div>
        </div>
        @empty
        <div style="padding: 60px 20px; text-align: center;">
            <i class="bi bi-bell-slash" style="font-size: 48px; color: var(--text-muted);"></i>
            <p style="margin: 16px 0 0; color: var(--text-muted);">Belum ada notifikasi</p>
        </div>
        @endforelse
    </div>
</div>

@if($notifications->hasPages())
<div style="display: flex; justify-content: center; margin-top: 20px;">
    {{ $notifications->links() }}
</div>
@endif

@push('scripts')
<script>
function markAsRead(id) {
    fetch(`{{ url('admin/notifications') }}/${id}/read`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Content-Type': 'application/json'
        }
    });
}
</script>
@endpush
@endsection
