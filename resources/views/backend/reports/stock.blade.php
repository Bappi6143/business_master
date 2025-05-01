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
                        <li class="breadcrumb-item active" aria-current="page">Stock Report</li>
                    </ol>
                </nav>
            </div>
        </div>
        <!--end breadcrumb-->

        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table id="example2" class="table table-striped table-bordered radius-10">
                        <thead>
                            <tr class="text-dark-blue">
                                <th>Product Name</th>
                                <th>Category</th>
                                <th>Sub-Category</th>
                                <th>Variant</th>
                                <th>Quantity In Stock</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($products as $product)
                            <tr>
                                <td>{{ $product->title }}</td>

                                <td>{{ $product->category->name ?? 'N/A' }}</td>

                                <td>{{ $product->subcategory->name ?? 'N/A' }}</td>

                                <td>
                                    @php
                                    $variantDisplay = [];

                                    $items = is_array($product->variant_items)
                                    ? $product->variant_items
                                    : json_decode($product->variant_items, true);

                                    if (is_array($items)) {
                                    foreach ($items as $item) {
                                    $variant = \App\Models\Variant::find($item['variant_id'] ?? 0);
                                    $value = \App\Models\VariantValue::find($item['variant_value_id'] ?? 0);
                                    if ($variant && $value) {
                                    $variantDisplay[] = $variant->name . ' - ' . $value->name;
                                    }
                                    }
                                    }
                                    @endphp
                                    {!! count($variantDisplay) ? implode('<br>', $variantDisplay) : 'N/A' !!}
                                </td>


                                <td>{{ $product->stock_quantity }}</td>

                                <td>
                                    @if($product->stock_quantity > ($product->reorder_level ?? 0))
                                    <span class="badge bg-success">In Stock</span>
                                    @else
                                    <span class="badge bg-warning">Low Stock</span>
                                    @endif
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