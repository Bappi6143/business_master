@extends('backend.master')

@section('content')
<div class="page-wrapper">
    <div class="page-content">
        <!-- Breadcrumb -->
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="breadcrumb-title pe-3">Settings</div>
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="bx bx-home-alt"></i></a></li>
                        <li class="breadcrumb-item active text-dark-blue" aria-current="page">Policies Setting</li>
                    </ol>
                </nav>
            </div>
        </div>

        <!-- Policies Form -->
        <div class="card">
            <div class="card-body p-4">
                <form method="POST" action="{{ route('policies.store') }}">
                    @csrf
                    <!-- Terms and Conditions -->
                    <div class="card mb-3">
                        <div class="row p-4">
                            <div class="mb-3 col-md-12">
                                <h6 class="text-dark-blue">Terms and Conditions</h6>
                                <textarea name="terms_conditions" class="form-control rich-text" required>
                                    {{ old('terms_conditions', $policy->terms_conditions ?? '') }}
                                </textarea>
                            </div>
                        </div>
                    </div>

                    <!-- Privacy Policy -->
                    <div class="card mb-3">
                        <div class="row p-4">
                            <div class="mb-3 col-md-12">
                                <h6 class="text-dark-blue">Privacy Policy</h6>
                                <textarea name="privacy_policy" class="form-control rich-text" required>
                                    {{ old('privacy_policy', $policy->privacy_policy ?? '') }}
                                </textarea>
                            </div>
                        </div>
                    </div>

                    <!-- Refund Policy -->
                    <div class="card mb-3">
                        <div class="row p-4">
                            <div class="mb-3 col-md-12">
                                <h6 class="text-dark-blue">Refund Policy</h6>
                                <textarea name="refund_policy" class="form-control rich-text" required>
                                    {{ old('refund_policy', $policy->refund_policy ?? '') }}
                                </textarea>
                            </div>
                        </div>
                    </div>

                    <div class="text-center">
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Load CKEditor -->
<script src="https://cdn.ckeditor.com/ckeditor5/36.0.1/classic/ckeditor.js"></script>

<script>
    window.onload = function() {
        // Initialize CKEditor for all textareas with class 'rich-text'
        document.querySelectorAll('.rich-text').forEach(function(textarea) {
            ClassicEditor
                .create(textarea, {
                    toolbar: [
                        'undo', 'redo', 'bold', 'italic', 'underline', 'strikethrough', 'link',
                        'bulletedList', 'numberedList', 'blockQuote', 'alignment', 'fontSize', 'fontFamily',
                        'textColor', 'highlight', 'insertImage', 'insertTable', 'mediaEmbed', 'codeBlock',
                        'code', 'removeFormat', 'fontBackgroundColor'
                    ],
                    image: {
                        toolbar: ['imageTextAlternative', 'imageStyle:full', 'imageStyle:side']
                    },
                    table: {
                        contentToolbar: ['tableColumn', 'tableRow', 'mergeTableCells']
                    },
                    mediaEmbed: {
                        previewsInData: true
                    }
                })
                .catch(error => {
                    console.error("Error initializing CKEditor:", error);
                });
        });
    };
</script>

@endsection
