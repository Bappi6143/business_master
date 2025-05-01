@extends('backend.master')

@section('content')
<div class="page-wrapper">
    <div class="page-content">
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="breadcrumb-title pe-3">Settings</div>
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="bx bx-home-alt"></i></a></li>
                        <li class="breadcrumb-item active text-dark-blue" aria-current="page">Website Setting</li>
                    </ol>
                </nav>
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <form action="{{ route('settings.update') }}" method="POST" enctype="multipart/form-data">
            @csrf
        
            <div class="row">
        
                <!-- Left: Header Section -->
                <div class="col-md-6">
                    <div class="card shadow-sm mb-4 border-0">
                        <div class="card-header text-white rounded-top">
                            <h6 class="mb-0 text-dark-blue">🧩 Header Information</h6>
                        </div>
                        <div class="card-body p-4 row">
                            <div class="mb-3">
                                <label class="form-label">Logo</label><br>
                                @if($logo)
                                    <img src="{{ asset($logo) }}" width="120" class="mb-2" alt="Logo">
                                @endif
                                <input type="file" name="logo" class="form-control">
                            </div>
                            <div class="mb-3 col-md-6">
                                <label class="form-label">Header Text</label>
                                <input type="text" name="header_text" value="{{ $header_text }}" class="form-control" placeholder="Enter header text">
                            </div>
                            <div class="mb-3 col-md-6">
                                <label class="form-label">Customer Service Number</label>
                                <input type="text" name="customer_service_number" value="{{ $customer_service_number }}" class="form-control" placeholder="Enter phone number">
                            </div>
                        </div>
                    </div>
                </div>
        
                <!-- Right: Banner Upload Section -->
                <div class="col-md-6">
                    <div class="card shadow-sm mb-4 border-0">
                        <div class="card-header text-white rounded-top">
                            <h6 class="mb-0 text-dark-blue">🖼️ Homepage Banner</h6>
                        </div>
                        <div class="card-body p-4">
                            <div class="mb-3">
                                <label class="form-label">Upload Multiple Banner Images</label>
                                <input type="file" name="hero_banners[]" class="form-control" multiple accept="image/*">
                                <small class="text-muted">Recommended: 1600x450px, max 3 banners.</small>
                            </div>
                            @php
                                $banners = json_decode(\App\Models\Setting::getValue('hero_banners'), true);
                            @endphp
                            @if($banners)
                            <div class="mt-3">
                                <label class="form-label">Current Banners:</label>
                                <div class="d-flex flex-wrap gap-2">
                                    @foreach($banners as $banner)
                                        <img src="{{ asset($banner) }}" width="150" height="80" style="object-fit:cover; border: 1px solid #ccc;">
                                    @endforeach
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
        
                <!-- Left: Footer Section -->
                <div class="col-md-6">
                    <div class="card shadow-sm mb-4 border-0">
                        <div class="card-header text-white rounded-top">
                            <h6 class="mb-0 text-dark-blue">📃 Footer Information</h6>
                        </div>
                        <div class="card-body p-4">
                            <div class="mb-3">
                                <label class="form-label">Company Information</label>
                                <textarea name="company_imformation" class="form-control" rows="2" placeholder="Write company info">{{ $company_imformation }}</textarea>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Footer Copy Right Text</label>
                                <textarea name="footer_text" class="form-control" rows="2" placeholder="Write copyright">{{ $footer_text }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>
        
                <!-- Right: Social Media Section -->
                <div class="col-md-6">
                    <div class="card shadow-sm mb-4 border-0">
                        <div class="card-header text-white rounded-top">
                            <h6 class="mb-0 text-dark-blue">🌐 Social Media Links</h6>
                        </div>
                        <div class="card-body p-4 row g-3">
                            @php
                                $socials = [
                                    'Facebook' => ['customer_facebook', 'fb.png'],
                                    'YouTube' => ['customer_youtube', 'yt.png'],
                                    'TikTok' => ['customer_tiktok', 'tk.png'],
                                    'Instagram' => ['customer_instagram', 'ig.png'],
                                    'WhatsApp' => ['customer_whatsapp', 'whatsapp.png']
                                ];
                            @endphp
                            @foreach($socials as $label => [$field, $icon])
                                <div class="col-md-12 d-flex align-items-center gap-2">
                                    <img src="{{ asset('backend-assets/images/avatars/' . $icon) }}" width="28">
                                    <input type="text" name="{{ $field }}" value="{{ $$field }}" class="form-control" placeholder="{{ $label }} Link">
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
        
            </div>
        
            <!-- Submit Button -->
            <div class="text-end mt-3">
                <button type="submit" class="btn btn-primary btn-lg px-5">Update</button>
            </div>
        </form>
        
    </div>
</div>
@endsection