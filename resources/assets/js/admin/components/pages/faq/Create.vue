<template>
	<md-card class="content-form">
        <md-card-header>
            <div class="md-title">Create Faq</div>
        </md-card-header>
        <md-card-content class="content-body">
            <div class="col-md-12 sec-block">
                <dl class="dl-horizontal">
                    <dt>Question</dt>
                    <dd>
                        <div class="form-group">
                            <input type="text" class="form-control" v-model="model.question">
                        </div>
                    </dd>
                </dl>
                <dl class="dl-horizontal">
                    <dt>Answer</dt>
                    <dd>
                        <div class="form-group">
                            <textarea class="form-control" v-model="model.answer" style="height: 200px;"></textarea>                            
                        </div>
                    </dd>
                </dl>
            </div>
        </md-card-content>
        <md-card-actions class="space-between">
            <md-button class="md-primary" @click.native="save(model)">Save</md-button>
            <md-button class="md-primary" @click.native="closeForm()">Close</md-button>
        </md-card-actions>
    </md-card>
</template>

<script>
import { mapGetters, mapActions } from 'vuex'
import _mixin from '../../../core/mixins/table'

export default{

    mixins: [_mixin],

    data () {
        return {
            model: {
                question: '',
                answer: ''
            }
        }
    },

    mounted(){
    },

    methods:{
        ...mapActions({
            create: 'faq/create'
        }),

        save(model){
            this.create(model).then((response) => {
                this.closeForm();
            });
        }
    }
}
</script>