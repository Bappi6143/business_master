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
            <li class="breadcrumb-item active text-dark-blue" aria-current="page">Products</li>
          </ol>
        </nav>
      </div>
      <div class="ms-auto">
        <a href="{{ route('products.create') }}" class="btn btn-primary"><i class="bx bxs-plus-square"></i> Add New Product</a>
      </div>
    </div>
    <!--end breadcrumb-->

    <div class="card">
      <div class="card-body">
        <div class="table-responsive m-2" style="overflow: visible !important;">
          <table id="example2" class="table table-striped table-bordered radius-10">
            <thead class="text-center text-dark-blue">
              <tr class="mt-4">
                <th>Image</th>
                <th>SKU</th>
                <th>Title</th>
                <th>Category</th>
                <th>Subcategory</th>
                <th>Price</th>
                <th>Variants</th>
                <th>Status</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($products as $product)
              <tr class="text-center">
                <td>
                  @if ($product->image)
                  <img src="{{ asset($product->image) }}" alt="Product Image" class="product-img-2" style="height: 60px;">
                  @else
                  N/A
                  @endif
                </td>
                <td>{{ $product->code }}</td>
                <td>{{ $product->title }}</td>
                <td>{{ $product->category->name ?? 'N/A' }}</td>
                <td>{{ $product->subcategory->name ?? 'N/A' }}</td>
                <td>{{ $product->price }}</td>
                <td>
                  @php
                  $variantDisplay = [];

                  $variantItems = is_array($product->variant_items)
                  ? $product->variant_items
                  : json_decode($product->variant_items, true); // fallback to decode string

                  if (is_array($variantItems)) {
                  foreach ($variantItems as $item) {
                  $variant = \App\Models\Variant::find($item['variant_id'] ?? 0);
                  $variantValue = \App\Models\VariantValue::find($item['variant_value_id'] ?? 0);
                  if ($variant && $variantValue) {
                  $variantDisplay[] = "{$variant->name} - {$variantValue->name}";
                  }
                  }
                  }
                  @endphp

                  {!! !empty($variantDisplay) ? implode('<br>', $variantDisplay) : 'N/A' !!}

                </td>

                <td>{{ ucfirst($product->status) }}</td>
                <td class="text-center">
                  <div class="dropdown">
                    <button class="btn btn-light btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown">
                      <i class="bx bx-dots-vertical-rounded"></i>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end">
                      <li><a href="{{ route('products.edit', $product->id) }}" class="dropdown-item">Edit</a></li>
                      <li>
                        <form action="{{ route('products.destroy', $product->id) }}" method="POST" class="d-inline">
                          @csrf @method('DELETE')
                          <button type="submit" class="dropdown-item text-danger" onclick="return confirm('Are you sure?')">Delete</button>
                        </form>
                      </li>
                    </ul>
                  </div>
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