@extends("backend.layouts")
@section("title", "Dashboard")
@section("content-title", "Orders")
@section('css')
    <link href="https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css" rel="stylesheet">
@endsection
@section("content")

<!-- DataTales Example -->
<div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">List Orders</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Invoice No</th>
                            <th>User</th>
                            <th>Category Product</th>
                            <th>Price Total</th>
                            <th>Quantity</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                       @forelse ($orders as $key => $item)
                            <tr>
                                <td>{{ $item->invoice_no }}</td>
                                <td>{{ $item->user ? $item->user->email : "" }}</td>
                                <td>{{ $item->product ? ($item->product->category ? $item->product->category->name  : "") : "" }}</td>
                                <td>Rp.{{ number_format($item->price_total, 0) }}</td>
                                <td>{{ $item->quantity }}</td>
                                <td>
                                    <a href="{{ url("/backend/orders/detail/" . $item->id) }}" class="btn btn-primary btn-sm ml-3"><i class="fa fa-eye"></i></a>
                                </td>
                            </tr>
                       @empty
                           <tr>
                               <td colspan="6" class="text center">Data Not Found!</td>
                           </tr>
                       @endforelse 
                    </tbody>
                </table>
                <div class="text-center">
                    {!! $orders->appends($_GET)->links() !!}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('js')
<script>
        const sessionStatus  = "{{ Session::has('status') }}"
        const sessionMessage = "{{ Session::get('status') }}"
        const sessionClass   = "{{ Session::get('alert-class') }}"

        if(sessionStatus) {
            Swal.fire(
                sessionClass == "danger" ? "Opps!" : "Success!" ,
                sessionMessage,
                sessionClass
            )
        }

        $('#onSubmit').submit((e) => {
            let category     = $('#category-name').val();
            let categorySlug = $('#slug-category').val();
            let isActive    = $('#is_active').val();
            let mainImage   = $('#main_image').files();

            console.log(mainImage)


            e.preventDefault();
            return false;
        })

    </script>
@endsection