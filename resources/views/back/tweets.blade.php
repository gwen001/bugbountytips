@extends('layout')


@section('css')
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css">
<style>
    #exampleModalCenter textarea {
        width: 100%;
    }
</style>
@endsection


@section('content')
<div class="container">
    <div class="row p-3"></div>
    <div class="row">
        <div class="col-5">
            <div class="row">
                <div class="col-12">
                    <div id="logo">
                        <h1><span class="text-primary">#</span>bugbountytips</h1>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row p-4"></div>
    <div class="row">
        <div class="col-6">
            <form method="POST" action="{{ route('tweets.store') }}">
                @csrf
                <div class="form-group row">
                    <label for="q" class="col-1 col-form-label">ID:</label>
                    <div class="col-3">
                        <input type="text" class="form-control" id="twitter_id" name="twitter_id">
                    </div>
                    <div class="col-3">
                        <button type="submit" id="btn-search" class="btn btn-primary">Add tweet</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="row p-4"></div>
    <div class="row">
        <div class="col-12">
            {{ $dataTable->table(['class' => 'table table-bordered table-hover table-sm'], true) }}
        </div>
    </div>

<!-- Modal -->
<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <form method="POST" action="{{ route('tweet.update') }}">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalCenterTitle">Edit tweet #</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    </div>
                    <div class="modal-body">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="id" value="">
                            <textarea rows="5" name="message"></textarea>
                    </div>
                    <div class="modal-footer">
                    <button type="button" class="btn btn-cancel btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-confirm btn-primary">Save changes</button>
                </div>
            </div>
        </div>
    </form>
</div>

</div>
@endsection


@section('js')
<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.bundle.min.js"></script>

<script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js"></script>
{{ $dataTable->scripts() }}
<script type="text/javascript">
    $(document).ready(function(){
        document.getElementById('twitter_id').focus();

        $('#exampleModalCenter').on('shown.bs.modal', function(e) {
            var button = $(e.relatedTarget);
            var id = button.parent().parent().find('a:nth-child(1)').html();
            var msg = button.parent().parent().find('td:nth-child(2)').html();
            $(this).find('input[name="id"]').val( id );
            $(this).find('textarea').val( msg+' ' );
            $(this).find('textarea').focus();
        })

        $('#exampleModalCenter').on('hide.bs.modal', function(e) {
            $(this).find('form').trigger('reset');
        })

        // $('#exampleModalCenter .btn-confirm').click(function(){
        //     alert(1);
        // });
    });
</script>
@endsection

