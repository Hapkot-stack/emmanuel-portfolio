@extends('layouts.admin')
@section('title', $certificate->exists ? 'Edit Certificate' : 'Add Certificate')
@section('page-title', $certificate->exists ? 'Edit Certificate' : 'Add Certificate')
@section('admin-content')
<div class="max-w-lg">
    <div class="admin-card">
        <form method="POST" action="{{ $certificate->exists ? route('admin.certificates.update',$certificate) : route('admin.certificates.store') }}" enctype="multipart/form-data" class="space-y-4">
            @csrf @if($certificate->exists) @method('PUT') @endif
            <div><label class="form-label">Certificate Title</label><input type="text" name="title" value="{{ old('title',$certificate->title) }}" class="form-input" required></div>
            <div><label class="form-label">Issuing Organisation</label><input type="text" name="issuer" value="{{ old('issuer',$certificate->issuer) }}" class="form-input" required></div>
            <div class="grid sm:grid-cols-2 gap-4">
                <div><label class="form-label">Year</label><input type="text" name="year" value="{{ old('year',$certificate->year) }}" class="form-input" placeholder="2024" required></div>
                <div><label class="form-label">Sort Order</label><input type="number" name="sort_order" value="{{ old('sort_order',$certificate->sort_order??0) }}" class="form-input"></div>
            </div>
            <div><label class="form-label">Credential URL (optional)</label><input type="url" name="credential_url" value="{{ old('credential_url',$certificate->credential_url) }}" class="form-input"></div>
            <div>
                <label class="form-label">Certificate Image</label>
                @if($certificate->image)<img src="{{ Str::startsWith($certificate->image,'certificates/') ? asset('storage/'.$certificate->image) : asset($certificate->image) }}" class="h-24 rounded-xl object-cover mb-2">@endif
                <input type="file" name="image" accept="image/*" class="form-input text-xs">
            </div>
            <div class="flex gap-3 pt-2">
                <button type="submit" class="btn-primary">{{ $certificate->exists ? 'Update' : 'Add' }}</button>
                <a href="{{ route('admin.certificates.index') }}" class="btn-outline">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection
