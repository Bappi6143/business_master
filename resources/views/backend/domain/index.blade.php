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
                        <li class="breadcrumb-item active text-dark-blue" aria-current="page">Domain Setting</li>
                    </ol>
                </nav>
            </div>
        </div>

        <div class="card">
            <div class="card-body p-4">
                <div class="card">
                    <div class="row p-4">
                        <div class="col-md-6">
                            <h6 class="text-dark-blue">Custom Domain</h6>
                            <span>No domain added yet.</span>
                        </div>
                        <div class="col-md-6 d-flex justify-content-end align-items-center">
                            <button type="button" class="btn btn-primary radius-30 mt-2 mt-lg-0" data-bs-toggle="modal" data-bs-target="#addDomainModal">
                                <i class="bx bxs-plus-square"></i> Add Custom Domain
                            </button>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="row p-4">
                        <div class="col-md-6">
                            <h6 class="text-dark-blue">Need a Custom domain?</h6>
                            <span>Purchase a domain from us and make it running in just 5 minutes.</span>
                        </div>
                        <div class="col-md-6 d-flex justify-content-end align-items-center">
                            <button type="button" class="btn btn-primary radius-30 mt-2 mt-lg-0">
                                <i class="bx bxs-plus-square"></i> Buy Now
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Add Custom Domain Modal -->
<div class="modal fade" id="addDomainModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add Custom Domain</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form method="POST" action="#">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label">Customer Domain</label>
                        <input type="text" name="customer_domain" class="form-control" placeholder="example.com" required>
                    </div>

                    <span>To point an apex domain such as mystore.com or a subdomain such as www.mystore.com to your store on Redshop, you must create a A record with your DNS provider.</span>
                    </br>

                    <span>To point a domain to your Redshop store, create an A record with the IP address 103.181.194.5</span>
                    </br>

                    <span>You can have only one A record associated with your primary domain. If your domain is already associated with an A record, amend it to the Redshop IP address.</span>
                    </br></br>

                    <h6>Step 1</h6>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Type</label>
                            <input type="text" name="dns_type" class="form-control" placeholder="" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Host</label>
                            <input type="text" name="dns_host" class="form-control" placeholder="www, @, subdomain" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Value</label>
                            <input type="text" name="dns_value" class="form-control" placeholder="Destination or IP address" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">TTL</label>
                            <input type="number" name="dns_ttl" class="form-control" placeholder="300" required>
                        </div>
                    </div>

                    </br></br>

                    <h6>Step 2</h6>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Type</label>
                            <input type="text" name="dns_type" class="form-control" placeholder="" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Host</label>
                            <input type="text" name="dns_host" class="form-control" placeholder="www, @, subdomain" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Value</label>
                            <input type="text" name="dns_value" class="form-control" placeholder="Destination or IP address" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">TTL</label>
                            <input type="number" name="dns_ttl" class="form-control" placeholder="300" required>
                        </div>
                    </div>


                    <div class="d-flex justify-content-between">
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>



@endsection