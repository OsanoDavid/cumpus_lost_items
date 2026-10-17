@extends('layouts.app')

@section('title', 'My Notifications — Kisii University Lost & Found')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-slate-50 via-emerald-50/30 to-slate-100 py-10 px-4">
    <div class="max-w-3xl mx-auto">

        {{-- Page Header --}}
        <div class="flex items-center gap-4 mb-8">
            <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-emerald-600 to-teal-700 flex items-center justify-center shadow-lg">
                <i class="fa-solid fa-bell text-white text-lg"></i>
            </div>
            <div>
                <h1 class="text-2xl font-extrabold text-slate-900">Notification Inbox</h1>
                <p class="text-sm text-slate-500">Messages from Campus Security Administration</p>
            </div>
        </div>

        @if($messages->isEmpty())
            {{-- Empty State --}}
            <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-16 text-center">
                <div class="w-20 h-20 rounded-full bg-emerald-50 flex items-center justify-center mx-auto mb-4">
                    <i class="fa-regular fa-bell-slash text-3xl text-emerald-400"></i>
                </div>
                <h2 class="text-xl font-bold text-slate-700 mb-2">No Notifications Yet</h2>
                <p class="text-slate-400 text-sm max-w-sm mx-auto">
                    When the administration approves or denies a claim, or sends you a message, it will appear here.
                </p>
                <a href="{{ route('dashboard.seeker') }}" class="mt-6 inline-flex items-center gap-2 bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-semibold px-6 py-2.5 rounded-xl transition shadow-md">
                    <i class="fa-solid fa-arrow-left"></i> Back to Dashboard
                </a>
            </div>
        @else
            <div class="space-y-4">
                @foreach($messages as $msg)
                    @php
                        $isApproved  = str_contains($msg->subject, 'Approved') || str_contains($msg->subject, '✅');
                        $isRejected  = str_contains($msg->subject, 'Denied') || str_contains($msg->subject, '❌');
                        $borderColor = $isApproved ? 'border-l-emerald-500' : ($isRejected ? 'border-l-red-500' : 'border-l-blue-500');
                        $iconBg      = $isApproved ? 'bg-emerald-100 text-emerald-600' : ($isRejected ? 'bg-red-100 text-red-600' : 'bg-blue-100 text-blue-600');
                        $icon        = $isApproved ? 'fa-circle-check' : ($isRejected ? 'fa-circle-xmark' : 'fa-envelope');
                    @endphp
                    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 border-l-4 {{ $borderColor }} overflow-hidden">
                        <div class="p-6">
                            {{-- Header --}}
                            <div class="flex items-start gap-4">
                                <div class="w-11 h-11 rounded-xl {{ $iconBg }} flex items-center justify-center flex-shrink-0 text-lg shadow-sm">
                                    <i class="fa-solid {{ $icon }}"></i>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <div class="flex items-center justify-between gap-2 flex-wrap">
                                        <h2 class="text-sm font-bold text-slate-800">{{ $msg->subject }}</h2>
                                        <span class="text-[11px] text-slate-400 whitespace-nowrap">{{ $msg->created_at->diffForHumans() }}</span>
                                    </div>
                                    <p class="text-[11px] text-slate-400 mt-0.5">
                                        From: <span class="font-medium text-slate-600">{{ $msg->sender->name ?? 'Campus Security' }}</span>
                                        @if($msg->claim && $msg->claim->item)
                                            &nbsp;·&nbsp; Re: <span class="font-medium text-slateald-600">{{ $msg->claim->item->title }}</span>
                                        @endif
                                    </p>
                                </div>
                            </div>

                            {{-- Body --}}
                            <div class="mt-4 bg-slate-50 rounded-xl p-4 text-xs text-slate-700 leading-relaxed whitespace-pre-line border border-slate-100">
                                {{ $msg->body }}
                            </div>

                            {{-- Actions --}}
                            <div class="mt-4 flex items-center gap-3 flex-wrap">
                                @if($isApproved && $msg->claim && $msg->claim->item)
                                    <a href="{{ route('items.show', $msg->claim->item) }}"
                                       class="inline-flex items-center gap-2 bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-semibold px-4 py-2 rounded-lg transition shadow-md">
                                        <i class="fa-solid fa-box-open"></i> View Claimed Item
                                    </a>
                                @elseif($isRejected)
                                    <a href="{{ route('items.index') }}"
                                       class="inline-flex items-center gap-2 bg-slate-700 hover:bg-slate-800 text-white text-xs font-semibold px-4 py-2 rounded-lg transition">
                                        <i class="fa-solid fa-magnifying-glass"></i> Browse Items
                                    </a>
                                @else
                                    <a href="{{ route('dashboard.seeker') }}"
                                       class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white text-xs font-semibold px-4 py-2 rounded-lg transition">
                                        <i class="fa-solid fa-gauge-high"></i> Go to Dashboard
                                    </a>
                                @endif

                                <span class="text-[10px] text-slate-400 flex items-center gap-1">
                                    <i class="fa-solid fa-location-dot text-emerald-500"></i>
                                    Visit: Main Administration Block, Kisii University
                                </span>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="mt-6 text-center">
                <a href="{{ route('dashboard.seeker') }}" class="text-sm text-emerald-600 hover:underline font-medium">
                    <i class="fa-solid fa-arrow-left mr-1 text-xs"></i> Back to My Dashboard
                </a>
            </div>
        @endif

    </div>
</div>
@endsection
