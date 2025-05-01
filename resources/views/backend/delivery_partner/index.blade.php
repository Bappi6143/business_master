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
                        <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a></li>
                        <li class="breadcrumb-item active text-dark-blue" aria-current="page">Delivery Partners</li>
                    </ol>
                </nav>
            </div>
        </div>
        <!-- End Breadcrumb -->

        <div class="row">

            {{-- PATHAO --}}
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body p-4">
                        <form method="POST" action="{{ route('delivery-partners.save', 'pathao') }}">
                            @csrf
                            <input type="hidden" name="slug" value="pathao">
                            <div class="mb-3 d-flex justify-content-between align-items-center">
                                <div class="d-flex align-items-center">
                                    <img src="{{asset('/')}}backend-assets/images/avatars/pathao.png" class="user-img me-2" alt="user avatar">
                                    <div>
                                        <strong class="text-dark-blue">Pathao</strong><br>
                                        <span>Pathao as your shipping partner</span>
                                    </div>
                                </div>
                                @if(isset($partners['pathao']) && $partners['pathao']->status)
                                    <span class="badge bg-success">Active</span>
                                @else
                                    <span class="badge bg-danger">Inactive</span>
                                @endif
                            </div>

                            <div class="mb-3"><label class="form-label">Mail</label><input type="text" name="mail" class="form-control" required></div>
                            <div class="mb-3"><label class="form-label">Password</label><input type="text" name="password" class="form-control"></div>
                            <div class="mb-3"><label class="form-label">Client Id</label><input type="text" name="client_id" class="form-control"></div>
                            <div class="mb-3"><label class="form-label">Client Secret</label><input type="text" name="client_secret" class="form-control"></div>
                            <div class="mb-3"><label class="form-label">Store Id</label><input type="text" name="store_id" class="form-control"></div>

                            <button type="submit" class="btn btn-primary">Save</button>
                        </form>
                    </div>
                </div>
            </div>

            {{-- ECOURIER --}}
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body p-4">
                        <form method="POST" action="{{ route('delivery-partners.save', 'ecourier') }}">
                            @csrf
                            <input type="hidden" name="slug" value="ecourier">
                            <div class="mb-3 d-flex justify-content-between align-items-center">
                                <div class="d-flex align-items-center">
                                    <img src="{{asset('/')}}backend-assets/images/avatars/ecourier.png" class="user-img me-2" alt="user avatar">
                                    <div>
                                        <strong class="text-dark-blue">Ecourier</strong><br>
                                        <span>Ecourier as your shipping partner</span>
                                    </div>
                                </div>
                                @if(isset($partners['ecourier']) && $partners['ecourier']->status)
                                    <span class="badge bg-success">Active</span>
                                @else
                                    <span class="badge bg-danger">Inactive</span>
                                @endif
                            </div>

                            <div class="mb-3"><label class="form-label">User ID</label><input type="text" name="user_id" class="form-control" required></div>
                            <div class="mb-3"><label class="form-label">API Key</label><input type="text" name="api_key" class="form-control"></div>
                            <div class="mb-3"><label class="form-label">API Secret</label><input type="text" name="api_secret" class="form-control"></div>

                            <button type="submit" class="btn btn-primary">Save</button>
                        </form>
                    </div>
                </div>
            </div>

            {{-- STEADFAST --}}
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body p-4">
                        <form method="POST" action="{{ route('delivery-partners.save', 'steadfast') }}">
                            @csrf
                            <input type="hidden" name="slug" value="steadfast">
                            <div class="mb-3 d-flex justify-content-between align-items-center">
                                <div class="d-flex align-items-center">
                                    <img src="{{asset('/')}}backend-assets/images/avatars/steadfast.png" class="user-img me-2" alt="user avatar">
                                    <div>
                                        <strong class="text-dark-blue">Steadfast</strong><br>
                                        <span>Steadfast as your shipping partner</span>
                                    </div>
                                </div>
                                @if(isset($partners['steadfast']) && $partners['steadfast']->status)
                                    <span class="badge bg-success">Active</span>
                                @else
                                    <span class="badge bg-danger">Inactive</span>
                                @endif
                            </div>

                            <div class="mb-3"><label class="form-label">API Key</label><input type="text" name="api_key" class="form-control"></div>
                            <div class="mb-3"><label class="form-label">API Secret</label><input type="text" name="api_secret" class="form-control"></div>

                            <button type="submit" class="btn btn-primary">Save</button>
                        </form>
                    </div>
                </div>
            </div>

            {{-- REDX --}}
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body p-4">
                        <form method="POST" action="{{ route('delivery-partners.save', 'redx') }}">
                            @csrf
                            <input type="hidden" name="slug" value="redx">
                            <div class="mb-3 d-flex justify-content-between align-items-center">
                                <div class="d-flex align-items-center">
                                    <img src="{{asset('/')}}backend-assets/images/avatars/redx.png" class="user-img me-2" alt="user avatar">
                                    <div>
                                        <strong class="text-dark-blue">Redx</strong><br>
                                        <span>Redx as your shipping partner</span>
                                    </div>
                                </div>
                                @if(isset($partners['redx']) && $partners['redx']->status)
                                    <span class="badge bg-success">Active</span>
                                @else
                                    <span class="badge bg-danger">Inactive</span>
                                @endif
                            </div>

                            <div class="mb-3"><label class="form-label">JWT Token</label><input type="text" name="jwt_token" class="form-control" required></div>

                            <button type="submit" class="btn btn-primary">Save</button>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<style>
    .badge {
        padding: 6px 12px;
        font-size: 0.8rem;
        font-weight: 600;
        border-radius: 30px;
    }
</style>
@endsection
