<x-mail::message>
# Your Ad Has Been Created!

Hello {{ $ad->user->name }},

Your ad has been successfully created and is now live on {{ config('app.name') }}. Here are the details:

**Title:** {{ $ad->title }}
**Category:** {{ $ad->category->name }}
**Price:** ${{ number_format($ad->price, 2) }}
**Condition:** {{ ucfirst($ad->condition->value) }}
**Location:** {{ $ad->location }}

<x-mail::button :url="route('ads.show', $ad->id)">
View Your Ad
</x-mail::button>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>