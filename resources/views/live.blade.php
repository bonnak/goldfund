@extends('layouts.app')
@section('content')
<portfolio inline-template>
    <section class="focus">
        <div class="container">
            <div class="inner">
                <div class="table-stat">
                    <div class="table-stat__left">
                        <div class="table-stat__title">Last Registrations</div>
                        <dl>
                            @foreach ($customers as $customer)
                                <dt>{{ $customer->created_at->diffForHumans() }}</dt>
                                <dd>{{ $customer->username }}</dd>
                            @endforeach
                        </dl>
                    </div>
                    <div class="table-stat__center">
                        <div class="stat">
                            <p class="num">95</p>
                            <p class="text">Days Online</p>
                        </div>
                        <div class="stat">
                            <p class="num">{{ $total_member }}</p>
                            <p class="text">Members</p>
                        </div>
                        <div class="stat">
                            <p class="num">{{ $invested_capital }}$</p>
                            <p class="text">Invested</p>
                        </div>
                    </div>
                    <div class="table-stat__right">
                        <div class="table-stat__title">Last Investments</div>
                        <dl>
                            @foreach ($last_deposits as $last_deposit)
                                <dt>{{ $last_deposit->owner->username }}</dt>
                                <dd>{{ $last_deposit->amount }}$</dd>
                            @endforeach
                        </dl>
                    </div>
                </div>
            </div>
        </div>
    </section>
</portfolio>
@endsection