<template>
	<md-card class="content-form">
        <md-card-header>
            <div class="md-title">Edit Company Profile</div>
        </md-card-header>
        <md-card-content class="content-body">
            <div class="col-md-12 sec-block">
                <dl class="dl-horizontal">
                    <dt>Address</dt>
                    <dd>
                        <div class="form-group">
                            <input type="text" class="form-control" v-model="data.address">
                        </div>
                    </dd>
                </dl>
                <dl class="dl-horizontal">
                    <dt>Email</dt>
                    <dd>
                        <div class="form-group">
                            <input type="text" class="form-control" v-model="data.email">
                        </div>
                    </dd>
                </dl>
                <dl class="dl-horizontal">
                    <dt>Phone</dt>
                    <dd>
                        <div class="form-group">
                            <input type="text" class="form-control" v-model="data.phone">
                        </div>
                    </dd>
                </dl>
                <dl class="dl-horizontal">
                    <dt>Bitcoin address</dt>
                    <dd>
                        <div class="form-group">
                            <input type="text" class="form-control" v-model="data.bitcoin_address">
                        </div>
                    </dd>
                </dl>
            </div>
        </md-card-content>
        <md-card-actions class="space-between">
            <md-button class="md-primary" @click.native="save()">Save</md-button>
            <md-button class="md-primary" @click.native="closeForm()">Close</md-button>
        </md-card-actions>
    </md-card>
</template>

<script>
import Api from '../../api/Api'
import _mixin from '../../core/mixins/table'

export default{

    mixins: [_mixin],

    props: [ 'data' ],

    methods:{
        save(){
            Api.put('company/profile', this.data).then(
                (response) => {
                    this.closeForm();
                }
            );
        }
    }
}
</script>