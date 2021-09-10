@if (session('flash_message'))
    <div class="fixed-top mt-5 container">
        <div class="alert alert-dismissable fade show my-3">
            {{ session('flash_message') }}
            <button class="close" data-dismiss="alert">x</button>
        </div>
    </div>
@endif