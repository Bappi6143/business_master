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
                        <li class="breadcrumb-item active text-dark-blue" aria-current="page">Bonus</li>
                    </ol>
                </nav>
            </div>
        </div>

        <div class="card">
            <div class="card-body p-4">
                <!-- Table to display references -->
                <div class="table-responsive mt-3">
                    <table class="table table-bordered">
                        <thead>
                            <tr class="text-dark-blue">
                                <th>Customer Tenant ID</th>
                                <th>Reference Name</th>
                                <th>Phone Number</th>
                            </tr>
                        </thead>
                        <tbody>
    @foreach ($groupedBonus as $customerId => $references)
        <tr>
            <td>{{ $customerId }}</td>
            <td>
                @foreach ($references as $ref)
                    <div>{{ $ref->reference_name }}</div>
                @endforeach
            </td>
            <td>
                @foreach ($references as $ref)
                    <div>{{ $ref->phone_number }}</div>
                @endforeach
            </td>
        </tr>
    @endforeach
</tbody>

                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
