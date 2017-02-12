@extends('layouts.app')

@section('content')

    <section class="focus" id="focus">
        <div class="container">
            <div class="row">
                <div class="col-md-8 col-md-offset-2">
                    <div class="panel panel-default">
                        <div class="panel-heading">Deposit</div>
                        <div class="panel-body">
                            <form class="form-horizontal" role="form" method="POST" action="{{ route('deposit')}}" enctype="multipart/form-data">
                                {{ csrf_field() }}

                                <div class="form-group{{ $errors->has('plan_id') ? ' has-error' : '' }}">
                                    <label for="plan_id" class="col-md-4 control-label">Plan</label>

                                    <div class="col-md-6">
                                        <select id="plan_id"
                                                class="form-control"
                                                name="plan_id">
                                            <option value="">...Select...</option>
                                            @foreach($plans as $plan)
                                            <option value="{{ $plan->id }}" {{ old('plan_id') == $plan->id ? 'selected' : ''}}>{{ $plan->name }}</option>
                                            @endforeach
                                        </select>

                                        @if ($errors->has('plan_id'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('plan_id') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group{{ $errors->has('amount') ? ' has-error' : '' }}">
                                    <label for="amount" class="col-md-4 control-label">Amount</label>

                                    <div class="col-md-6">
                                        <input id="amount" type="text"
                                               class="form-control" name="amount"
                                               value="{{ old('amount') }}" >

                                        @if ($errors->has('amount'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('amount') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="admin_account" class="col-md-4 control-label">Admin account</label>
                                    <div class="col-md-6">
                                        <img src="{{ $admin_qr_account }}" id="admin_account"/>
                                        <div>{{ $admin_account }}</div>
                                    </div>
                                </div>

                                <div class="form-group{{ $errors->has('invoice_attachment') ? ' has-error' : '' }}">
                                    <label for="invoice_attachment" class="col-md-4 control-label">Invoice attachment</label>

                                    <div class="col-md-6">
                                        <input id="invoice_attachment" type="file"
                                               class="form-control" name="invoice_attachment"
                                               value="{{ old('invoice_attachment') }}" >

                                        @if ($errors->has('invoice_attachment'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('invoice_attachment') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="col-md-6 col-md-offset-4">
                                        <button type="submit" class="btn btn-primary">
                                            Deposit
                                        </button>
                                    </div>
                                </div>
                                
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection