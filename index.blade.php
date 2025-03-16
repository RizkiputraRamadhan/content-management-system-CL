@extends('layouts.admin.app')
@section('title', $page)
@push('styles')
@endpush
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3 class="panel-title">Management {{ $page }}</h3>
                </div>
                <div class="panel-body">
                    <div class="panel-action">
                        <a href="#" class="btn btn-success btn-sm ">
                            <i class="fa fa-plus"></i> Tambah Data
                        </a>
                    </div>
                    <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap"
                        cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th>First name</th>
                                <th>Last name</th>
                                <th>Position</th>
                                <th>Office</th>
                                <th>Age</th>
                                <th>Start date</th>
                                <th>Salary</th>
                                <th>Extn.</th>
                                <th>E-mail</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Tiger</td>
                                <td>Nixon</td>
                                <td>System Architect</td>
                                <td>Edinburgh</td>
                                <td>61</td>
                                <td>2011/04/25</td>
                                <td>$320,800</td>
                                <td>5421</td>
                                <td>t.nixon@datatables.net</td>
                            </tr>
                            <tr>
                                <td>Garrett</td>
                                <td>Winters</td>
                                <td>Accountant</td>
                                <td>Tokyo</td>
                                <td>63</td>
                                <td>2011/07/25</td>
                                <td>$170,750</td>
                                <td>8422</td>
                                <td>g.winters@datatables.net</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div> 
@endsection
@push('scripts')
@endpush