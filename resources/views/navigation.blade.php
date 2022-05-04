<div class="flex items-center font-normal dim text-white mb-6 text-base no-underline">
    <svg class="sidebar-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 22 22">
        <path fill="var(--sidebar-icon)"
              d="M20 22H4a2 2 0 0 1-2-2v-8c0-1.1.9-2 2-2h4V8c0-1.1.9-2 2-2h4V4c0-1.1.9-2 2-2h4a2 2 0 0 1 2 2v16a2 2 0 0 1-2 2zM14 8h-4v12h4V8zm-6 4H4v8h4v-8zm8-8v16h4V4h-4z"/>
    </svg>

    <span class="sidebar-label">
        {{ $label }}
</span>
</div>
@foreach($dashboards as $dash)
<router-link tag="h3"
             :to="{name: 'metabase-dashboard', params: {identifier: '{{ $dash->getIdentifier() }}' }}"
             class="cursor-pointer ml-8 mb-4 text-xs text-white-50% uppercase">
    <span class="sidebar-label">
        {{ $dash->getLabel() }}
    </span>
</router-link>
@endforeach
