@props(['main_title' => 'main_title', 'main_page' => 'main_page', 'page' => 'page'])
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">{{ Str::ucfirst($main_title) }}</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">{{ Str::ucfirst($main_page) }}</a></li>
                    <li class="breadcrumb-item active">{{ Str::ucfirst($page) }}</li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
