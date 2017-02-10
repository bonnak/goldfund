<template>
  <section class="live">
    <div class="">
        <div class="">
            <div class="row">
                <div class="col-md-4">
                    <h4>Last Registrations</h4>
                    <br/>
                    <dl>
                        <template v-for="customer in customers">
                            <div class="col-md-6 col-xs-6 align-left">
                                {{ customer.created_at | moment('from') }}
                            </div>
                            <div class="col-md-6 col-xs-6 align-left">
                                {{ customer.username }}
                            </div>
                        </template>
                    </dl>
                </div>
                <div class="col-md-4">
                    <br/>
                    <div class="stat">
                        <p class="num">95</p>
                        <p class="text">Days Online</p>
                    </div>
                    <div class="stat">
                        <p class="num">{{ total_member }}</p>
                        <p class="text">Members</p>
                    </div>
                    <div class="stat">
                        <p class="num">{{ invested_capital }}$</p>
                        <p class="text">Invested</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <h4>Last Investments</h4>
                    <br/>
                    <dl>
                        <template v-for="last_deposit in last_deposits">
                            <div class="col-md-6 col-xs-6 align-left">
                                {{ last_deposit.owner.username }}
                            </div>
                            <div class="col-md-6 col-xs-6 align-left">
                                {{ last_deposit.amount }}$
                            </div>
                        </template>
                    </dl>
                </div>
            </div>
        </div>
    </div>
	</section>
</template>
<script>
    export default {
    		name: 'LivePorfolio',

    		data(){
    			return {
	    			customers: [],
	        	total_member: 0,
	          last_deposits: [],
	          invested_capital: 0
	        }
    		},

    		created(){
    			Axios.get('api/portfolio/live').then( response => {

    				var data = response.data;

    				data.customers.forEach(el => {
    					this.customers.push(el);
    				});

    				data.last_deposits.forEach(el => {
    					this.last_deposits.push(el);
    				});
    				
	        	    this.total_member = data.total_member;
	                this.invested_capital = data.invested_capital;

    			});
    		},

        mounted() {
            this.listenWhenRegisteredNewMember();
            this.listenWhenMemberDeposit();
        },

        methods: {
            listenWhenRegisteredNewMember(){
                Echo.channel('customer.registerd')
                .listen('NewMemberRegistered', event => {
                    console.log(event);
                    this.customers.splice(0, 0, event.data);
                    ++this.total_member;
                });
            },

            listenWhenMemberDeposit(){
                Echo.channel('customer')
                .listen('MemberDeposited', event => {
                    this.last_deposits.splice(0, 0, event.deposit);
                    this.invested_capital = parseInt(this.invested_capital) +parseInt(event.deposit.amount);
                });
            }
        }
    }
</script>

 <style>
    /*.inner {*/
        /*position: relative;*/
        /*padding: 30px 40px 130px;*/
        /*text-align: center;*/
        /*width: 700px;*/
        /*border-radius: 20px 20px 0 0;*/
        /*background: #191919;*/
    /*}*/

    /*.table-stat {*/
        /*display: -webkit-box;*/
        /*display: flex;*/
        /*position: relative;*/
        /*z-index: 1;*/
    /*}*/

    /*.table-stat__left {*/
        /*width: 33%;*/
    /*}*/

    /*.table-stat__right {*/
        /*width: 33%;*/
    /*}*/

    /*.table-stat__title {*/
        /*text-transform: uppercase;*/
        /*font-size: 17px;*/
        /*text-align: center;*/
        /*margin-bottom: 10px;*/
    /*}*/

    /*.table-stat dl {*/
        /*display: -webkit-box;*/
        /*display: flex;*/
        /*flex-wrap: wrap;*/
        /*text-align: left;*/
        /*font-size: 11px;*/
        /*font-weight: 400;*/
    /*}*/

    /*.table-stat dl dt {*/
        /*margin: 0;*/
        /*padding: 0;*/
        /*font-weight: 300;*/
        /*line-height: 20px;*/
    /*}*/

    /*.table-stat__left dt {*/
        /*width: 40%;*/
        /*color: #c6c6c6;*/
    /*}*/

    /*.table-stat dl dd {*/
        /*margin: 0;*/
        /*padding: 0;*/
        /*font-weight: 400;*/
        /*line-height: 20px;*/
    /*}*/

    /*.table-stat__left dd {*/
        /*width: 60%;*/
        /*color: #6dc3f5;*/
    /*}*/

    /*dl {*/
        /*margin-top: 0;*/
        /*margin-bottom: 20px;*/
    /*}*/



    /*.table-stat__center {*/
        /*width: 34%;*/
        /*padding-top: 24px;*/
    /*}*/

    /*.table-stat__center .stat {*/
        /*margin-bottom: 27px;*/
    /*}*/

    /*.table-stat__center .num {*/
        /*color: #fff;*/
        /*font-size: 21px;*/
        /*margin: 0 0 3px;*/
        /*line-height: 1;*/
    /*}*/

    /*.table-stat__center .text {*/
        /*color: #6dc3f5;*/
        /*font-weight: 300;*/
        /*margin: 0;*/
        /*font-size: 15px;*/
    /*}*/

    /*.table-stat__right dt {*/
        /*width: 60%;*/
        /*color: #6dc3f5;*/
    /*}*/

    /*.table-stat__right dd {*/
        /*color: #c6c6c6;*/
        /*width: 40%;*/
    /*}*/

    /*.table-stat__right .table-stat__title,*/
    /*.table-stat__right dl{*/
        /*text-align: right;*/
    /*}*/
     .live{
         background-color: rgba(0,0,0,0.6);
         padding-top: 20px;
         color: #fff;
         border-radius: 5px;
     }
     .align-left{
         text-align: left;
     }
</style>