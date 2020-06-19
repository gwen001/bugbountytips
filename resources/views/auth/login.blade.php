@extends('layout')

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
            <div class="col-3">
                <form action="{{ route('login') }}" method="POST">
                    @csrf
                    <div class="form-group row">
                        <label for="staticEmail" class="col-sm-2 col-form-label">Login:</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="login" name="login" value="">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="inputPassword" class="col-sm-2 col-form-label">Password:</label>
                        <div class="col-sm-10">
                            <input type="password" class="form-control" name="password" value="">
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary">Login</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('js')
<script type="text/javascript">
    document.getElementById('login').focus();
</script>
@endsection
