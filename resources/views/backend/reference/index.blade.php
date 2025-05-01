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
                        <li class="breadcrumb-item active text-dark-blue" aria-current="page">Reference</li>
                    </ol>
                </nav>
            </div>
        </div>

        <div class="card">
            <div class="card-body p-4">
                <div class="card">
                    <div class="row p-4">
                        <div class="col-md-6">
                            <h6 class="text-dark-blue">Reference Added</h6>
                            <span>No domain added yet.</span>
                        </div>
                        <div class="col-md-6 d-flex justify-content-end align-items-center">
                            <button type="button" class="btn btn-primary radius-30 mt-2 mt-lg-0" data-bs-toggle="modal" data-bs-target="#addReferenceModal">
                                <i class="bx bxs-plus-square"></i> Add Reference
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Table to display references -->
                <div class="table-responsive mt-3">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Reference Name</th>
                                <th>Phone Number</th>
                                <th>Customer Tenant ID</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($references as $reference)
                                <tr>
                                    <td>{{ $reference->reference_name }}</td>
                                    <td>{{ $reference->phone_number }}</td>
                                    <td>{{ $reference->customer_id }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Add Reference Modal -->
<div class="modal fade" id="addReferenceModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add Reference</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{ route('reference.store') }}">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Customer Tenant Id</label>
                        <input type="text" name="customer_id" class="form-control" value="{{ Auth::user()->tenant->name ?? 'No Tenant' }}" required>
                    </div>

                    <!-- Dynamic rows will be inserted here -->
                    <div id="referenceRows"></div>

                    <div class="d-flex justify-content-between mb-3">
                        <button type="button" id="addRow" class="btn btn-primary">Add Reference</button>
                    </div>

                    <div class="d-flex justify-content-between">
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        let rowCount = 0;

        document.getElementById('addRow').addEventListener('click', function () {
            rowCount++;

            const row = `
                <div class="row mb-3 reference-row" data-id="${rowCount}">
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Reference Name</label>
                        <input type="text" name="reference_name[]" class="form-control" required>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Phone Number</label>
                        <input type="text" name="phone_number[]" class="form-control" required>
                    </div>
                    <div class="col-md-4 align-items-end mt-2">
                    </br>
                        <button type="button" class="btn btn-danger removeRow">Delete</button>
                    </div>
                </div>`;

            document.getElementById('referenceRows').insertAdjacentHTML('beforeend', row);
        });

        document.addEventListener('click', function (e) {
            if (e.target && e.target.classList.contains('removeRow')) {
                e.target.closest('.reference-row').remove();
            }
        });
    });
</script>
@endsection
