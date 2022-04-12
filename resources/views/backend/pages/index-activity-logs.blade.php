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
                            <th>Title</th>
                            <th>Type</th>
                            <th>Case Id</th>
                            <th>Email</th>
                            <th>Activity</th>
                            <th>Ip Address</th>
                            <th>Location</th>
                            <th>Referrer</th>
                            <th>Date / Time</th>
                        </tr>
                    </thead>
                    <tbody>
                       @forelse ($activityLogs as $key => $item)
                            <tr>
                                <td>{{ $item->title }}</td>
                                <td>{{ $item->type }}</td>
                                <td>{{ $item->case_id }}</td>
                                <td>{{ $item->email }}</td>
                                <td>{{ $item->activity }}</td>
                                <td>{{ $item->ip_address }}</td>
                                <td>{{ $item->location }}</td>
                                <td>{{ $item->url }}</td>
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