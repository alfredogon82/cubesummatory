@extends('layouts.app')
@section('content')
<div class="col-md-4 col-md-offset-4">
    <div class="form-group">
        <form action="/cubeSummatory" method="POST">

            <div class="form-group">
                <label for="tamano">Numero de casos:</label>
                <div class="form-group">
                  <select class="form-control" id="numero" name="numero">
                    @for ($i=1; $i <= 50 ; $i++)
                        <option @if ($i=="2") selected @endif value="{{ $i }}">{{ $i }}</option>
                    @endfor
                  </select>
                </div>
            </div>
            <label for="cubeInput">Insertar Valores:</label>
            <textarea class="form-control" id="cubeInput" name="cubeInput" rows="15">
            4 5
            UPDATE 2 2 2 4
            QUERY 1 1 1 3 3 3
            UPDATE 1 1 1 23
            QUERY 2 2 2 4 4 4
            QUERY 1 1 1 3 3 3
            2 4
            UPDATE 2 2 2 1
            QUERY 1 1 1 1 1 1
            QUERY 1 1 1 2 2 2
            QUERY 2 2 2 2 2 2
            </textarea>
            <button type="submit" class="btn btn-default">Submit</button>
            {{ csrf_field() }}
        </form>
      </div>
</div>
@endsection

