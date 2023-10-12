@extends('layout.app')

@section('content')
<div class="content mt-3">
    <div class="animated fadeIn">
        <div class="card">
            <div class="card-header">
                <div class="pull-left">
                    Tambah Data Kolektor
                </div>
                <div class="pull-right">
                    <a href="{{ url('dKolektor') }}" class="btn btn-secondary btn-sm">
                        <i class="fa fa-undo"></i> Back
                    </a>
                </div>
            </div>

            <div class="card-body">
                <div class="row">
                    <!-- <div id="map" style=" width: 80% ; height: 400px; margin-bottom: 20px; margin-right: 20px;"></div> -->
                    <div class="col-md-4 offset-md-1">
                        <form action="{{ url('addorg') }}" method="post">
                            @csrf
                            <div class="form-group">
                                <label class="">Name:</label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" name="name_org" placeholder="Masukan Nama Organisasi" value="{{ old('name_org') }}" required>
                                @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label>Lead: <span class="text-danger">*</span></label>
                                <select type="text" class="form-control @error('lead_role') is-invalid @enderror" name="lead_role" required>
                                    <option value="">Pilih</option>
                                    <option value="A1-dammy">A1-dammy</option>
                                    <option value="A2-dammy">A2-dammy</option>
                                    <option value="A3-dammy">A3-dammy</option>
                                    <option value="A4-dammy">A4-dammy</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label class="">Description:</label>
                                <textarea class="form-control @error('description') is-invalid @enderror" rows="3" name="description" placeholder="Description" value="{{ old('description') }}" required> </textarea>
                            </div>
                            <div class="form-group">
                                <label>Upper Unit: <span class="text-danger">*</span></label>
                                <select type="text" class="form-control @error('legal_standing') is-invalid @enderror" name="legal_standing" required>
                                    <option>
                                        pilih
                                    </option>
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                    <option value="5">5</option>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-success">Save</button><br><br>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>




</script>
@endsection