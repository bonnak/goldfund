<template>
	<md-card class="content-form">
        <md-card-header>
            <div class="md-title">Edit Company Profile</div>
        </md-card-header>
        <md-card-content class="content-body">
            <div class="col-md-12 sec-block">
                <dl class="dl-horizontal">
                    <dt>Name</dt>
                    <dd>
                        <div class="form-group">
                            <input type="text" class="form-control" v-model="data.name">
                        </div>
                    </dd>
                </dl>
                <dl class="dl-horizontal">
                    <dt>Min Deposit</dt>
                    <dd>
                        <div class="form-group">
                            <input type="text" class="form-control" v-model="data.min_deposit">
                        </div>
                    </dd>
                </dl>
                <dl class="dl-horizontal">
                    <dt>Max Deposit</dt>
                    <dd>
                        <div class="form-group">
                            <input type="text" class="form-control" v-model="data.max_deposit">
                        </div>
                    </dd>
                </dl>
                <dl class="dl-horizontal">
                    <dt>Daily</dt>
                    <dd>
                        <div class="form-group">
                            <input type="text" class="form-control" v-model="data.daily">
                        </div>
                    </dd>
                </dl>
                <dl class="dl-horizontal">
                    <dt>Binary</dt>
                    <dd>
                        <div class="form-group">
                            <input type="text" class="form-control" v-model="data.pairing">
                        </div>
                    </dd>
                </dl>
                <dl class="dl-horizontal">
                    <dt>Sponsor</dt>
                    <dd>
                        <div class="form-group">
                            <input type="text" class="form-control" v-model="data.sponsor">
                        </div>
                    </dd>
                </dl>
                <dl class="dl-horizontal">
                    <dt>Level</dt>
                    <dd v-for="level in data.sponsor_levels">
                        <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-addon">{{ level.level }}</span>
                                <input type="text" class="form-control" v-model="level.commission">
                            </div>
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
            Api.put('plan/edit', this.data).then(
                (response) => {
                    this.closeForm();
                }
            );
        }
    }
}
</script>