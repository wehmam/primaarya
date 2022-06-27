@extends("backend.layouts")
@section("title", "Dashboard")
@section("content-title", "Activity Logs")
@section('css')
    <link href="https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css" rel="stylesheet">
@endsection
@section("content")

<!-- DataTales Example -->
<div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Activity Users<span class="float-right"> <a href="{{ url("backend/export-csv/activity-logs") }}" class="btn btn-success btn-sm" ><i class="fas fa-file-excel mr-2"> Export CSV</i></a></span></h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Log Name</th>
                            <th>Description</th>
                            <th>Product Id</th>
                            <th>Product Name</th>
                            <th>Category Id</th>
                            <th>Category Name</th>
                            <th>Causer Id</th>
                            <th>Email</th>
                            <th>Date / Time</th>
                        </tr>
                    </thead>
                    <tbody>
                       @forelse ($activityLogs as $key => $item)
                            <tr>
                                <td>{{ $item->id }}</td>
                                <td>{{ $item->log_name }}</td>
                                <td>{{ $item->description }}</td>
                                <td>{{ $item->category_id ?? "-" }}</td>
                                <td>{{ $item->category->name ?? "-" }}</td>
                                <td>{{ $item->product_id ?? "-" }}</td>
                                <td>{{ $item->product->title ?? "-" }}</td>
                                <td>{{ $item->causer_id }}</td>
                                <td>{{ $item->user->email ?? "-" }}</td>
                                <td>{{ $item->created_at }}</td>
                            </tr>
                       @empty
                           <tr>
                               <td colspan="6" class="text center">Data Not Found!</td>
                           </tr>
                       @endforelse
                    </tbody>
                </table>
                <div class="text-center">
                    {!! $activityLogs->appends($_GET)->links() !!}
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
