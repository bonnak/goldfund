<template>
	<md-card class="content-form">
		<md-card-header>
      <div class="md-title">Customer Information Detail</div>
    </md-card-header>
		<md-card-content class="content-body">
      <div class="col-md-12 sec-block">
      	<dl class="dl-horizontal">
      		<dt>Username</dt>
      		<dd>{{ data.username }}</dd>
    		</dl>
    		<dl class="dl-horizontal">
      		<dt>First Name</dt>
      		<dd>{{ data.first_name }}</dd>
    		</dl>
    		<dl class="dl-horizontal">
      		<dt>Last Name</dt>
      		<dd>{{ data.last_name }}</dd>
    		</dl>
    		<dl class="dl-horizontal">
      		<dt>Gender</dt>
      		<dd>{{ data.gender | sex }}</dd>
    		</dl>
    		<dl class="dl-horizontal">
      		<dt>Country</dt>
      		<dd>{{ data.country.name }}</dd>
    		</dl>
    		<dl class="dl-horizontal">
      		<dt>Date of Birth</dt>
      		<dd>{{ data.date_of_birth }}</dd>
    		</dl>
    		<dl class="dl-horizontal">
      		<dt>Email</dt>
      		<dd v-if="!show_edit_email">
      				{{ data.email }}
      				<a href="#" @click.prevent.stop="show_edit_email = true"><i class="fa fa-pencil"></i></a>
      		</dd>
      		<dd v-if="show_edit_email">
      				<input type="text" v-model="data.email" />
      				<a href="#" @click.prevent.stop="editEmail(data)"><i class="fa fa-save"></i></a>
      				<span style="color: red" v-if="validation.email != ''">{{ validation.email }}</span>
      		</dd>
    		</dl>
				<dl class="dl-horizontal">
      		<dt>Sponsor</dt>
      		<dd>{{ data.sponsor !== null ? data.sponsor.username : '' }}</dd>
    		</dl>
    		<dl class="dl-horizontal">
      		<dt>Address Bitcoin</dt>
      		<dd v-if="!show_edit_bitcoin_account">
      				{{ data.bitcoin_account }}
      				<a href="#" @click.prevent.stop="show_edit_bitcoin_account = true"><i class="fa fa-pencil"></i></a>
      		</dd>
      		<dd v-if="show_edit_bitcoin_account">
      				<input type="text" v-model="data.bitcoin_account" />
      				<a href="#" @click.prevent.stop="editBitCoinAddress(data)"><i class="fa fa-save"></i></a>
      				<span style="color: red" v-if="validation.bitcoin_account != ''">{{ validation.bitcoin_account }}</span>
      		</dd>
    		</dl>
      </div>
    </md-card-content>
    <div>
      <md-tabs class="md-transparent">
        <md-tab md-label="Daily Earning">
          <md-table>
            <md-table-header>
              <md-table-row>
                <md-table-head>Amount</md-table-head>
                <md-table-head>Status</md-table-head>
                <md-table-head>Created Date</md-table-head>
              </md-table-row>
            </md-table-header>
            <md-table-body>
              <md-table-row v-for="earning in daily_earning">
                <md-table-cell>{{ earning.amount | currency }}</md-table-cell>
                <md-table-cell>
                  <span class="label label-sm label-warning" v-if="earning.status == 0">Pending</span>
                  <span class="label label-sm label-success" v-if="earning.status == 1">Approved</span>
                </md-table-cell>
                <md-table-cell>{{ earning.created_at }}</md-table-cell>
              </md-table-row>
            </md-table-body>
          </md-table>
        </md-tab>
        <md-tab md-label="Direct Earning">
          <md-table>
            <md-table-header>
              <md-table-row>
                <md-table-head>Amount</md-table-head>
                <md-table-head>Status</md-table-head>
                <md-table-head>From</md-table-head>
                <md-table-head>Created Date</md-table-head>
              </md-table-row>
            </md-table-header>
            <md-table-body>
              <md-table-row v-for="earning in direct_earning">
                <md-table-cell>{{ earning.amount | currency }}</md-table-cell>
                <md-table-cell>
                  <span class="label label-sm label-warning" v-if="earning.status == 0">Pending</span>
                  <span class="label label-sm label-success" v-if="earning.status == 1">Approved</span>
                </md-table-cell>
                <md-table-cell>{{ earning.deposit.owner.username }}</md-table-cell>
                <md-table-cell>{{ earning.created_at }}</md-table-cell>
              </md-table-row>
            </md-table-body>
          </md-table>
        </md-tab>
        <md-tab md-label="Level Earning">
          <md-table>
            <md-table-header>
              <md-table-row>
                <md-table-head>Amount</md-table-head>
                <md-table-head>Status</md-table-head>
                <md-table-head>Level</md-table-head>
                <md-table-head>From</md-table-head>
                <md-table-head>Created Date</md-table-head>
              </md-table-row>
            </md-table-header>
            <md-table-body>
              <md-table-row v-for="earning in level_earning">
                <md-table-cell>{{ earning.amount | currency }}</md-table-cell>
                <md-table-cell>
                  <span class="label label-sm label-warning" v-if="earning.status == 0">Pending</span>
                  <span class="label label-sm label-success" v-if="earning.status == 1">Approved</span>
                </md-table-cell>
                <md-table-cell>{{ earning.level_number }}</md-table-cell>
                <md-table-cell>{{ earning.deposit.owner.username }}</md-table-cell>
                <md-table-cell>{{ earning.created_at }}</md-table-cell>
              </md-table-row>
            </md-table-body>
          </md-table>
        </md-tab>
        <md-tab md-label="Binary Earning">
          <md-table>
            <md-table-header>
              <md-table-row>
                <md-table-head>Amount</md-table-head>
                <md-table-head>Status</md-table-head>
                <md-table-head>Left</md-table-head>
                <md-table-head>Right</md-table-head>
                <md-table-head>Created Date</md-table-head>
              </md-table-row>
            </md-table-header>
            <md-table-body>
              <md-table-row v-for="earning in binary_earning">
                <md-table-cell>{{ earning.amount | currency }}</md-table-cell>
                <md-table-cell>
                  <span class="label label-sm label-warning" v-if="earning.status == 0">Pending</span>
                  <span class="label label-sm label-success" v-if="earning.status == 1">Approved</span>
                </md-table-cell>
                <md-table-cell>{{ earning.left_child.username }}</md-table-cell>
                <md-table-cell>{{ earning.right_child.username }}</md-table-cell>
                <md-table-cell>{{ earning.created_at }}</md-table-cell>
              </md-table-row>
            </md-table-body>
          </md-table>
        </md-tab>
        <md-tab md-label="Withdrawal">
          <md-table>
            <md-table-header>
              <md-table-row>
                <md-table-head>Amount</md-table-head>
                <md-table-head>Status</md-table-head>
                <md-table-head>Created Date</md-table-head>
              </md-table-row>
            </md-table-header>
            <md-table-body>
              <md-table-row v-for="withdrawal in withdrawals">
                <md-table-cell>{{ withdrawal.amount | currency }}</md-table-cell>
                <md-table-cell>
                  <span class="label label-sm label-warning" v-if="withdrawal.status == 0">Pending</span>
                  <span class="label label-sm label-success" v-if="withdrawal.status == 1">Approved</span>
                  <span class="label label-sm label-danger" v-if="withdrawal.status == 2">Canceled</span>
                  <span class="label label-sm label-danger" v-if="withdrawal.status == 3">Canceled by user</span>
                </md-table-cell>
                <md-table-cell>{{ withdrawal.created_at }}</md-table-cell>
              </md-table-row>
            </md-table-body>
          </md-table>
        </md-tab>
        </md-tab>
      </md-tabs>
    </div>
    <md-card-actions>
	    <md-button class="md-primary" @click.native="closeForm()">Close</md-button>
	  </md-card-actions>
  </md-card>
