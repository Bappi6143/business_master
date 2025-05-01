@extends('backend.master')

@section('content')
    <div class="page-wrapper">
        <div class="page-content">
            <!--breadcrumb-->
            <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
                <div class="breadcrumb-title pe-3">eCommerce</div>
                <div class="ps-3">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0 p-0">
                            <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a></li>
                            <li class="breadcrumb-item active text-dark-blue" aria-current="page">Expense</li>
                        </ol>
                    </nav>
                </div>
                <div class="ms-auto">
                    <a href="" class="btn btn-primary"><i class="bx bx-video"></i></a>
                </div>
            </div>

            <div class="card">
                <div class="card-body p-4">

                    @if (session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    <div class="row">
                        <!-- Add Expense -->
                        <div class="col-md-6">
                            <h5 class="text-dark-blue">Add Expense Category</h5>
                            <form action="{{ route('expense-categories.store') }}" method="POST">
                                @csrf
                                <div class="mb-3">
                                    <input type="text" name="name" class="form-control" placeholder="Expense type"
                                        required>
                                </div>
                                <div class="mb-3">
                                    <select name="status" class="form-select" required>
                                        <option value="1" selected>Active</option>
                                        <option value="0">Inactive</option>
                                    </select>
                                </div>
                                <button type="submit" class="btn btn-primary">Add Category</button>
                            </form>


                        </div>

                        <!-- Add Subcategory -->
                        <div class="col-md-6">
                            <h5 class="text-dark-blue">Add Expense</h5>
                            <form method="POST" action="{{ route('expenses-details.store') }}">

                                @csrf
                                <div class="mb-3">
                                    <select name="expense_category_id" class="form-select" required>
                                        <option value="" disabled selected>Select Expense Category</option>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                                        @endforeach
                                    </select>

                                </div>

                                <div class="mb-3">
                                    <input type="date" name="date" class="form-control" required>
                                </div>

                                <div class="mb-3">
                                    <input type="number" name="amount" class="form-control" placeholder="Amount"
                                        step="0.01" required>
                                </div>

                                <div class="mb-3">
                                    <textarea name="details" class="form-control" rows="3" placeholder="Details (optional)"></textarea>
                                </div>
                                <button type="submit" class="btn btn-primary">Add Expense</button>
                            </form>
                        </div>

                    </div>

                    <hr>

                    <!-- Category Table -->
                    <div class="table-responsive" style="overflow: visible !important;">
                        <table id="example2" class="table table-striped table-bordered radius-10">
                            <thead>
                                <tr class="text-center text-dark-blue">
                                    <th>Name</th>
                                    <th>Date</th>
                                    <th>Amount</th>
                                    <th>Details</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>

                                @foreach ($expenses as $expense)
                                    <tr>
                                        <td>{{ $expense->category->name ?? 'N/A' }}</td>
                                        <td>{{ $expense->date }}</td>
                                        <td>{{ number_format($expense->amount, 2) }}</td>
                                        <td>{{ $expense->details }}</td>
                                        <td>
                                            <form action="{{ route('expenses.destroy', $expense->id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger">Delete</button>
                                            </form>
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

    </div>


    <script>
        document.addEventListener("DOMContentLoaded", function() {
            let dropdownButtons = document.querySelectorAll(".dropdown-toggle");

            dropdownButtons.forEach(button => {
                button.addEventListener("click", function() {
                    let dropdownMenu = this.nextElementSibling;

                    // Adjust dropdown position dynamically
                    let rect = dropdownMenu.getBoundingClientRect();
                    let windowHeight = window.innerHeight;

                    if (rect.bottom > windowHeight) {
                        dropdownMenu.classList.add("dropup");
                    } else {
                        dropdownMenu.classList.remove("dropup");
                    }
                });
            });
        });
    </script>
@endsection
