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
                            <p class="num">691,697 $</p>
                            <p class="text">Invested</p>
                        </div>
                    </div>
                    <div class="table-stat__right">
                        <div class="table-stat__title">Last Investments</div>
                        <dl>
                            <dt>#zizzopr****</dt>
                            <dd><i class="payment icon-adv_cash-type-3"></i> 10$</dd>
                            <dt>@Mar****</dt>
                            <dd><i class="payment icon-bitcoin-type-3"></i> 10$</dd>
                            <dt>#sky****</dt>
                            <dd><i class="payment icon-payeer-type-3"></i> 55$</dd>
                            <dt>#thanh****</dt>
                            <dd><i class="payment icon-bitcoin-type-3"></i> 100$</dd>
                            <dt>#m****</dt>
                            <dd><i class="payment icon-adv_cash-type-3"></i> 500$</dd>
                            <dt>@Mar****</dt>
                            <dd><i class="payment icon-bitcoin-type-3"></i> 10$</dd>
                            <dt>#rom****</dt>
                            <dd><i class="payment icon-payeer-type-3"></i> 15$</dd>
                            <dt>#K****</dt>
                            <dd><i class="payment icon-bitcoin-type-3"></i> 50$</dd>
                            <dt>#Olex****</dt>
                            <dd><i class="payment icon-adv_cash-type-3"></i> 256$</dd>
                            <dt>@Anatoli****</dt>
                            <dd><i class="payment icon-adv_cash-type-3"></i> 10$</dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>
    </section>
</portfolio>
@endsection