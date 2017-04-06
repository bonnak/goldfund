<template>
	<md-card class="content-form">
        <md-card-header>
            <div class="md-title">Forex Trading</div>
        </md-card-header>
        <md-card-content class="content-body">
            <div class="col-md-12 sec-block">
                <div class="form-group">
                    <froala :tag="'textarea'" v-model="model.description"></froala>
                </div>
            </div>
        </md-card-content>
        <md-card-actions class="space-between">
            <md-button class="md-primary" @click.native="save(model)">Save</md-button>
        </md-card-actions>
    </md-card>
</template>

<script>
import _mixin from '../../../core/mixins/table'
import Api from '../../../api/Api'

export default{

    mixins: [_mixin],

    data () {
        return {
            model: {}
        }
    },

    created(){
        Api.get('page/service/forex-trading').then((response) => {
            this.model = response.data;
        });
    },

    mounted(){
    },

    methods:{
        save(model){
            Api.put('page/service/forex-trading', model).then((response) => {
                this.$notify({
                    message: 'Save successfully',
                    type: 'success'
                });
            });
        }
    }
}
</script>

