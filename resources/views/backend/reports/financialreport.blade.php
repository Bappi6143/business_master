@extends('backend.master')

@section('content')
<div class="page-wrapper">
    <div class="page-content">
        <!--breadcrumb-->
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="breadcrumb-title pe-3">Reports</div>
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a></li>
                        <li class="breadcrumb-item active" aria-current="page">Financial Report</li>
                    </ol>
                </nav>
            </div>
        </div>
        <!--end breadcrumb-->

        <div class="card">
            <div class="card-body">
                <div class="d-lg-flex align-items-center mb-4 gap-3">
                </div>
                <div class="table-responsive">
                    <table id="example2" class="table table-striped table-bordered radius-10">
                        <thead>
                            <tr class="text-center text-dark-blue" >
                                <th>Date</th>
                                <th>Name</th>
                                <th>Details</th>
                                <th>Amount</th>
                               
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($expenses as $expense)
                            <tr class="text-center">
                                <td>{{ \Carbon\Carbon::parse($expense->date)->format('d M Y') }}</td>
                                <td>{{ $expense->category->name ?? 'N/A' }}</td>
                                <td>{{ $expense->details ?? '-' }}</td>
                                <td>${{ number_format($expense->amount, 2) }}</td>
                                
                            </tr>
                            @empty
                            <tr class="text-center">
                                <td colspan="4">No expense records found.</td>
                            </tr>
                            @endforelse
                        </tbody>
                        <tfoot>
                        <tr class="fw-bold text-dark-blue">
    <td colspan="3" class="text-end">Total</td>
    <td class="text-center">${{ number_format($expenses->sum('amount'), 2) }}</td>
</tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection