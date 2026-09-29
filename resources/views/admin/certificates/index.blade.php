@extends('layouts.admin')
@section('title','Certificates')
@section('page-title','Certificate Management')
@section('admin-content')
<div class="flex justify-between items-center mb-6">
    <p class="text-sm text-gray-400">{{ $certificates->count() }} certificates</p>
    <a href="{{ route('admin.certificates.create') }}" class="btn-primary text-sm">+ Add Certificate</a>
</div>
<div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-4">
    @forelse($certificates as $cert)
    <div class="admin-card">
        @if($cert->image)
            <img src="{{ Str::startsWith($cert->image,'certificates/') ? asset('storage/'.$cert->image) : asset($cert->image) }}" class="w-full h-36 object-cover rounded-xl mb-4">
        @else
            <div class="w-full h-36 rounded-xl bg-gradient-to-br from-blue-900/30 to-violet-900/30 flex items-center justify-center mb-4">
                <span class="text-4xl">🏆</span>
            </div>
        @endif
        <h3 class="font-semibold text-white mb-0.5">{{ $cert->title }}</h3>
        <p class="text-sm text-gray-400">{{ $cert->issuer }} · {{ $cert->year }}</p>
        <div class="flex gap-3 mt-4">
            <a href="{{ route('admin.certificates.edit',$cert) }}" class="text-xs text-blue-400 hover:text-blue-300">Edit</a>
            <form method="POST" action="{{ route('admin.certificates.destroy',$cert) }}" onsubmit="return confirm('Delete?')">@csrf @method('DELETE')<button class="text-xs text-red-400 hover:text-red-300">Delete</button></form>
        </div>
    </div>
    @empty
    <div class="col-span-3 text-center py-10 text-gray-600">No certificates. <a href="{{ route('admin.certificates.create') }}" class="text-blue-400">Add one</a>.</div>
    @endforelse
</div>
@endsection
