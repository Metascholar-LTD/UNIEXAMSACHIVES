<x-mail::message>
# {{ $title }}

Hello {{ $user->first_name }} {{ $user->last_name }},

{!! $message !!}

@if($campaign->attachments && count($campaign->attachments) > 0)
<br><br>
**📎 Attached Files:**
@foreach($campaign->attachments as $attachment)
- {{ $attachment['name'] }} ({{ number_format($attachment['size'] / 1024, 1) }} KB)
@endforeach
@endif

<br><br>
Best regards,<br>
{{ config('app.name') }} Administration Team

---
<small>This is an automated email sent from {{ config('app.name') }}. Please do not reply directly to this email.</small>
</x-mail::message>