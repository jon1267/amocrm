<div class="row">
    <div class="col-md-12">
        <div class="tile">
            <section class="invoice">
                <div class="row mb-4">
                    <div class="col-12">
                        <h4 class="line-head"><i class="fa fa-globe"></i> Load Amo Data</h4>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12 table-responsive">
                        <table class="table table-striped">
                            <thead>
                            <tr>
                                <th>Contact ID</th>
                                <th>Name</th>
                                <th>Responsible</th>
                                <th>Created By</th>
                                <th>Created at Amo</th>
                            </tr>
                            </thead>
                            <tbody>

                            @if(isset($contacts) && count($contacts))
                                @foreach($contacts as $contact)
                                    <tr>
                                        <td>{{ $contact->contact_id }}</td>
                                        <td>{{ $contact->name }}</td>
                                        <td>{{ $contact->responsible_user_id }}</td>
                                        <td>{{ $contact->created_by }}</td>
                                        <td>{{ $contact->amo_created_time }}</td>
                                    </tr>
                                @endforeach
                            @else
                                <tr><td>Contacts table are empty now.</td></tr>
                            @endif

                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="row d-print-none mt-2">
                    <!-- <div class="col-12 text-right"> -->
                    <div class="col-12 text-left">
                        <!-- <a class="btn btn-primary" href="javascript:window.print();" target="_blank"><i class="fa fa-print"></i> Load</a> -->
                        <a href="{{ route('amo.auth') }}" class="btn btn-primary" > Auth</a>

                        <a href="{{ route('amo.upload') }}" class="btn btn-primary" ><i class="fa fa-fw fa-lg fa-check-circle"></i> Load</a>
                    </div>
                </div>
            </section>
        </div>
    </div>
</div>