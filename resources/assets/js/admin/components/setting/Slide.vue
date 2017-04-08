<template>
	<md-card class="content-form">
        <md-card-header>
            <div class="md-title">Slide</div>
        </md-card-header>
        <md-card-content class="content-body">
            <div class="col-md-12 sec-block">
                <md-table>
                  <md-table-header>
                    <md-table-row>
                      <md-table-head>Image</md-table-head>
                      <md-table-head>Order</md-table-head>
                      <md-table-head>Action</md-table-head>
                    </md-table-row>
                  </md-table-header>

                  <md-table-body>
                    <md-table-row v-for="(slide, index) in slides" :key="slide.order">
                        <md-table-cell><img :src="slide.image" style="width: 200px;"></md-table-cell>
                        <md-table-cell><input type="text" v-model="slide.order"></input></md-table-cell>                      
                        <md-table-cell class="flex-end-action">
                            <md-button 
                                class="md-fab md-primary md-mini btn-action"
                                @click.native="updateSlide(slide)">
                                    <i class="fa fa-check"></i>
                                    <md-tooltip md-direction="top">Upate order</md-tooltip>
                            </md-button>
                            <md-button 
                                class="md-fab md-danger md-mini btn-action"
                                @click.native="deleteSlide(slide, index)">
                                    <i class="fa fa-trash"></i>
                                    <md-tooltip md-direction="top">Delete</md-tooltip>
                            </md-button>
                        </md-table-cell>
                    </md-table-row>
                  </md-table-body>
                </md-table>
            </div>
        </md-card-content>
        <md-card-actions class="space-between">
            <form method="POST">
                <input type="file" accept="image/*" name="slide" id="slide" style="display: none;">
                <md-button class="md-primary" @click.native="addNew()">Add New</md-button>
            </form>
        </md-card-actions>
    </md-card>
</template>

<script>
import _mixin from '../../core/mixins/table'
import Api from '../../api/Api'

export default{

    mixins: [_mixin],

    data () {
        return {
            slides: []
        }
    },

    created(){
        Api.get('setting/slide').then((response) => {
            this.slides = response.data;
        });
    },

    mounted(){
        $('#slide').change(() => {
            var formData = new FormData();
            formData.append('slide', $('#slide')[0].files[0]);

            const config = {
                headers: { 
                    'content-type': 'multipart/form-data'
                }
            };
            
            Api.post('setting/slide', formData, config).then((response) => {
                this.$notify({
                    message: 'Save successfully',
                    type: 'success'
                });

                this.slides.push(response.data);
            },(err_response) => {
                this.$notify({
                    message: 'Fail to add new slide',
                    type: 'error'
                });
            });
        });
    },

    methods:{
        addNew(){     
            $('#slide').trigger('click');    
        },

        deleteSlide(slide, index){
            Api.delete('setting/slide/' + slide.id).then((response) => {
                this.$notify({
                    message: 'Delete successfully',
                    type: 'success'
                });

                this.slides.splice(index, 1);
            },(err_response) => {
                this.$notify({
                    message: 'Fail to delete slide',
                    type: 'error'
                });
            });
        },

        updateSlide(slide){
            Api.put('setting/slide/', slide).then((response) => {
                this.$notify({
                    message: 'Update successfully',
                    type: 'success'
                });

                this.slides.splice(0, this.slides.length);
                this.slides = response.data;
            },(err_response) => {
                this.$notify({
                    message: 'Fail to update slide',
                    type: 'error'
                });
            });
        }
    }
}
</script>