</template>

<script>
import { mapActions } from 'vuex'
import _mixin from '../../core/mixins/table'
import Api from '../../api/Api'

export default{

	mixins: [_mixin],

	props: ['data'],

	data(){
		return {
			show_edit_email: false,
			show_edit_bitcoin_account: false,
			validation: {
				email: '',
				bitcoin_account: ''
			},
      daily_earning : [],
      direct_earning : [],
      level_earning : [],
      binary_earning : [],
      withdrawals : []
		}
	},

  created(){
    Api.get('customer/' + this.data.id + '/earning/daily').then(response => {
      this.daily_earning = response.data;
    });

    Api.get('customer/' + this.data.id + '/earning/direct').then(response => {
      this.direct_earning = response.data;
    });

    Api.get('customer/' + this.data.id + '/earning/level').then(response => {
      this.level_earning = response.data;
    });

    Api.get('customer/' + this.data.id + '/earning/binary').then(response => {
      this.binary_earning = response.data;
    });

    Api.get('customer/' + this.data.id + '/withdrawals').then(response => {
      this.withdrawals = response.data;
    });
  },

	methods:{
		editEmail(data){
			this.saveEmail(data).then(
				(response) => {
					this.show_edit_email = false;
					this.validation.email = '';
				},
				(err_response) => {
					this.validation.email = err_response.data.error;
				}
			);
		},

		editBitCoinAddress(data){
			this.saveBitCoinAddress(data).then(
				(response) => {
					this.show_edit_bitcoin_account = false;
					this.validation.bitcoin_account = '';
				},
				(err_response) => {
					this.validation.bitcoin_account = err_response.data.error;
				}
			);
		},

		...mapActions({
  		saveEmail: 'customer/editEmail',
  		saveBitCoinAddress: 'customer/editBitCoinAddress'
  	})
	}
}
</script>


<style lang="scss" scoped>
.sec-block{
	padding: 0;
}
</style>